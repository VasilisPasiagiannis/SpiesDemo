<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\User;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @return User|null
     */
    public function getAuthUser(): ?User;

    /**
     * @param int $userId
     * @param string|int $role
     * @return bool
     */
    public function hasRole(int $userId, string|int $role): bool;

    /**
     * @param string $id
     * @return User|null
     */
    public function getById(string $id): ?User;

    /**
     * @param string $roleId
     * @return User[]
     */
    public function getByRoleId(string $roleId ) : array;

    /**
     * @param User|Model $entity
     * @return User|null
     */
    public function store(User|Model $entity): ?User;

    /**
     * @param User|Model $entity
     * @param string $id
     * @param bool $updateRole
     * @return User|null
     */
    public function update(User|Model $entity, string $id, bool $updateRole = false): ?User;

    /**
     * @param string $id
     * @return bool
     */
    public function deleteById(string $id): bool;

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function apiAuthentication(User $user): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function apiLogOut(): JsonResponse;
}
