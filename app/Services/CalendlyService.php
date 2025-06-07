<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CalendlyService
{
    protected $baseUrl = 'https://api.calendly.com';
    protected $token;
    protected $eventTypeUrl;

    public function __construct()
    {
        $this->token = config('services.calendly.token');
        $this->eventTypeUrl = config('services.calendly.event_type_url');
    }

    public function generateSchedulingLink($candidate)
    {
        try {
            // Primero obtenemos el UUID del event type
            $eventTypeResponse = Http::withToken($this->token)
                ->get($this->baseUrl . '/event_types', [
                    'user' => config('services.calendly.owner'),
                    'active' => true
                ]);

            if (!$eventTypeResponse->successful()) {
                Log::error('Error fetching Calendly event types', [
                    'response' => $eventTypeResponse->json(),
                    'candidate' => $candidate->id
                ]);
                return null;
            }

            $eventTypes = $eventTypeResponse->json()['collection'];
            $eventType = collect($eventTypes)->first(function ($type) {
                return $type['slug'] === 'entrevista-laboral';
            });

            if (!$eventType) {
                Log::error('Event type not found', [
                    'candidate' => $candidate->id,
                    'slug' => 'entrevista-laboral'
                ]);
                return null;
            }

            // Ahora generamos el scheduling link con el UUID correcto
            $response = Http::withToken($this->token)
                ->post($this->baseUrl . '/scheduling_links', [
                    'max_event_count' => 1,
                    'owner' => $eventType['uri'],
                    'owner_type' => 'EventType',
                    'name' => $candidate->first_name . ' ' . $candidate->last_name,
                    'email' => $candidate->email,
                ]);

            if ($response->successful()) {
                return $response->json()['resource']['booking_url'];
            }

            Log::error('Error generating Calendly link', [
                'response' => $response->json(),
                'candidate' => $candidate->id,
                'event_type' => $eventType['uri']
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Exception generating Calendly link', [
                'error' => $e->getMessage(),
                'candidate' => $candidate->id
            ]);
            return null;
        }
    }

    public function verifyWebhookSignature($payload, $signature)
    {
        $signingKey = config('services.calendly.webhook_signing_key');
        $computedSignature = hash_hmac('sha256', $payload, $signingKey);
        return hash_equals($computedSignature, $signature);
    }
} 