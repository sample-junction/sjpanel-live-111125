<?php

namespace App\Helpers;

class FirebaseHelper
{
    public static function sendNotification($token, $title, $body, $customData = [])
    {
        $data = [
            "token" => $token,
            "title" => $title,
            "body" => $body,
            "data" => json_encode($customData),
        ];

        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://app.sjpanel.com/api/send-notification');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        return [
            'http_code' => $httpCode,
            'response' => json_decode($response, true),
            'error' => $error ?: null,
        ];
    }
}
