<?php

namespace WhtsPoint\Elephy\Entity;

use WhtsPoint\Elephy\Interface\TracksLoaderInterface;
use WhtsPoint\Elephy\ValueObject\Copyright;

class Album
{
    public function __construct(
        private readonly string $albumType,
        private readonly int $totalTracks,
        private readonly ?array $availableMarkets,
        private readonly string $id,
        /** @var Image[] */
        private readonly array $images,
        private readonly string $name,
        private readonly string $releaseDate,
        private readonly string $releaseDatePrecision,
        private readonly ?string $restrictionReason,
        private readonly string $type,
        private readonly string $uri,
        /** @var Copyright[] */
        private readonly ?array $copyrights,
        private readonly ?array $genres,
        private readonly ?string $label,
        private readonly ?int $popularity,
        private readonly TracksLoaderInterface $tracksLoader,
        private readonly ?string $market = null
    ) {}

    public function getAlbumType(): string
    {
        return $this->albumType;
    }

    public function getTotalTracks(): int
    {
        return $this->totalTracks;
    }

    public function getAvailableMarkets(): ?array
    {
        return $this->availableMarkets;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getReleaseDatePrecision(): string
    {
        return $this->releaseDatePrecision;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getGenres(): ?array
    {
        return $this->genres;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getRestrictionReason(): ?string
    {
        return $this->restrictionReason;
    }

    public function getCopyrights(): ?array
    {
        return $this->copyrights;
    }

    public function getTracks(): TracksLoaderInterface
    {
        return $this->tracksLoader;
    }

    public function getMarket(): ?string
    {
        return $this->market;
    }
}