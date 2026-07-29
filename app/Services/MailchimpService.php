<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailchimpService
{
    /**
     * Sync subscriber with Mailchimp list
     * Status can be: 'subscribed', 'unsubscribed', 'cleaned', 'pending'
     */
    public static function syncSubscriber(string $email, string $status = 'subscribed'): bool
    {
        $apiKey = config('services.mailchimp.api_key');
        $listId = config('services.mailchimp.list_id');

        // Check if API Key or List ID is empty (Fallback to Mock Mode)
        if (empty($apiKey) || empty($listId)) {
            Log::info("[Mailchimp Mock] Syncing subscriber {$email} with status {$status} (API key not configured).");
            return true;
        }

        // Parse Mailchimp Data Center (e.g. us19 from api_key_value-us19)
        $parts = explode('-', $apiKey);
        $dc = end($parts);
        
        $emailHash = md5(strtolower(trim($email)));
        $url = "https://{$dc}.api.mailchimp.com/3.0/lists/{$listId}/members/{$emailHash}";

        try {
            // PUT request updates or creates a member in the Mailchimp Audience List
            $response = Http::withBasicAuth('key', $apiKey)
                ->put($url, [
                    'email_address' => $email,
                    'status_if_new' => $status === 'unsubscribed' ? 'unsubscribed' : 'subscribed',
                    'status' => $status
                ]);

            if ($response->successful()) {
                Log::info("[Mailchimp] Successfully synced subscriber {$email} with status {$status}.");
                return true;
            }

            Log::error("[Mailchimp] Failed to sync subscriber {$email}. Response: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("[Mailchimp Exception] Failed to connect to Mailchimp API: " . $e->getMessage());
            return false;
        }
    }
}
