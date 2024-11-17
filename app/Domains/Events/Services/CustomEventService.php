<?php

namespace App\Domains\Events\Services;

use App\Domains\Events\Models\CustomEvent;
use App\Domains\Events\Models\EventTypeEnum;
use App\Domains\Spies\Events\SpyStoreEvent;

/**
 * Create CustomEventService to handle multiple events in one service
 */
class CustomEventService
{
    public function __construct()
    {

    }

    /**
     * @param CustomEvent $customEvent
     * @return void
     */
    public function send(CustomEvent $customEvent): void
    {
        switch ($customEvent->getEventType()) {
            case EventTypeEnum::SPY_STORE:
                event(new SpyStoreEvent($customEvent));
                break;
            default:
                break;
        }

    }

}
