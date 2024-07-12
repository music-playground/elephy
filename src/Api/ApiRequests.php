<?php

namespace WhtsPoint\Elephy\Api;

use WhtsPoint\Elephy\Util\Request;

class ApiRequests
{
    private readonly Request $getRequest;
    private readonly Request $putRequest;
    private readonly Request $deleteRequest;

    public function __construct(string $apiUrl)
    {
        $request = (new Request())->withApiUrl($apiUrl);
        $this->getRequest = $request;
        $this->putRequest = $request->addOptions([
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_CUSTOMREQUEST => 'PUT'
        ]);
        $this->deleteRequest = $request->addOptions([
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ]);
    }

    public function getGetRequest(): Request
    {
        return $this->getRequest;
    }

    public function getPutRequest(): Request
    {
        return $this->putRequest;
    }

    public function getDeleteRequest(): Request
    {
        return $this->deleteRequest;
    }
}