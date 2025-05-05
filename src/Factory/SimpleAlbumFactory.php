<?php

namespace MusicPlayground\Elephy\Factory;

use MusicPlayground\Elephy\Entity\SimpleAlbum;

final readonly class SimpleAlbumFactory
{
    public function __construct(
        private SimpleArtistFactory $simpleArtistFactory = new SimpleArtistFactory(),
        private ImageFactory $imageFactory = new ImageFactory()
    ) {
    }

    public function fromArray(array $params): SimpleAlbum
    {
        var_dump($params);
        exit;
        return new SimpleAlbum(
            $params['album_type'],
            $params['total_tracks'],
            $params['available_markets'],
            $params['id'],
            $this->imageFactory->manyFromArray($params['images']),
            $params['name'],
            $params['release_date'],
            $params['release_date_precision'],
            $params['type'],
            $params['uri'],
            $this->simpleArtistFactory->manyFromArray($params['artists'])
        );
    }

    public function manyFromArray(array $params): array
    {
        return array_map(fn (SimpleAlbum $album) => $this->fromArray($params), $params);
    }
}