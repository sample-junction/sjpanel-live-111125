<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 8/1/2019
 * Time: 3:14 PM
 */

namespace App\Console\Commands;


trait ApaceMethods
{
    public function getApiHeaders()
    {
        return [
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer ". $this->apiKey,
            ]
        ];
    }

    public function applyUrlChange($actionUrl)
    {
        $translations = [
            '{{url}}' => $this->url,
            '{{ProjectCode}}' => $this->project_code,
        ];
        $translatedUrl = strtr($actionUrl, $translations);
        return $translatedUrl;
    }
}
