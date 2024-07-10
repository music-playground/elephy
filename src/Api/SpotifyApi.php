<?php

namespace WhtsPoint\Elephy\Api;

use WhtsPoint\Elephy\Interface\SessionInterface;
use WhtsPoint\Elephy\Interface\SpotifyApiInterface;
use WhtsPoint\Elephy\Util\QueryString;
use WhtsPoint\Elephy\Util\Request;

class SpotifyApi implements SpotifyApiInterface
{
    private readonly Request $getRequest;
    private readonly Request $putRequest;
    private readonly Request $deleteRequest;

    public function __construct(
        private readonly SessionInterface $session,
        private readonly string $apiUrl = 'https://api.spotify.com/v1',
        private readonly QueryString $queryString = new QueryString()
    ) {
        $request = (new Request())->withApiUrl($this->apiUrl);
        $this->getRequest = $request;
        $this->putRequest = $request->addOptions([
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_CUSTOMREQUEST => 'PUT'
        ]);
        $this->deleteRequest = $request->addOptions([
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ]);
    }

    public function getAlbum(string $id, ?string $market = null)
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/albums/$id?' . $this->queryString->createFromArray(compact($market)))
                ->send(),
            true
        );
    }

    public function getSeveralAlbums(array $ids, ?string $market = null)
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/albums?' . $this->queryString->createFromArray([
                    'ids' => join(',', $ids),
                    'market' => $market
                ]))
                ->send(),
            true
        );
    }

    public function getAlbumTracks(string $id, int $limit, int $offset, ?string $market = null)
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/albums/$id/tracks?' . $this->queryString
                        ->createFromArray(compact($limit, $offset, $market))
                )->send(),
            true
        );
    }

    public function getSavedAlbums(int $limit, int $offset, ?string $market = null)
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/me/albums?' . $this->queryString
                        ->createFromArray(compact($limit, $offset, $market))
                )->send(),
            true
        );
    }

    public function saveAlbums(array $ids)
    {
        $this->putRequest
            ->withAccessToken($this->session->getAccessToken())
            ->withEndpoint('/me/albums')
            ->addOptions([CURLOPT_POSTFIELDS => json_encode(['ids' => join(',', $ids)])])
            ->send();
    }

    public function removeSavedAlbums(array $ids)
    {
        $this->deleteRequest
            ->withAccessToken($this->session->getAccessToken())
            ->withEndpoint('/me/albums')
            ->addOptions([CURLOPT_POSTFIELDS => json_encode(['ids' => join(',', $ids)])])
            ->send();
    }

    public function checkSavedAlbums(array $ids): array
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/me/albums/contains')
                ->addOptions([CURLOPT_POSTFIELDS => json_encode(['ids' => join(',', $ids)])])
            ->send(),
            true
        );
    }

    public function getNewReleases(int $limit, int $offset)
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/browse/new-releases?' . $this->queryString
                        ->createFromArray(compact($limit, $offset))
                )->send(),
            true
        );
    }
}