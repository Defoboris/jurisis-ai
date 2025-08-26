<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeepSeekService
{
    protected string $baseUrl = 'https://api.deepseek.com/chat/completions';

    public function chat(string $message, bool $stream = false)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post($this->baseUrl, [
            "model" => "deepseek-chat",
            "messages" => [
                ["role" => "system", "content" => "You are a helpful assistant."],
                ["role" => "user", "content" => $message],
            ],
            "stream" => $stream,
        ]);

        return $response->json();
    }
}
