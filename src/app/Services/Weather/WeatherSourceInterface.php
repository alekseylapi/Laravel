<?php

namespace App\Services\Weather;

interface WeatherSourceInterface
{
    /**
     * Получить текущую температуру для города
     *
     * @param string $city
     * @return float Температура
     */
    public function getWeather(string $city): float;
}
