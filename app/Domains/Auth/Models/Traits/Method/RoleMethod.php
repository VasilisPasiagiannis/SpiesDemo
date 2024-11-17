<?php

namespace App\Domains\Auth\Models\Traits\Method;

use App\Domains\Auth\Models\RolesEnum;
use Illuminate\Support\Collection;

/**
 * Trait RoleMethod.
 */
trait RoleMethod
{
    /**
     * @return mixed
     */
    public function isAdmin(): bool
    {
        return $this->name === RolesEnum::Administrator->label();
    }

    /**
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this->permissions->pluck('description');
    }
}
