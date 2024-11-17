<?php

namespace App\Domains\Spies\Repositories;

use App\Domains\Spies\Commands\CreateSpyCommand;
use App\Domains\Spies\Models\Spy;
use Illuminate\Pagination\LengthAwarePaginator;

interface SpyRepositoryInterface
{
    /**
     * @return Spy[]
     */
    public function get(): array;

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginated(array $filters): LengthAwarePaginator;

    /**
     * @param string $id
     * @return Spy|null
     */
    public function getById(string $id): ?Spy;

    /**
     * @param CreateSpyCommand $entityCommand
     * @return Spy|null
     */
    public function store(CreateSpyCommand $entityCommand): ?Spy;

    /**
     * @param CreateSpyCommand $entityCommand
     * @param string $id
     * @return Spy|null
     */
    public function update(CreateSpyCommand $entityCommand, string $id): ?Spy;

    /**
     * @param string $id
     * @return bool
     */
    public function deleteById(string $id): bool;

}
