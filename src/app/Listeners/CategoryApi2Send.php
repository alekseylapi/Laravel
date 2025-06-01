<?php

namespace App\Listeners;

use App\Events\CategoryCreated;
use App\Services\Integration\Api2;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CategoryApi2Send
{
    /**
     * Create the event listener.
     */
    public function __construct(private Api2 $api)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(CategoryCreated $event): void
    {
        var_dump($event->category->id);
        var_dump('CategoryApi2Send::handle');
        var_dump($this->api->send());
    }
}
