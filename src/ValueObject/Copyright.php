<?php

namespace MusicPlayground\Elephy\ValueObject;

class Copyright
{
    public function __construct(
        private readonly string $text,
        private readonly string $type
    ) {}

    public function getText(): string
    {
        return $this->text;
    }

    public function getType(): string
    {
        return $this->type;
    }
}