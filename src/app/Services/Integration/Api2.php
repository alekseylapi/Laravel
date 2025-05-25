<?php

namespace App\Services\Integration;

use GuzzleHttp\Client;

class Api2
{
    public function __construct(private Client $client)
    {

    }

    public function send()
    {
        return "Api2 send";
    }
}
