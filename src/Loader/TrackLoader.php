<?php

namespace MusicPlayground\Elephy\Loader;

use Generator;
use MusicPlayground\Elephy\Interface\SpotifyApiInterface;
use MusicPlayground\Elephy\Interface\TracksLoaderInterface;

class TrackLoader implements TracksLoaderInterface
{
    private array $tracks = [];

    public function __construct(
        private readonly SpotifyApiInterface $api,
        private readonly string $albumId,
        private int $limit,
        private readonly ?string $market = null
    ) {}

    public function all(): Generator
    {
        yield from $this->tracks;

        do {
            $tracksDto = $this->api->getAlbumTracks(
                $this->albumId,
                $this->limit,
                count($this->tracks),
                $this->market
            );
            $this->tracks += $tracksDto->tracks;
            $this->limit = $tracksDto->limit;

            yield from $tracksDto->tracks;
        } while ($tracksDto->tracks > 0 && count($this->tracks) < $tracksDto->total);
    }
}