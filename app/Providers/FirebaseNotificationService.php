<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

class FirebaseNotificationService
{
    protected string $projectId;
    protected string $credentialsPath;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id');
        $this->credentialsPath = base_path(config('services.firebase.credentials'));
    }

    protected function getAccessToken(): string
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $creds = new ServiceAccountCredentials($scopes, $this->credentialsPath);
        $token = $creds->fetchAuthToken();

        return $token['access_token'];
    }

    public function sendToToken(string $fcmToken, string $title, string $body, array $data = [])
    {
        $client = new Client();

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $payload = [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => $data,
            ],
        ];

        return $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type'  => 'application/json',
            ],
            'json' => $payload,
        ]);
    }
}