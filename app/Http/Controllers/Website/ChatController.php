<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\StreamedResponse;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function index()
    {
        return Inertia::render('Web/Chat/Chat');
    }

    public function stream(Request $request): StreamedResponse
    {
        $userMessage = $request->query('message'); // from query string
        
        if (!$userMessage) {
            abort(400, 'Message required');
        }

        $messages = [
            ['role' => 'user', 'content' => $userMessage]
        ];

        return new StreamedResponse(function () use ($messages) {
            $stream = OpenAI::chat()->createStreamed([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'stream' => true,
            ]);

            foreach ($stream as $event) {
                if (isset($event->choices[0]->delta->content)) {
                    echo "data: " . $event->choices[0]->delta->content . "\n\n";
                    ob_flush();
                    flush();
                }
            }

            echo "data: [DONE]\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no', // important for nginx
        ]);
    } 
}
