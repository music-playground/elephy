<?php

namespace MusicPlayground\Elephy\Interface;

use Generator;
use MusicPlayground\Elephy\Dto\AlbumPaginationDto;
use MusicPlayground\Elephy\Dto\ChangePlaylistDetailsDto;
use MusicPlayground\Elephy\Dto\TracksPaginationDto;
use MusicPlayground\Elephy\Entity\Album;
use MusicPlayground\Elephy\Entity\Artist;
use MusicPlayground\Elephy\Entity\Audiobook;
use MusicPlayground\Elephy\Entity\PlaybackState;
use MusicPlayground\Elephy\Entity\Playlist;
use MusicPlayground\Elephy\Entity\Track;
use MusicPlayground\Elephy\Entity\TrackWithAlbum;

interface SpotifyApiInterface
{
    /**
     * @throws HttpExceptionInterface
     */
    public function getAlbum(string $id, ?string $market = null): Album;
    /**
     * @throws HttpExceptionInterface
     * @param string[] $ids
     * @return Album[]
     */
    public function getSeveralAlbums(array $ids, ?string $market = null): array;
    /**
     * @throws HttpExceptionInterface
     * @return Generator<TracksPaginationDto>
     */
    public function getAlbumTracks(string $id, ?int $limit = null, int $offset = 0, ?string $market = null): Generator;
    /**
     * @throws HttpExceptionInterface
     */
    public function getSavedAlbums(int $limit, int $offset, ?string $market = null): AlbumPaginationDto;
    /**
     * @throws HttpExceptionInterface
     * @param string[] $ids
     */
    public function saveAlbums(array $ids): void;
    /**
     * @throws HttpExceptionInterface
     * @param string[] $ids
     */
    public function removeSavedAlbums(array $ids): void;
    /**
     * @throws HttpExceptionInterface
     * @param string[] $ids
     * @return bool[]
     */
    public function checkSavedAlbums(array $ids): array;
    /**
     * @throws HttpExceptionInterface
     */
    public function getNewReleases(int $limit, int $offset): AlbumPaginationDto;

    /**
     * @throws HttpExceptionInterface
     */
    public function getArtist(string $id): Artist;

    /**
     * @throws HttpExceptionInterface
     * @param string[] $ids
     * @return Artist[]
     */
    public function getSeveralArtists(array $ids): array;
    /**
     * @throws HttpExceptionInterface
     * @return Generator<AlbumPaginationDto>
     */
    public function getArtistsAlbums(string $id, ?int $limit = null, ?int $offset = null, ?array $includeGroups = null): Generator;
    /**
     * @throws HttpExceptionInterface
     * @return Track[]
     */
    public function getArtistsTopTracks(string $id): array;
    /**
     * @throws HttpExceptionInterface
     * @return Artist[]
     */
    public function getArtistsRelatedArtist(string $id): array;
    public function getAudiobook(string $id): Audiobook;
    /**
     * @throws HttpExceptionInterface
     * @return Audiobook[]
     */
    public function getSeveralAudiobooks(array $ids, ?string $market = null): array;

    /**
     * @throws HttpExceptionInterface
     * @return string[]
     */
    public function getAvailableGenreSeeds(): array;
    /**
     * @throws HttpExceptionInterface
     * @return string[]
     */
    public function getAvailableMarkets(?array $markets = null): array;

    /**
     * @throws HttpExceptionInterface
     */
    public function getPlaybackState(?string $market = null): PlaybackState;

    /**
     * @throws HttpExceptionInterface
     */
    public function getPlaylist(string $id, ?string $market = null): Playlist;

    /**
     * @throws HttpExceptionInterface
     */
    public function changePlaylistDetails(string $id, ?ChangePlaylistDetailsDto $body = null): void;

    /**
     * @return TrackWithAlbum[]
     */
    public function getPlaylistItems(string $id): array;
}