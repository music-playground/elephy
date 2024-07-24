<?php

namespace WhtsPoint\Elephy\Interface;

use Generator;
use WhtsPoint\Elephy\Entity\Artist;

interface ArtistLoaderInterface
{
    /** @return Generator<Artist> */
    public function all(): Generator;
}