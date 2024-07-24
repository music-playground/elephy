<?php

namespace WhtsPoint\Elephy\Api;

use WhtsPoint\Elephy\Dto\AlbumPaginationDto;
use WhtsPoint\Elephy\Dto\TracksPaginationDto;
use WhtsPoint\Elephy\Entity\Album;
use WhtsPoint\Elephy\Entity\Artist;
use WhtsPoint\Elephy\Entity\Audiobook;
use WhtsPoint\Elephy\Exception\HttpException;
use WhtsPoint\Elephy\Factory\AlbumFactory;
use WhtsPoint\Elephy\Factory\ArtistFactory;
use WhtsPoint\Elephy\Factory\AudiobookFactory;
use WhtsPoint\Elephy\Factory\TrackFactory;
use WhtsPoint\Elephy\Interface\SessionInterface;
use WhtsPoint\Elephy\Interface\SpotifyApiInterface;
use WhtsPoint\Elephy\Util\QueryString;

class SpotifyApi implements SpotifyApiInterface
{
    private readonly ApiRequests $apiRequests;
    private readonly AlbumFactory $albumFactory;
    private readonly TrackFactory $trackFactory;
    private readonly ArtistFactory $artistFactory;
    private readonly AudiobookFactory $audiobookFactory;

    public function __construct(
        private readonly SessionInterface $session,
        string $apiUrl = 'https://api.spotify.com/v1',
        private readonly QueryString $queryString = new QueryString()
    ) {
        $this->albumFactory = new AlbumFactory($this);
        $this->trackFactory = new TrackFactory();
        $this->artistFactory = new ArtistFactory();
        $this->apiRequests = new ApiRequests($apiUrl);
        $this->audiobookFactory = new AudiobookFactory();
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

        return $this->albumFactory->fromArray($response, $market);
    }

    public function getSeveralAlbums(array $ids, ?string $market = null): array
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/albums?' . $this->queryString->createFromArray([
                    'ids' => join(',', $ids),
                    'market' => $market
                ]))
                ->send(),
            true
        );

        return $this->albumFactory->manyFromArray($response['albums'], $market);
    }

    public function getAlbumTracks(string $id, int $limit, int $offset, ?string $market = null): TracksPaginationDto
    {
        $result = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/albums/$id/tracks?" . $this->queryString
                        ->createFromArray(['limit' => $limit, 'offset' => $offset, 'market' => $market])
                )->send(),
            true
        );

        return new TracksPaginationDto(
            $result['limit'],
            $result['offset'],
            $result['total'],
            $this->trackFactory->manyFromArray($result['items'])
        );
    }

    public function getSavedAlbums(int $limit, int $offset, ?string $market = null): AlbumPaginationDto
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/me/albums?' . $this->queryString
                        ->createFromArray(['limit' => $limit, 'offset' => $offset, 'market' => $market])
                )->send(),
            true
        );

        return new AlbumPaginationDto(
            $response['limit'],
            $response['offset'],
            $response['total'],
            $this->albumFactory->manyFromArray($response['items'])
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

    public function getNewReleases(int $limit, int $offset): AlbumPaginationDto
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/browse/new-releases?' . $this->queryString
                        ->createFromArray(['limit' => $limit, 'offset' => $offset])
                )->send(),
            true
        );

        return new AlbumPaginationDto(
            $response['albums']['limit'],
            $response['albums']['offset'],
            $response['albums']['total'],
            $this->albumFactory->manyFromArray($response['albums']['items'])
        );
    }

    public function getArtist(string $id): Artist
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/artists/$id")
                ->send(),
            true
        );

        return $this->artistFactory->fromArray($response);
    }

    /**
     * @throws HttpException
     */
    public function getSeveralArtists(array $ids): array
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/artists?" . $this->queryString->createFromArray(['ids' => join(',', $ids)]))
                ->send(),
            true
        );

        return $this->artistFactory->manyFromArray($response['artists']);
    }

    /**
     * @throws HttpException
     */
    public function getArtistsAlbums(string $id): AlbumPaginationDto
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/artists/$id/albums")
                ->send(),
            true
        );

        return new AlbumPaginationDto(
            $response['limit'],
            $response['offset'],
            $response['total'],
            $this->albumFactory->manyFromArray($response['items'])
        );
    }

    /**
     * @throws HttpException
     */
    public function getArtistsTopTracks(string $id): array
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/artists/$id/top-tracks")
                ->send(),
            true
        );

        return $this->trackFactory->manyFromArray($response['tracks']);
    }

    /**
     * @throws HttpException
     */
    public function getArtistsRelatedArtist(string $id): array
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/artists/$id/related-artists")
                ->send(),
            true
        );

        return $this->artistFactory->manyFromArray($response['artists']);
    }

    public function getAudiobook(string $id): Audiobook
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/audiobooks/$id")
                ->send(),
            true
        );

        return $this->audiobookFactory->fromArray($response);
    }
}