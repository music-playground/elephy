<?php

namespace MusicPlayground\Elephy\Entity;

final readonly class SimpleAlbum
{
    public function __construct(
        private string $albumType,
        private int $totalTracks,
        private array $availableMarkets,
        private string $id,
        /** @var Image[] */
        private array $images,
        private string $name,
        private string $releaseDate,
        private string $releaseDatePrecious,
        private string $type,
        private string $uri,
        /** @var SimpleArtist[] */
        private array $artists
    ) {
    }

    public function getAlbumType(): string
    {
        return $this->albumType;
    }

    public function getTotalTracks(): int
    {
        return $this->totalTracks;
    }

    public function getAvailableMarkets(): array
    {
        return $this->availableMarkets;
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

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getReleaseDatePrecious(): string
    {
        return $this->releaseDatePrecious;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getSimpleArtist(): array
    {
        return $this->artists;
    }
}