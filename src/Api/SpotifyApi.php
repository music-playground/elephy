<?php

namespace WhtsPoint\Elephy\Api;

use WhtsPoint\Elephy\Interface\SessionInterface;
use WhtsPoint\Elephy\Interface\SpotifyApiInterface;
use WhtsPoint\Elephy\Util\QueryString;
use WhtsPoint\Elephy\Util\Request;

class SpotifyApi implements SpotifyApiInterface
{
    private readonly Request $getRequest;

    public function __construct(
        private readonly SessionInterface $session,
        private readonly string $apiUrl = 'https://api.spotify.com/v1',
        private readonly QueryString $queryString = new QueryString()
    ) {
        $request = (new Request())->withApiUrl($this->apiUrl);
        $this->getRequest = $request;
    }

    public function getAlbum(string $id, ?string $market = null)
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/albums/$id?" . $this->queryString->createFromArray(compact($market)))
                ->send(),
            true
        );
    }

    public function getSeveralAlbums(array $ids, ?string $market = null)
    {
        return json_decode(
            $this->getRequest
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/albums?" . $this->queryString->createFromArray([
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
                ->withEndpoint("/albums/$id/tracks?" . $this->queryString
                        ->createFromArray(compact($limit, $offset, $market))
                )->send(),
            true
        );
    }

    public function getSavedAlbums(int $limit, int $offset, ?string $market = null)
    {
        // TODO: Implement getSavedAlbums() method.
    }

    public function saveAlbums(array $ids)
    {
        // TODO: Implement saveAlbums() method.
    }

    public function removeSavedAlbums(array $ids)
    {
        // TODO: Implement removeSavedAlbums() method.
    }

    public function getNewReleases(int $limit, int $offset)
    {
        // TODO: Implement getNewReleases() method.
    }
}