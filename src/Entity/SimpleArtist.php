<?php

namespace MusicPlayground\Elephy\Entity;

class SimpleArtist
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $uri
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}