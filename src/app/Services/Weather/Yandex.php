<?php

namespace App\Services\Weather;

class Yandex implements WeatherSourceInterface
{
    public function __construct(private WeatherSourceInterface $reserve)
    {
    }

    public function getWeather(string $city): float
    {
        if (mt_rand(0, 10) > 4) {
            return -5;
        } else {
            // резерв
            return $this->reserve->getWeather($city) + 50;
        }
    }
}
