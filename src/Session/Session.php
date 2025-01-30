<?php

namespace MusicPlayground\Elephy\Session;

use MusicPlayground\Elephy\Exception\HttpException;
use MusicPlayground\Elephy\Interface\SessionInterface;
use MusicPlayground\Elephy\Util\Request;

class Session implements SessionInterface
{
    private Request $request;

    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        string $apiUrl = 'https://accounts.spotify.com/api'
    ) {
        $this->request = (new Request())->withApiUrl($apiUrl)
            ->withEndpoint('/token')
            ->addOptions([
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
                CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=$this->clientId&client_secret=$this->clientSecret",
            ]);
    }

    /**
     * @throws HttpException
     */
    public function requestAccessToken(): array
    {
        return json_decode($this->request->send(), true);
    }

    /**
     * @throws HttpException
     */
    public function getAccessToken(): string
    {
        return $this->requestAccessToken()['access_token'];
    }
}