<?php

class FacebookService
{
    private $appId;
    private $appSecret;
    private $redirectUri;

    public function __construct()
    {
        $setting = (new Setting())->get();

        $this->appId =
            $setting->facebook_app_id;

        $this->appSecret =
            $setting->facebook_app_secret;

        $this->redirectUri =
            siteUrl() . '/facebook-callback';
    }

    public function loginUrl()
    {
        return
        'https://www.facebook.com/v23.0/dialog/oauth?'
        .
        http_build_query([

            'client_id' =>
            $this->appId,

            'redirect_uri' =>
            $this->redirectUri,
            'scope' => 'email',

            'response_type' =>
            'code'
        ]);
    }

    public function getAccessToken($code)
    {
        $url =
        'https://graph.facebook.com/v23.0/oauth/access_token?'
        .
        http_build_query([

            'client_id' =>
            $this->appId,

            'client_secret' =>
            $this->appSecret,

            'redirect_uri' =>
            $this->redirectUri,

            'code' =>
            $code
        ]);

        $response =
        json_decode(
            file_get_contents($url),
            true
        );

        return
        $response['access_token']
        ?? null;
    }

    public function getUser($token)
    {
        $url =
        'https://graph.facebook.com/me?'
        .
        http_build_query([

            'fields' =>
            'id,name,email,picture',

            'access_token' =>
            $token
        ]);

        return json_decode(
            file_get_contents($url),
            true
        );
    }
}