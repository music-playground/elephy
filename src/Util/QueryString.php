<?php

namespace MusicPlayground\Elephy\Util;

class QueryString
{
    public function createFromArray(array $params): string
    {
        $filtered = array_filter($params, fn ($value) => $value !== null);

        return join('&', array_map(
            fn (string $param, string $value) => "$param=$value",
            array_keys($filtered),
            array_values($filtered)
        ));
    }
}