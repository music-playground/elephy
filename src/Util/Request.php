<?php

namespace MusicPlayground\Elephy\Util;

use MusicPlayground\Elephy\Exception\HttpException;

class Request
{
    private readonly Curl $curl;
    public function __construct(
        private readonly ?string $accessToken = null,
        private readonly ?string $apiUrl = null,
        private readonly ?string $endpoint = null,
        private readonly array $options = []
    ) {
        $this->curl = new Curl();
    }

    /**
     * @throws HttpException
     */
    public function send(): string
    {
        return $this->curl->send($this->getOptions());
    }

    public function withAccessToken(string $accessToken): self
    {
        return new self($accessToken, $this->apiUrl, $this->endpoint, $this->options);
    }

    public function withApiUrl(string $apiUrl): self
    {
        return new self($this->accessToken, $apiUrl, $this->endpoint, $this->options);
    }

    public function withEndpoint(string $endpoint): self
    {
        return new self($this->accessToken, $this->apiUrl, $endpoint, $this->options);
    }

    public function addOptions(array $options): self
    {
        return new self(
            $this->accessToken,
            $this->apiUrl,
            $this->endpoint,
            $options
        );
    }

    private function getOptions(): array
    {
        $options = [];

        if ($this->accessToken !== null) {
            $options += [
                CURLOPT_HTTPHEADER => ["Authorization: Bearer $this->accessToken"]
            ];
        }

        if ($this->apiUrl !== null) {
            $options += [
                CURLOPT_URL => $this->apiUrl . ($this->endpoint ?: '')
            ];
        }

        return $this->options + $options;
    }
}