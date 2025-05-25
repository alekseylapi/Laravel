<?php

namespace App\Providers;

use App\Services\Integration\Api1;
use GuzzleHttp\Client;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
