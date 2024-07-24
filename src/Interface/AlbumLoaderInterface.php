<?php

namespace WhtsPoint\Elephy\Interface;

use Generator;
use WhtsPoint\Elephy\Entity\Album;

interface AlbumLoaderInterface
{
    /**
     * @return Generator<Album>
     */
    public function all(): Generator;
}