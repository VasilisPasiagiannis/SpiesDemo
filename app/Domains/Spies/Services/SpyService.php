<?php

namespace App\Domains\Spies\Services;


use App\Domains\Events\Models\CustomEvent;
use App\Domains\Events\Models\EventTypeEnum;
use App\Domains\Events\Services\CustomEventService;
use App\Domains\Spies\Commands\CreateSpyCommand;
use App\Domains\Spies\Models\Spy;
use App\Domains\Spies\Repositories\SpyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SpyService
{
    public function __construct(private SpyRepositoryInterface $repository)
    {
    }

    public function get(): array
    {
        return $this->repository->get();
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginated(array $filters): LengthAwarePaginator
    {
        return $this->repository->paginated($filters);
    }

    /**
     * @param string $id
     * @return Spy|null
     */
    public function getById(string $id): ?Spy
    {
        return $this->repository->getById($id);
    }

    /**
     * @param CreateSpyCommand $entity
     * @return Spy|null
     */
    public function store(CreateSpyCommand $entity): ?Spy
    {
        $spy = $this->repository->store($entity);

        if($spy) {
            // spy creation event
            $this->spyCreatedEvent($spy);
        }

        return $spy;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function deleteById(string $id): bool
    {
        return $this->repository->deleteById($id);
    }

    /**
     * @param Spy $spy
     * @return void
     */
    public function spyCreatedEvent(Spy $spy): void
    {
        // Create the event payload
        $payload = [];

        $customEventDTO = new CustomEvent();
        $customEventDTO->setEventType(EventTypeEnum::SPY_STORE);
        $customEventDTO->setPayload(json_encode($payload));
        $customEventDTO->setEntities([$spy]);

        // send event to queue
        $customEventService = new CustomEventService();
        $customEventService->send($customEventDTO);

    }
}
