<?php

namespace App\Http\Controllers\Website;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Models\ChatbotSession;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\StreamedResponse;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        // If the user is not authenticated → redirect to login
        // if (!auth()->check()) {
        //     return redirect()->route('login')
        //         ->with('error', 'Vous devez vous connecter pour accéder au chatbot.');
        // }

        $userId = auth()->id();

        $chatbotSession = ChatbotSession::where('user_id', $userId)->first();

        $chatbotMessages = $chatbotSession
            ? ChatbotMessage::where('chatbot_session_id', $chatbotSession->id)->get()
            : collect(); // empty collection if no session

        return Inertia::render('Web/Chat/Chat', [
            'chatbotMessages' => $chatbotMessages,
        ]);
    }

    public function stream(Request $request)
    {
        try {
            $session = ChatbotSession::firstOrCreate(
                ['user_id' => $request->user()->id],
                ['origin' => 'web', 'is_limited' => false, 'request_number' => 5]
            );

            if ($session->is_limited || $session->request_number <= 0) {
                return ApiResponse::error('Vous avez atteint le nombre maximum de requêtes', 429);
            }

            $userMessage = $request->query('message');
            if (!$userMessage) {
                return ApiResponse::error('Message required', 422);
            }

            // decrement
            $session->decrement('request_number');
            if ($session->request_number - 1 <= 0) {
                $session->is_limited = true;
                $session->save();
            }

            $userMessage = $request->query('message');

            if (!$userMessage) {
                abort(400, 'Message required');
            }

            // Save the user's message
            $chatbotMessage = new ChatbotMessage();
            $chatbotMessage->chatbot_session_id = $session->id;
            $chatbotMessage->role = 'user';
            $chatbotMessage->content = $userMessage;
            $chatbotMessage->save();

            $messages = [
                ['role' => 'user', 'content' => $userMessage]
            ];

            $streamResponse = new StreamedResponse(function () use ($messages, $chatbotMessage) {
                $stream = OpenAI::chat()->createStreamed([
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                    'stream' => true,
                ]);

                $responseText = '';

                foreach ($stream as $event) {
                    if (isset($event->choices[0]->delta->content)) {
                        $chunk = $event->choices[0]->delta->content;
                        echo "data: " . $chunk . "\n\n";
                        $responseText .= $chunk;

                        ob_flush();
                        flush();
                    }
                }

                // Save the assistant's full response after streaming
                $chatbotMessage->response = $responseText;
                $chatbotMessage->role = 'assistant';

                Log::info(json_encode($chatbotMessage));
                $chatbotMessage->save();

                echo "data: [DONE]\n\n";
                ob_flush();
                flush();
            }, 200, [
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'X-Accel-Buffering' => 'no',
            ]);

            return $streamResponse;
        } catch (\Throwable $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return ApiResponse::error('Une erreur s’est produite, veuillez réessayer plus tard.', 500);
        }
    }
}
