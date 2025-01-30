<?php

namespace MusicPlayground\Elephy\Entity;

class Track
{
    public function __construct(
        /** @var string[] */
        private readonly ?array $availableMarkets,
        private readonly int $discNumber,
        private readonly int $durationMs,
        private readonly bool $isExplicit,
        private readonly string $id,
        private readonly ?string $restrictionReason,
        private readonly string $name,
        private readonly ?string $previewUrl,
        private readonly int $trackNumber,
        private readonly string $type,
        private readonly string $uri,
        private readonly bool $isLocal
    ) {}

    public function getAvailableMarkets(): ?array
    {
        return $this->availableMarkets;
    }

    public function getDiscNumber(): int
    {
        return $this->discNumber;
    }

    public function getDurationMs(): int
    {
        return $this->durationMs;
    }

    public function isExplicit(): bool
    {
        return $this->isExplicit;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRestrictionReason(): ?string
    {
        return $this->restrictionReason;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function getTrackNumber(): int
    {
        return $this->trackNumber;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function isLocal(): bool
    {
        return $this->isLocal;
    }
}