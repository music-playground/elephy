<?php

namespace MusicPlayground\Elephy\Interface;

interface HttpExceptionInterface
{
    public function getHttpCode(): int;
    public function getMessage(): string;
}