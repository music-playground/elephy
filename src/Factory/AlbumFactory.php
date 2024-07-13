<?php

namespace WhtsPoint\Elephy\Factory;

use WhtsPoint\Elephy\Entity\Album;
use WhtsPoint\Elephy\Interface\SpotifyApiInterface;
use WhtsPoint\Elephy\Loader\TrackLoader;

class AlbumFactory
{
    public function __construct(
        private readonly SpotifyApiInterface $api,
        private readonly ImageFactory $imageFactory = new ImageFactory(),
        private readonly CopyrightFactory $copyrightFactory = new CopyrightFactory()
    ) {}

    public function fromArray(array $params, ?string $market = null): Album
    {
        $images = $this->imageFactory->manyFromArray($params['images']);
        $copyrights = isset($params['copyrights']) ? $this->copyrightFactory->manyFromArray($params['copyrights']) : null;
        $trackLoader = new TrackLoader(
            $this->api,
            $params['id'],
            isset($params['tracks']) ? $params['tracks']['limit']: 100,
            $market
        );

        return new Album(
            $params['album_type'],
            $params['total_tracks'],
            @$params['available_markets'],
            $params['id'],
            $images,
            $params['name'],
            $params['release_date'],
            $params['release_date_precision'],
            isset($params['restrictions']) ? $params['restrictions']['reason']: null,
            $params['type'],
            $params['uri'],
            $copyrights,
            @$params['genres'],
            $params['label'],
            $params['popularity'],
            $trackLoader,
            $market
        );
    }

    /**
     * @return Album[]
     */
    public function manyFromArray(array $params, ?string $market = null): array
    {
        return array_map(fn ($album) => $this->fromArray($album, $market), $params);
    }
}