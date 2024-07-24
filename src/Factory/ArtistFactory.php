<?php

namespace WhtsPoint\Elephy\Factory;

use WhtsPoint\Elephy\Entity\Artist;

class ArtistFactory
{
    public function __construct(
        private readonly ImageFactory $imageFactory = new ImageFactory()
    ) {}

    public function fromArray(array $params): Artist
    {
        $images = $this->imageFactory->manyFromArray($params['images']);

        return new Artist(
            $params['followers']['total'],
            $params['genres'],
            $params['id'],
            $images,
            $params['name'],
            $params['popularity'],
            $params['type'],
            $params['uri']
        );
    }

    public function manyFromArray(array $params): array
    {
        return array_map(fn (array $artist) => $this->fromArray($artist), $params);
    }
}