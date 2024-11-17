<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class RoleRepository implements RoleRepositoryInterface
{
    private Role $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function getById(string $id): ?Role
    {
        return $this->model->with('permissions')->findOrFail($id);
    }

    public function getByName(string $roleName): ?Role
    {
        return $this->model->where('name', $roleName)->first();
    }

    /**
     * @return Role[]
     */
    public function get(): array
    {
        return $this->model::get();
    }

    /**
     * @param string $userId
     * @return int[] Array contains role ids by userId.
     */
    public function getRolesIdByUserId(string $userId): array
    {
        $user = new User();
        $user = $user->find($userId);

        return $user->roles->pluck('id')->toArray();
    }


    /**
     * @throws GeneralException
     */
    public function store(Role|Model $entity): ?Role
    {
        DB::beginTransaction();

        try {
            $role = $this->model::create(['guard_name' => $entity->getGuardName(), 'name' => $entity->getName()]);

            $permissions = [];
            foreach ($entity->getPermissions() as $permission) {
                $permissions[] = Permission::find($permission);
            }

            $role->syncPermissions($permissions ?? []);


            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating the role.'));
        }

        DB::commit();

        return $role;
    }

    /**
     * @throws GeneralException
     */
    public function update($entity, string $id): ?Role
    {
        DB::beginTransaction();

        try {
            $role = Role::find($id);

            $role->update(['name' => $entity->name]);
            $permissions = [];
            foreach ($entity->permissions as $permission) {
                $permissions[] = Permission::find($permission);
            }

            $role->syncPermissions($permissions ?? []);

            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem updating the role.'));
        }

        DB::commit();

        return $role;
    }

    /**
     * @throws BindingResolutionException
     */
    public function deleteById(string $id): bool
    {
        $role = Role::where('id', '!=', 1)
            ->where('id', '!=', 2)
            ->find($id);

        if (!$role || $role->users()->count()) {
            return false;
        }

        $role->delete();
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        return true;
    }

}
