<?php

namespace Whtspoint\Elephy\Interface;

interface HttpExceptionInterface
{
    public function getHttpCode(): int;
    public function getMessage(): string;
}