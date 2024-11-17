<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Repositories\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleService.
 */
class RoleService
{
    private RoleRepositoryInterface $repository;

    /**
     * @param RoleRepositoryInterface $repository
     */
    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $roleId
     * @return Role|null
     */
    public function getById(string $roleId): ?Role
    {
        return $this->repository->getById($roleId);
    }

    /**
     * @param string $roleName
     * @return Role|null
     */
    public function getByName(string $roleName): ?Role
    {
        return $this->repository->getByName($roleName);
    }

    /**
     * @return Role[]
     */
    public function get(): array
    {
        return $this->repository->get();
    }

    /**
     * @param string $userId
     * @return int[] Array contains role ids by userId.
     */
    public function getRolesIdByUserId(string $userId): array
    {
        return $this->repository->getRolesIdByUserId($userId);
    }

    /**
     * @param Model $role
     * @return Model
     */
    public function store(Model $role): Model
    {
        return $this->repository->store($role);
    }

    /**
     * @param $role
     * @param string $id
     * @return Model
     */
    public function update($role, string $id): Model
    {
        return $this->repository->update($role, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool
    {
        return $this->repository->deleteById($id);
    }


}
