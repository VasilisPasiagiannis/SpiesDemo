<?php

namespace App\Domains\Spies\Events;

use App\Domains\Events\EventHandlerInterface;
use App\Domains\Events\Models\CustomEvent;

interface SpyStoreEventInterface extends EventHandlerInterface
{
    public function sendEvent(CustomEvent $customEvent): void;

}
