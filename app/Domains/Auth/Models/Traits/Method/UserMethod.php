<?php

namespace App\Domains\Auth\Models\Traits\Method;

use App\Domains\Auth\Models\RolesEnum;
use Illuminate\Support\Collection;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * @return bool
     */
    public function isMasterAdmin(): bool
    {
        if($this->hasRole(RolesEnum::Administrator->value)):
            return true;
        else:
            return false;
        endif;
    }

    public function canApi()
    {
        return $this->can('api.view');
    }

    /**
     * @return mixed
     */
    public function isAdmin(): bool
    {
        if($this->hasRole(RolesEnum::Administrator->value)):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this->permissions->pluck('description');
    }



}
