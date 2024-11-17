<?php

namespace App\Domains\Events;


use App\Domains\Events\Models\CustomEvent;

interface EventHandlerInterface
{
    public function sendEvent(CustomEvent $customEvent): void;

}
