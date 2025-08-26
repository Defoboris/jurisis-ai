<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::factory()
            ->withApiKey(env('OPENROUTER_API_KEY'))
            ->withBaseUri('https://openrouter.ai/api/v1') // custom base_url
            ->make();
    }

    public function chat(array $messages)
    {
        return $this->client->chat()->create([
            'model' => 'openai/gpt-4o',
            'messages' => $messages,
            'extra_headers' => [
                'HTTP-Referer' => env('APP_URL'),
                'X-Title' => env('APP_NAME'),
            ],
        ]);
    }
}
