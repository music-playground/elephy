<?php

namespace MusicPlayground\Elephy\Factory;

use MusicPlayground\Elephy\Entity\Track;

class TrackFactory
{
    public function fromArray(array $params): Track
    {
        return new Track(
            @$params['available_markets'],
            $params['disc_number'],
            $params['duration_ms'],
            (bool)$params['explicit'],
            $params['id'],
            isset($params['restrictions']) ? $params['restrictions']['reason'] : null,
            $params['name'],
            $params['preview_url'],
            $params['track_number'],
            $params['type'],
            $params['uri'],
            $params['is_local']
        );
    }

    /**
     * @return Track[]
     */
    public function manyFromArray(array $params): array
    {
        return array_map(fn ($track) => $this->fromArray($track), $params);
    }
}