<?php

namespace App\Services\Weather;

use Illuminate\Support\Facades\Cache as CacheFacade;

class Cache implements WeatherSourceInterface
{
    public function __construct(private WeatherSourceInterface $api)
    {
    }

    public function getWeather(string $city): float
    {
        $key = "weather_{$city}";
        $weather = CacheFacade::get($key);
        if ($weather === null) {
            $weather = $this->api->getWeather($city);

            CacheFacade::set($key, $weather, 60 * 15);
        }

        return $weather;
    }
}
