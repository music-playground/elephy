<?php

namespace WhtsPoint\Elephy\Interface;

use WhtsPoint\Elephy\Dto\AlbumPaginationDto;
use WhtsPoint\Elephy\Dto\ChangePlaylistDetailsDto;
use WhtsPoint\Elephy\Dto\TracksPaginationDto;
use WhtsPoint\Elephy\Entity\Album;
use WhtsPoint\Elephy\Entity\Artist;
use WhtsPoint\Elephy\Entity\Audiobook;
use WhtsPoint\Elephy\Entity\PlaybackState;
use WhtsPoint\Elephy\Entity\Playlist;
use WhtsPoint\Elephy\Entity\Track;

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
     */
    public function getAlbumTracks(string $id, int $limit, int $offset, ?string $market = null): TracksPaginationDto;
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
    public function getArtistsAlbums(string $id): AlbumPaginationDto;
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