<?php

namespace WhtsPoint\Elephy\Api;

use WhtsPoint\Elephy\Entity\Album;
use WhtsPoint\Elephy\Factory\AlbumFactory;
use WhtsPoint\Elephy\Interface\SessionInterface;
use WhtsPoint\Elephy\Interface\SpotifyApiInterface;
use WhtsPoint\Elephy\Util\QueryString;

class SpotifyApi implements SpotifyApiInterface
{
    private readonly ApiRequests $apiRequests;
    private readonly AlbumFactory $albumFactory;

    public function __construct(
        private readonly SessionInterface $session,
        string $apiUrl = 'https://api.spotify.com/v1',
        private readonly QueryString $queryString = new QueryString(),
    ) {
        $this->albumFactory = new AlbumFactory($this);
        $this->apiRequests = new ApiRequests($apiUrl);
    }

    public function getAlbum(string $id, ?string $market = null): Album
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/albums/$id?" . $this->queryString
                        ->createFromArray(['market' => $market])
                )
                ->send(),
            true
        );

        return $this->albumFactory->createFromArray($response);
    }

    public function getSeveralAlbums(array $ids, ?string $market = null): array
    {
        return json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/albums?' . $this->queryString->createFromArray([
                    'ids' => join(',', $ids),
                    'market' => $market
                ]))
                ->send(),
            true
        );
    }

    public function getAlbumTracks(string $id, int $limit, int $offset, ?string $market = null): array
    {
        return json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/albums/$id/tracks?" . $this->queryString
                        ->createFromArray(['limit' => $limit, 'offset' => $offset, 'market' => $market])
                )->send(),
            true
        );
    }

    public function getSavedAlbums(int $limit, int $offset, ?string $market = null): array
    {
        return json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/me/albums?' . $this->queryString
                        ->createFromArray(compact($limit, $offset, $market))
                )->send(),
            true
        );
    }

    public function saveAlbums(array $ids): void
    {
        $this->apiRequests->getPutRequest()
            ->withAccessToken($this->session->getAccessToken())
            ->withEndpoint('/me/albums')
            ->addOptions([CURLOPT_POSTFIELDS => json_encode(['ids' => join(',', $ids)])])
            ->send();
    }

    public function removeSavedAlbums(array $ids): void
    {
        $this->apiRequests->getDeleteRequest()
            ->withAccessToken($this->session->getAccessToken())
            ->withEndpoint('/me/albums')
            ->addOptions([CURLOPT_POSTFIELDS => json_encode(['ids' => join(',', $ids)])])
            ->send();
    }

    public function checkSavedAlbums(array $ids): array
    {
        return json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/me/albums/contains')
                ->addOptions([CURLOPT_POSTFIELDS => json_encode(['ids' => join(',', $ids)])])
            ->send(),
            true
        );
    }

    public function getNewReleases(int $limit, int $offset): array
    {
        return json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/browse/new-releases?' . $this->queryString
                        ->createFromArray(compact($limit, $offset))
                )->send(),
            true
        );
    }
}