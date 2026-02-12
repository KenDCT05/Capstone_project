<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $apiKey;
    protected string $senderName;

    public function __construct()
    {
        $this->apiKey = env('SEMAPHORE_API_KEY', 'fe5d3234d02e1a88e476a22184b35c2e');
        $this->senderName = env('SEMAPHORE_SENDER_NAME', 'CDCOC');
    }

    public function send(string $number, string $message): array
    {
        $options = [];

        if (app()->environment(['local', 'development'])) {
            $options['verify'] = false;
        }

        try {
            $response = Http::withOptions($options)->post('https://semaphore.co/api/v4/messages', [
                'apikey'     => $this->apiKey,
                'number'     => $number,
                'message'    => $message,
                'sendername' => $this->senderName,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => 'sent',
                    'error' => null
                ];
            }

            Log::error('SMS sending failed', [
                'number' => $number,
                'message' => $message,
                'response' => $response->body(),
            ]);

            return [
                'success' => false,
                'status' => 'failed',
                'error' => $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('SMS exception', [
                'number' => $number,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status' => 'failed',
                'error' => $e->getMessage()
            ];
        }
    }
}