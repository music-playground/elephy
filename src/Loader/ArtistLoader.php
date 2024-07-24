<?php

namespace WhtsPoint\Elephy\Loader;

use Generator;
use WhtsPoint\Elephy\Interface\ArtistLoaderInterface;
use WhtsPoint\Elephy\Interface\SpotifyApiInterface;

class ArtistLoader implements ArtistLoaderInterface
{
    public function __construct(
        private readonly SpotifyApiInterface $spotifyApi,
        /** @var string[] */
        private readonly array $ids
    ) {}

    public function all(): Generator
    {
        yield from $this->spotifyApi->getSeveralArtists($this->ids);
    }
}