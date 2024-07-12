<?php

namespace WhtsPoint\Elephy\Interface;

use Generator;
use WhtsPoint\Elephy\Entity\Track;

interface TracksLoaderInterface
{
    /**
     * @return Generator<Track>
     */
    public function all(): Generator;
}