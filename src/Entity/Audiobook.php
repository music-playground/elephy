<?php

namespace WhtsPoint\Elephy\Entity;

use WhtsPoint\Elephy\ValueObject\Copyright;

class Audiobook
{
    public function __construct(
        /** @var string[] */
        private readonly array $authors,
        /** @var string[] */
        private readonly array $availableMarkets,
        /** @var Copyright[] */
        private readonly array $copyrights,
        private readonly string $description,
        private readonly string $htmlDescription,
        private readonly string $edition,
        private readonly bool $isExplicit,
        private readonly string $id,
        /** @var Image[] */
        private readonly array $images,
        /** @var string[] */
        private readonly array $languages,
        private readonly string $mediaType,
        private readonly string $name,
        /** @var string[] */
        private readonly array $narrators,
        private readonly string $publisher,
        private readonly string $type,
        private readonly string $uri,
        private readonly int $totalChapters
    ) {}

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getAvailableMarkets(): array
    {
        return $this->availableMarkets;
    }

    public function getCopyrights(): array
    {
        return $this->copyrights;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getHtmlDescription(): string
    {
        return $this->htmlDescription;
    }

    public function getEdition(): string
    {
        return $this->edition;
    }

    public function isExplicit(): bool
    {
        return $this->isExplicit;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNarrators(): array
    {
        return $this->narrators;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getTotalChapters(): int
    {
        return $this->totalChapters;
    }
}