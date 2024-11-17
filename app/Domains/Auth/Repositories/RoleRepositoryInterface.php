<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Role;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Role[]
     */
    public function get(): array;

    /**
     * @param string $userId
     * @return int[] Array contains role ids by userId.
     */
    public function getRolesIdByUserId(string $userId): array;

    /**
     * @param string $id
     * @return Role|null
     */
    public function getById(string $id): ?Role;

    /**
     * @param string $roleName
     * @return Role|null
     */
    public function getByName(string $roleName): ?Role;

    /**
     * @param Role|Model $entity
     * @return Role|null
     */
    public function store(Role|Model $entity): ?Role;

    /**
     * @param Role|Model $entity
     * @param string $id
     * @return Role|null
     */
    public function update(Role|Model $entity, string $id): ?Role;

    /**
     * @param string $id
     * @return bool
     */
    public function deleteById(string $id): bool;
}
