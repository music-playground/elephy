<?php

namespace MusicPlayground\Elephy\Factory;

use MusicPlayground\Elephy\Entity\SimpleArtist;

class SimpleArtistFactory
{
    public function fromArray(array $params): SimpleArtist
    {
        return new SimpleArtist($params['id'], $params['name'], $params['uri']);
    }
}