<?php

namespace App\Services\Integration;

readonly class Api1
{
    public function __construct(private string $baseUrl, private string $apiToken)
    {

    }

    public function send()
    {
        return "Api1 send to {$this->baseUrl} with {$this->apiToken}";
    }
}
