<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // If no authenticated user, avoid crash
        if (!$user) {
            return Inertia::render('Web/Conversations/Conversation', [
                'conversations' => [],
                'availableLawyers' => Lawyer::with('user')->get()->map(fn($l) => [
                    'id' => $l->id,
                    'user' => ['name' => $l->user->name],
                    'profile' => $l->profile ?? '/default.png',
                    'specialty' => $l->specialty,
                    'status' => 'online',
                ]),
            ]);
        }

        // If user is logged in, fetch conversations
        $conversations = Conversation::with([
            'lawyer',
            'messages' => fn($q) => $q->latest()->limit(1)
        ])
            ->where('member_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($conv) {
                $lastMessage = $conv->messages->first();
                return [
                    'id' => $conv->id,
                    'lawyerId' => $conv->lawyer->id,
                    'lawyerName' => $conv->lawyer->user->name,
                    'lawyerAvatar' => $conv->lawyer->profile ?? '/default.png',
                    'lawyerSpecialty' => $conv->lawyer->specialty,
                    'lastMessage' => $lastMessage?->content,
                    'lastMessageTime' => $lastMessage?->created_at,
                    'unreadCount' => 0, // TODO: compute later
                    'status' => 'online',
                ];
            });

        $availableLawyers = Lawyer::with('user')->get()->map(fn($l) => [
            'id' => $l->id,
            'user' => ['name' => $l->user->name],
            'profile' => $l->profile ?? '/default.png',
            'specialty' => $l->specialty,
            'status' => 'online',
        ]);

        return Inertia::render('Web/Conversations/Conversation', [
            'conversations' => $conversations,
            'availableLawyers' => $availableLawyers,
        ]);
    }


    public function show(Request $request, Conversation $conversation)
    {
        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'content' => $m->content,
                'sender' => $m->sender->role === 'lawyer' ? 'lawyer' : 'user',
                'timestamp' => $m->created_at,
                'senderName' => $m->sender->name,
            ]);

        // Return JSON if XHR (for Vue dynamic fetch)
        if ($request->wantsJson()) {
            return response()->json($messages);
        }

        // For normal Inertia page load fallback
        return Inertia::render('Web/Conversations/Conversation', [
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, Lawyer $lawyer)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $conversation = Conversation::firstOrCreate([
            'member_id' => Auth::id(),
            'lawyer_id' => $lawyer->id,
        ]);

        // return redirect()->route('conversations')
        //     ->with('success', 'Conversation started');
    }
}
