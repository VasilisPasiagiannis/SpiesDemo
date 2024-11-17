<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
interface RepositoryInterface
{
    public function get(): array;
    public function getById(string $id): ?Model;
    public function store(Model $entity): ?Model;
    public function update(Model $entity, string $id): ?Model;
    public function deleteById(string $id): bool;

}
