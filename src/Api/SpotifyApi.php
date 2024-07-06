<?php

namespace Whtspoint\Elephy\Api;

use Whtspoint\Elephy\Interface\SessionInterface;
use Whtspoint\Elephy\Interface\SpotifyApiInterface;
use Whtspoint\Elephy\Util\Curl;

class SpotifyApi implements SpotifyApiInterface
{
    private readonly Curl $curl;

    public function __construct(
        private SessionInterface $session
    ) {
        $this->curl = new Curl();
    }

    public function getAlbum(string $id, string $market)
    {
    }

    public function getSeveralAlbums(array $ids, string $market)
    {
    }

    public function getAlbumTracks(string $id, string $market, int $limit, int $offset)
    {
    }

    public function getSavedAlbums(int $limit, int $offset, string $market)
    {
    }

    public function saveAlbums(array $ids)
    {
    }

    public function removeSavedAlbums(array $ids)
    {
    }

    public function getNewReleases(int $limit, int $offset)
    {
    }
}