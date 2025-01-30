<?php

namespace MusicPlayground\Elephy\Interface;

use Generator;
use MusicPlayground\Elephy\Entity\Track;

interface TracksLoaderInterface
{
    /**
     * @return Generator<Track>
     */
    public function all(): Generator;
}