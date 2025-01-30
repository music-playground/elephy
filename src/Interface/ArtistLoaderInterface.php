<?php

namespace MusicPlayground\Elephy\Interface;

use Generator;
use MusicPlayground\Elephy\Entity\Artist;

interface ArtistLoaderInterface
{
    /** @return Generator<Artist> */
    public function all(): Generator;
}