<?php

namespace App\Domains\Spies\Events\Listeners;

use App\Domains\Spies\Events\SpyStoreEvent;
use App\Domains\Spies\Services\SpyStoreEventService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SpyStoreEventListener implements ShouldQueue
{
    use InteractsWithQueue;
    public string $queue = 'spies-queue';

    public function __construct(protected SpyStoreEventService $spyStoreEventService)
    {
    }

    public function handle(SpyStoreEvent $event): void
    {
        $this->spyStoreEventService->sendEvent($event->customEvent);
    }


}
