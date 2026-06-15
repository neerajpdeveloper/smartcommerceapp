<?php

class GoogleService
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct()
    {
        $setting = (new Setting())->get();

        $this->clientId =
            $setting->google_client_id;

        $this->clientSecret =
            $setting->google_client_secret;

        $this->redirectUri =
            siteUrl() . '/google-callback';
    }

    public function loginUrl()
    {
        return
        'https://accounts.google.com/o/oauth2/v2/auth?'
        .
        http_build_query([

            'client_id' =>
            $this->clientId,

            'redirect_uri' =>
            $this->redirectUri,

            'response_type' =>
            'code',

            'scope' =>
            'email profile',

            'access_type' =>
            'offline',

            'prompt' =>
            'select_account'
        ]);
    }

    public function getAccessToken($code)
    {
        $ch = curl_init();

        curl_setopt_array($ch,[

            CURLOPT_URL =>
            'https://oauth2.googleapis.com/token',

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_POSTFIELDS =>
            http_build_query([

                'client_id' =>
                $this->clientId,

                'client_secret' =>
                $this->clientSecret,

                'code' =>
                $code,

                'grant_type' =>
                'authorization_code',

                'redirect_uri' =>
                $this->redirectUri
            ])
        ]);

        $response =
        json_decode(
            curl_exec($ch),
            true
        );

        curl_close($ch);

        return
        $response['access_token']
        ?? null;
    }

    public function getUser($token)
    {
        $ch = curl_init();

        curl_setopt_array($ch,[

            CURLOPT_URL =>
            'https://www.googleapis.com/oauth2/v2/userinfo',

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_HTTPHEADER => [

                'Authorization: Bearer '
                . $token
            ]
        ]);

        $user =
        json_decode(
            curl_exec($ch),
            true
        );

        curl_close($ch);

        return $user;
    }
}