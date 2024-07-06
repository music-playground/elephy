<?php

namespace Whtspoint\Elephy\Interface;

interface SpotifyApiInterface
{
    /**
     * @throws HttpExceptionInterface
     */
    public function getAlbum(string $id, string $market);
    /**
     * @throws HttpExceptionInterface
     * @param string[] $ids
     */
    public function getSeveralAlbums(array $ids, string $market);
    /**
     * @throws HttpExceptionInterface
     */
    public function getAlbumTracks(string $id, string $market, int $limit, int $offset);
    /**
     * @throws HttpExceptionInterface
     */
    public function getSavedAlbums(int $limit, int $offset, string $market);
    /**
     * @throws HttpExceptionInterface
     */
    public function saveAlbums(array $ids);
    /**
     * @throws HttpExceptionInterface
     */
    public function removeSavedAlbums(array $ids);
    /**
     * @throws HttpExceptionInterface
     */
    public function getNewReleases(int $limit, int $offset);
}