<?php

namespace WhtsPoint\Elephy\Interface;

use WhtsPoint\Elephy\Entity\Album;

/**
 */
interface SpotifyApiInterface
{
    /**
     * @throws HttpExceptionInterface
     */
    public function getAlbum(string $id, ?string $market = null): Album;
    /**
     * @throws HttpExceptionInterface
     * @param string[] $ids
     */
    public function getSeveralAlbums(array $ids, ?string $market = null): array;
    /**
     * @throws HttpExceptionInterface
     */
    public function getAlbumTracks(string $id, int $limit, int $offset, ?string $market = null): array;
    /**
     * @throws HttpExceptionInterface
     */
    public function getSavedAlbums(int $limit, int $offset, ?string $market = null): array;
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
    public function getNewReleases(int $limit, int $offset): array;
}