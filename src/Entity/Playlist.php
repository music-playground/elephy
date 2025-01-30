<?php

namespace MusicPlayground\Elephy\Entity;

class Playlist
{
    public function __construct(
        private readonly bool $isCollaborative,
        private readonly ?string $description,
        private readonly int $total,
        private readonly string $id,
        /** @var Image[] */
        private readonly array $images,
        private readonly string $name,
        private readonly bool $isPublic,
        private readonly string $snapshotId,
        private readonly string $type,
        private readonly string $uri
    ) {}

    public function getSnapshotId(): string
    {
        return $this->snapshotId;
    }

    public function isCollaborative(): bool
    {
        return $this->isCollaborative;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTotal(): int
    {
        return $this->total;
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

    public function isPublic(): bool
    {
        return $this->isPublic;
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