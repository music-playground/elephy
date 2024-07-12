<?php

namespace WhtsPoint\Elephy\Loader;

use Generator;
use WhtsPoint\Elephy\Interface\SpotifyApiInterface;
use WhtsPoint\Elephy\Interface\TracksLoaderInterface;

class TrackLoader implements TracksLoaderInterface
{
    private array $tracks = [];

    public function __construct(
        private readonly SpotifyApiInterface $api,
        private readonly string $albumId,
        private readonly int $limit,
        private readonly int $total
    ) {}

    public function all(): Generator
    {
        yield from $this->tracks;

        do {
            $tracks = $this->api->getAlbumTracks($this->albumId, $this->limit, count($this->tracks));
            $this->tracks []= $tracks;

            yield $tracks;
        } while ($tracks > 0 && count($this->tracks) < $this->total);
    }
}