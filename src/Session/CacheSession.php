<?php

namespace MusicPlayground\Elephy\Session;

use MusicPlayground\Elephy\Exception\HttpException;
use MusicPlayground\Elephy\Interface\SessionInterface;

class CacheSession implements SessionInterface
{
    private Session $session;
    private ?int $expireAt = null;
    private string $token;

    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        string $apiUrl = 'https://accounts.spotify.com/api'
    ) {
        $this->session = new Session($this->clientId, $this->clientSecret, $apiUrl);
    }

    /**
     * @throws HttpException
     */
    public function requestAccessToken(): array
    {
        return $this->session->requestAccessToken();
    }

    /**
     * @throws HttpException
     */
    public function getAccessToken(): string
    {
        if ($this->expireAt === null || $this->expireAt < time()) {
            ['expires_in' => $expiresIn, 'access_token' => $accessToken] = $this->requestAccessToken();

            //NOTE: We take a small amount of time to ensure that the token will be alive for the next request
            $this->expireAt = time() + $expiresIn - 100;

            $this->token = $accessToken;
        }

        return $this->token;
    }
}