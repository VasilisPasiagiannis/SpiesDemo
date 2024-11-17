<?php

namespace App\Domains\Events\Models;

use Illuminate\Database\Eloquent\Model;

class CustomEvent
{
    /**
     * @var Model[]
     */
    private array $entities = [];

    private EventTypeEnum $eventType;

    private ?string $payload = null;

    public function getEntities(): array
    {
        return $this->entities;
    }

    public function setEntities(array $entities): CustomEvent
    {
        $this->entities = $entities;
        return $this;
    }

    public function getEventType(): EventTypeEnum
    {
        return $this->eventType;
    }

    public function setEventType(EventTypeEnum $eventType): CustomEvent
    {
        $this->eventType = $eventType;
        return $this;
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function setPayload(?string $payload): CustomEvent
    {
        $this->payload = $payload;
        return $this;
    }


}
