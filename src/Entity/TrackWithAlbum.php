<?php

namespace MusicPlayground\Elephy\Entity;

final readonly class TrackWithAlbum
{
    public function __construct(
        private Track $track,
        private SimpleAlbum $album
    ) {
    }

    public function getTrack(): Track
    {
        return $this->track;
    }

    public function getAlbum(): SimpleAlbum
    {
        return $this->album;
    }
}