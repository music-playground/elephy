<?php

namespace MusicPlayground\Elephy\Entity;

class Artist
{
    public function __construct(
        private readonly int $followers,
        private readonly array $genres,
        private readonly string $id,
        /** @var Image[] */
        private readonly array $images,
        private readonly string $name,
        private readonly int $popularity,
        private readonly string $type,
        private readonly string $uri
    ) {}

    public function getFollowers(): int
    {
        return $this->followers;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPopularity(): int
    {
        return $this->popularity;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}