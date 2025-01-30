<?php

namespace MusicPlayground\Elephy\Dto;

use MusicPlayground\Elephy\Entity\Track;

class TracksPaginationDto
{
    public function __construct(
        public readonly int $limit,
        public readonly int $offset,
        public readonly int $total,
        /** @var Track[] */
        public readonly array $tracks
    ) {}
}