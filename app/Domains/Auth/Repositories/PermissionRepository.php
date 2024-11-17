<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository implements PermissionRepositoryInterface
{
    private Permission $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function get(): array
    {
        // TODO: Implement get() method.
    }

    /**
     * @param $userId
     * @return array Array contains permissions ids by UserId.
     */
    public function getPermissionByUserId($userId): array
    {
        $user = User::find($userId);
        return $user->permissions->modelKeys();
    }

    /**
     * @param $roleId
     * @return array Array contains permissions ids by RoleId.
     */
    public function getPermissionIdByRoleId($roleId): array
    {
        $role = Role::find($roleId);
        return $role->permissions->modelKeys();
    }

    /**
     *@return Permission[]
     */
    public function getCategorizedPermissions(): array
    {
        $permissions = $this->model::isMaster()
            ->with('children')
            ->get();

        return $permissions;
    }

    /**
     *@return Permission[]
     */
    public function getUncategorizedPermissions(): array
    {
        $permissions = $this->model::singular()
            ->orderBy('sort', 'asc')
            ->get();

        return $permissions;
    }

    /**
     *@return Permission[]
     */
    public function getRolePermissions($roleId): array
    {
        return Role::find($roleId);
    }

    public function getById(string $id): ?User
    {
        // TODO: Implement getById() method.
    }

    public function store(Model $entity): ?User
    {
        // TODO: Implement store() method.
    }

    public function update(Model $entity, string $id): ?User
    {
        // TODO: Implement update() method.
    }

    public function deleteById(string $id): bool
    {
        // TODO: Implement deleteById() method.
    }


}
