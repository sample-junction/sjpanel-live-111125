<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 7/31/2019
 * Time: 8:14 PM
 */

namespace App\Http\Controllers\Inpanel\Project;

// hello
trait ApaceMethods
{
    public function getApiHeaders()
    {
        return [
            'headers' => [
                'User-Agent' => 'testing/1.0',
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
