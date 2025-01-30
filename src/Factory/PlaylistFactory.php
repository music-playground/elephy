<?php

namespace MusicPlayground\Elephy\Factory;

use MusicPlayground\Elephy\Entity\Playlist;

class PlaylistFactory
{
    public function __construct(
        private readonly ImageFactory $imageFactory = new ImageFactory()
    ) {}

    public function fromArray(array $params): Playlist
    {
        $images = $this->imageFactory->manyFromArray($params['images']);

        return new Playlist(
            $params['collaborative'],
            $params['description'],
            $params['followers']['total'],
            $params['id'],
            $images,
            $params['name'],
            $params['public'],
            $params['snapshot_id'],
            $params['type'],
            $params['uri']
        );
    }
}