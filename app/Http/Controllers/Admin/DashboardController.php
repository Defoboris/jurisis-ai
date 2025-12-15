<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Conversation;
use App\Models\Lawyer;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->load('lawyer');

        $authLawyer = Lawyer::where('user_id', $user->id)->first();

        // available lawyers for "start conversation" UI
        $availableLawyers = Lawyer::with('user')->get()->map(function ($l) {
            return [
                'id' => $l->id,
                'user' => ['name' => $l->user->name],
                'profile' => $l->profile ?? '/default.png',
                'specialty' => $l->specialty,
                'status' => 'online',
            ];
        });

        if (! $user) {
            return Inertia::render('Web/Conversations/Conversation', [
                'conversations' => [],
                'availableLawyers' => $availableLawyers,
            ]);
        }

        $conversations = Conversation::with([
            'member',
            'messages' => fn($q) => $q->latest()->limit(1)
        ])
            ->where('lawyer_id', $authLawyer->id)
            ->latest()
            ->get()
            ->map(function ($conv) {
                $lastMessage = $conv->messages->first();
                return [
                    'id' => $conv->id,
                    'userId' => $conv->member->id,
                    'userName' => $conv->member->name,
                    'userAvatar' => $conv->member->profile_photo_url ?? '/default.png',
                    'lastMessage' => $lastMessage?->content,
                    'lastMessageTime' => $lastMessage?->created_at,
                    'unreadCount' => 0,
                    'status' => 'online',
                ];
            });

        $authLawyer = $user;
        $authLawyer->stats = [
            'totalArticles' => Article::where('lawyer_id', $user->id)->count(),
            'totalViews' => 15420,
            'totalMessages' => Message::whereHas('conversation', function ($query) use ($user) {$query->where('lawyer_id', $user->id);})->count(),
            'totalLikes' => 892,
            'monthlyViews' => 3240,
            'profileViews' => 1847,
        ];

        $authLawyer->recentArticles = Article::where('lawyer_id', $user->id)->latest()->limit(3)->get();

        return Inertia::render('Admin/Dashboard', [
            'conversations' => $conversations,
            'availableLawyers' => $availableLawyers,
            'authLawyer' => $authLawyer
        ]);
    }
}
