<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * Class UserService.
 */
class UserService
{
    private UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return User|null
     */
    public function getAuthUser(): ?User
    {
        return $this->repository->getAuthUser();
    }

    /**
     * @param int $userId
     * @param string|int $role
     * @return bool
     */
    public function hasRole(int $userId, string|int $role): bool
    {
        return $this->repository->hasRole($userId, $role);
    }

    /**
     * @param string $id
     * @return User
     */
    public function getById(string $id): User
    {
        return $this->repository->getById($id);
    }

    /**
     * @param string $roleId
     * @return User[]
     */
    public function getByRoleId(string $roleId): array
    {
        return $this->repository->getByRoleId($roleId);
    }

    /**
     * @param User $entity
     * @return User
     */
    public function store(User $entity): User
    {
        return $this->repository->store($entity);
    }

    /**
     * @param User $entity
     * @param string $id
     * @param bool $updateRole
     * @return User
     */
    public function update(User $entity, string $id, bool $updateRole = false): User
    {
        return $this->repository->update($entity, $id, $updateRole);
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
     * @param User $user
     * @return JsonResponse
     */
    public function apiAuthentication(User $user): JsonResponse
    {
        return $this->repository->apiAuthentication($user);
    }

    /**
     * @return JsonResponse
     */
    public function apiLogOut(): JsonResponse
    {
        return $this->repository->apiLogOut();
    }

}
