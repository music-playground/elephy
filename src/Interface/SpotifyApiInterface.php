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
     * @param string[] $ids
     * @return Artist[]
     */
    public function getSeveralArtists(array $ids): array;
    /**
     * @return Generator<AlbumPaginationDto>
     */
    public function getArtistsAlbums(string $id, ?int $limit = null, ?int $offset = null, ?array $includeGroups = null): Generator;
    /**
     * @return Track[]
     */
    public function getArtistsTopTracks(string $id): array;
    /**
     * @return Artist[]
     */
    public function getArtistsRelatedArtist(string $id): array;
    public function getAudiobook(string $id): Audiobook;
    /**
     * @return Audiobook[]
     */
    public function getSeveralAudiobooks(array $ids, ?string $market = null): array;

    /**
     * @return string[]
     */
    public function getAvailableGenreSeeds(): array;
    /**
     * @return string[]
     */
    public function getAvailableMarkets(?array $markets = null): array;
    public function getPlaybackState(?string $market = null): PlaybackState;
    public function getPlaylist(string $id, ?string $market = null): Playlist;
    public function changePlaylistDetails(string $id, ?ChangePlaylistDetailsDto $body = null): void;
}