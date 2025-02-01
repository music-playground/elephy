<?php

namespace MusicPlayground\Elephy\Dto;

use MusicPlayground\Elephy\Entity\Album;

class AlbumPaginationDto
{
    public function __construct(
        public readonly int $total,
        /** @var Album[] */
        public readonly array $albums
    ) {}
}