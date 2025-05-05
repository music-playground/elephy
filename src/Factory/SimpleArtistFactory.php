<?php

namespace MusicPlayground\Elephy\Factory;

use MusicPlayground\Elephy\Entity\SimpleArtist;

class SimpleArtistFactory
{
    public function fromArray(array $params): SimpleArtist
    {
        return new SimpleArtist($params['id'], $params['name'], $params['uri']);
    }

    /**
     * @return SimpleArtist[]
     */
    public function manyFromArray(array $params): array
    {
        return array_map(fn ($artist) => $this->fromArray($artist), $params);
    }
}