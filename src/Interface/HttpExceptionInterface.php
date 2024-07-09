<?php

namespace WhtsPoint\Elephy\Interface;

interface HttpExceptionInterface
{
    public function getHttpCode(): int;
    public function getMessage(): string;
}