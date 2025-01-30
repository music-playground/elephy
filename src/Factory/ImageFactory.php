<?php

namespace MusicPlayground\Elephy\Factory;

use MusicPlayground\Elephy\Entity\Image;

class ImageFactory
{
    public function fromArray(array $params): Image
    {
        return new Image(
            $params['url'],
            $params['width'],
            $params['height']
        );
    }

    /** @return Image[] */
    public function manyFromArray(array $params): array
    {
        return array_map(fn ($image) => $this->fromArray($image), $params);
    }
}