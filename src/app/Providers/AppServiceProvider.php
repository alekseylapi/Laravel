<?php

namespace App\Providers;

use App\Services\Integration\Api1;
use App\Services\Weather\Cache;
use App\Services\Weather\GisMeteo;
use App\Services\Weather\OpenWeather;
use App\Services\Weather\WeatherSourceInterface;
use App\Services\Weather\Yandex;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Api1::class, function () {
            return new Api1(config("services.api1.baseurl"), config("services.api1.token"));
        });

        $this->app->when(Cache::class)->needs(WeatherSourceInterface::class)->give(OpenWeather::class);
        $this->app->when(OpenWeather::class)->needs(WeatherSourceInterface::class)->give(Yandex::class);
        $this->app->when(Yandex::class)->needs(WeatherSourceInterface::class)->give(GisMeteo::class);
        $this->app->bind(WeatherSourceInterface::class, function () {
            return app(Cache::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
