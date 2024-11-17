<?php

namespace App\Domains\Spies\Events;

use App\Domains\Events\Models\CustomEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SpyStoreEvent
{
    use Dispatchable, SerializesModels;
    public CustomEvent $customEvent;
    public function __construct(CustomEvent $customEvent)
    {
        $this->customEvent = $customEvent;
    }

}
