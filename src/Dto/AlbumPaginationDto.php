<?php

namespace WhtsPoint\Elephy\Dto;

use WhtsPoint\Elephy\Entity\Album;

class AlbumPaginationDto
{
    public function __construct(
        public readonly int $limit,
        public readonly int $offset,
        public readonly int $total,
        /** @var Album[] */
        public readonly array $albums
    ) {}
}