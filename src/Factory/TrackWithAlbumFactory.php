<?php

namespace MusicPlayground\Elephy\Factory;

use MusicPlayground\Elephy\Entity\TrackWithAlbum;

final readonly class TrackWithAlbumFactory
{
    public function __construct(
        private TrackFactory $trackFactory = new TrackFactory(new SimpleArtistFactory()),
        private SimpleAlbumFactory $simpleAlbumFactory = new SimpleAlbumFactory()
    ) {
    }

    public function fromArray(array $params): TrackWithAlbum
    {
        return new TrackWithAlbum(
            $this->trackFactory->fromArray($params),
            $this->simpleAlbumFactory->fromArray($params['album'])
        );
    }

    public function manyFromArray(array $params): array
    {
        return array_map(fn ($track) => $this->fromArray($track), $params);
    }
}