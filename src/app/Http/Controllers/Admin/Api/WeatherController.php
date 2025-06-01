<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Services\Weather\WeatherSourceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherController extends Controller
{
    public function index(string $city, WeatherSourceInterface $api)
    {
        $temperature = $api->getWeather($city);

        return JsonResource::make([
            'temperature' => $temperature,
        ]);
    }
}
