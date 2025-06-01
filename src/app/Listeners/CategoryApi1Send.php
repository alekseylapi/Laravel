<?php

namespace App\Listeners;

use App\Events\CategoryCreated;
use App\Services\Integration\Api1;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CategoryApi1Send
{
    /**
     * Create the event listener.
     */
    public function __construct(private Api1 $api)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(CategoryCreated $event): void
    {
        var_dump($event->category->id);
        var_dump('CategoryApi1Send::handle');
        var_dump($this->api->send());
    }
}
