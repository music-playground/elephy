<?php

namespace WhtsPoint\Elephy\Factory;

use WhtsPoint\Elephy\ValueObject\Copyright;

class CopyrightFactory
{
    public function fromArray(array $params): Copyright
    {
        return new Copyright(
            $params['text'],
            $params['type']
        );
    }

    /** @return Copyright[]  */
    public function manyFromArray(array $params): array
    {
        return array_map(fn ($copyright) => $this->fromArray($copyright), $params);
    }
}