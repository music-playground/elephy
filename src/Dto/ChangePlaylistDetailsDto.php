<?php

namespace MusicPlayground\Elephy\Dto;

class ChangePlaylistDetailsDto
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?bool $isPublic = null,
        public readonly ?bool $isCollaborative = null,
        public readonly ?string $description = null
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'public' => $this->isPublic,
            'collaborative' => $this->isCollaborative,
            'description' => $this->description
        ];
    }
}