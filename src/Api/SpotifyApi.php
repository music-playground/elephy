<?php

namespace MusicPlayground\Elephy\Api;

use Generator;
use MusicPlayground\Elephy\Dto\AlbumPaginationDto;
use MusicPlayground\Elephy\Dto\ChangePlaylistDetailsDto;
use MusicPlayground\Elephy\Dto\TracksPaginationDto;
use MusicPlayground\Elephy\Entity\Album;
use MusicPlayground\Elephy\Entity\Artist;
use MusicPlayground\Elephy\Entity\Audiobook;
use MusicPlayground\Elephy\Entity\PlaybackState;
use MusicPlayground\Elephy\Entity\Playlist;
use MusicPlayground\Elephy\Exception\HttpException;
use MusicPlayground\Elephy\Factory\AlbumFactory;
use MusicPlayground\Elephy\Factory\ArtistFactory;
use MusicPlayground\Elephy\Factory\AudiobookFactory;
use MusicPlayground\Elephy\Factory\PlaylistFactory;
use MusicPlayground\Elephy\Factory\TrackFactory;
use MusicPlayground\Elephy\Interface\SessionInterface;
use MusicPlayground\Elephy\Interface\SpotifyApiInterface;
use MusicPlayground\Elephy\Util\QueryString;

class SpotifyApi implements SpotifyApiInterface
{
    private readonly ApiRequests $apiRequests;
    private readonly AlbumFactory $albumFactory;
    private readonly TrackFactory $trackFactory;
    private readonly ArtistFactory $artistFactory;
    private readonly AudiobookFactory $audiobookFactory;
    private readonly PlaylistFactory $playlistFactory;

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
        $this->playlistFactory = new PlaylistFactory();
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

    public function getAlbumTracks(string $id, ?int $limit = null, int $offset = 0, ?string $market = null): Generator
    {
        do {
            $result = json_decode(
                $this->apiRequests->getGetRequest()
                    ->withAccessToken($this->session->getAccessToken())
                    ->withEndpoint("/albums/$id/tracks?" . $this->queryString
                            ->createFromArray(['limit' => $limit, 'offset' => $offset, 'market' => $market])
                    )->send(),
                true
            );
            $count = count($result['items']);

            if ($count === 0) break;

            $offset += $count;

            yield new TracksPaginationDto(
                $result['total'],
                $this->trackFactory->manyFromArray($result['items'])
            );
        } while (true);
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
    public function getArtistsAlbums(string $id, ?int $limit = null, ?int $offset = null, ?array $includeGroups = null): Generator
    {
        do {
            $response = json_decode(
                $this->apiRequests->getGetRequest()
                    ->withAccessToken($this->session->getAccessToken())
                    ->withEndpoint("/artists/$id/albums?" . $this->queryString->createFromArray([
                            'include_groups' => $includeGroups ? join(',', $includeGroups) : null,
                            'limit' => $limit,
                            'offset' => $offset
                        ])
                    )
                    ->send(),
                true
            );
            $count = count($response['items']);

            if ($count === 0) break;

            $offset += $count;

            yield new AlbumPaginationDto(
                $response['total'],
                $this->albumFactory->manyFromArray($response['items'])
            );
        } while (true);
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

    public function getSeveralAudiobooks(array $ids, ?string $market = null): array
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/audiobooks?" .
                    $this->queryString->createFromArray(['ids' => join(',', $ids)])
                )
                ->send(),
            true
        );

        return $this->audiobookFactory->manyFromArray($response);
    }

    /**
     * @throws HttpException
     */
    public function getAvailableGenreSeeds(): array
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/recommendations/available-genre-seeds')
                ->send(),
            true
        );

        return $response['genres'];
    }

    public function getAvailableMarkets(?array $markets = null): array
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/markets')
                ->send(),
            true
        );

        return $response['markets'];
    }

    /**
     * @throws HttpException
     */
    public function getPlaybackState(?string $market = null): PlaybackState
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint('/me/player')
                ->send(),
            true
        );

        return new PlaybackState();
    }

    public function getPlaylist(string $id, ?string $market = null): Playlist
    {
        $response = json_decode(
            $this->apiRequests->getGetRequest()
                ->withAccessToken($this->session->getAccessToken())
                ->withEndpoint("/playlists/$id")
                ->send(),
            true
        );

        return $this->playlistFactory->fromArray($response);
    }

    public function changePlaylistDetails(string $id, ?ChangePlaylistDetailsDto $body = null): void
    {
        $this->apiRequests->getPutRequest()
            ->withAccessToken($this->session->getAccessToken())
            ->withEndpoint("/playlists/$id")
            ->addOptions([ CURLOPT_POSTFIELDS => json_encode($body?->toArray())])
            ->send();
    }
}