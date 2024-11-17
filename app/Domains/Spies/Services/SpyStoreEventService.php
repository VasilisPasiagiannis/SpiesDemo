<?php

namespace App\Domains\Spies\Services;

use App\Domains\Events\Models\CustomEvent;
use App\Domains\Spies\Events\SpyStoreEventInterface;

class SpyStoreEventService implements SpyStoreEventInterface
{

    public function __construct()
    {

    }

    /**
     * @param CustomEvent $customEvent
     * @return void
     */
    public function sendEvent(CustomEvent $customEvent): void
    {
        //todo send event
        \Log::info('Spy Created Event!');
    }

}
