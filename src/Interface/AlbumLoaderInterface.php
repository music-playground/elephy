<?php

namespace MusicPlayground\Elephy\Interface;

use Generator;
use MusicPlayground\Elephy\Entity\Album;

interface AlbumLoaderInterface
{
    /**
     * @return Generator<Album>
     */
    public function all(): Generator;
}