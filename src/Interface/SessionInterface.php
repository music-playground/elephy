<?php

namespace WhtsPoint\Elephy\Interface;

interface SessionInterface
{
    /**
    * @return array{ access_token: string, token_type: string, expire_in: int }
    **/
    public function requestAccessToken(): array;
    public function getAccessToken(): string;
}