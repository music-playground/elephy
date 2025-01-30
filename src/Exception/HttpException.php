<?php

namespace MusicPlayground\Elephy\Exception;

use Exception;
use MusicPlayground\Elephy\Interface\HttpExceptionInterface;

class HttpException extends Exception implements HttpExceptionInterface
{
    public function __construct(
        private readonly int $httpCode,
        $message = '',
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}