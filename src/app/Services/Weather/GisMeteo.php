<?php

namespace App\Services\Weather;

class GisMeteo implements WeatherSourceInterface
{
    private string $baseurl = 'https://gismeteo.ru/api/';
    private const WEATHER_URL = 'weather/';

    private string $token = 'some_token_from_config';

    public function __construct(/*private ClientInterface $client, */)
    {
//        $this->token = config('gismeteo.token');
//        $this->baseurl = config('gismeteo.baseurl');
    }

    public function getWeather(string $city): float
    {
//        $this->client->get(
//            $this->baseurl . self::WEATHER_URL . $city,
//            [
//                'headers' => [
//                    'Authorization' => 'Bearer ' . $this->token
//                ],
//            ]
//        );

        return 25;
    }
}
