<?php

namespace WhtsPoint\Elephy\Factory;

use WhtsPoint\Elephy\Entity\Audiobook;

class AudiobookFactory
{
    public function __construct(
        private readonly ImageFactory $imageFactory = new ImageFactory(),
        private readonly CopyrightFactory $copyrightFactory = new CopyrightFactory()
    ) {}

    public function fromArray(array $params): Audiobook
    {
        $copyrights = $this->copyrightFactory->manyFromArray($params['copyright']);
        $images = $this->imageFactory->manyFromArray($params['images']);

        return new Audiobook(
            array_map(fn (array $author) => $author['name'], $params['authors']),
            $params['available_markets'],
            $copyrights,
            $params['description'],
            $params['html_description'],
            $params['edition'],
            $params['explicit'],
            $params['id'],
            $images,
            $params['languages'],
            $params['media_type'],
            $params['name'],
            array_map(fn (array $narrator) => $narrator['name'], $params['narrators']),
            $params['publisher'],
            $params['type'],
            $params['uri'],
            $params['total_chapters']
        );
    }

    /**
     * @return Audiobook[]
     */
    public function manyFromArray(array $params): array
    {
        return array_map(fn (array $audiobook) => $this->fromArray($audiobook), $params);
    }
}