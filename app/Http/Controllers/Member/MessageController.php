<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\MessageRequest;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request, Conversation $conversation)
    {
        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'content'   => $request->validated()['content'],
        ]);

        // Format the message for frontend
        $formattedMessage = [
            'id'        => $message->id,
            'content'   => $message->content,
            'sender'    => $request->user()->role === 'lawyer' ? 'lawyer' : 'user',
            'timestamp' => $message->created_at,
            'senderName' => $request->user()->name,
        ];

        // Return JSON for Inertia's onSuccess
        return response()->json([
            'message' => $formattedMessage,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
