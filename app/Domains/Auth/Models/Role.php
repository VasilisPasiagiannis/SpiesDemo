<?php

namespace App\Domains\Auth\Models;

use App\Domains\Auth\Models\Traits\Attribute\RoleAttribute;
use App\Domains\Auth\Models\Traits\Method\RoleMethod;
use App\Domains\Auth\Models\Traits\Scope\RoleScope;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 * @method static where(string $string, string $string1, string $string2)
 * @method static find(string $id)
 */
class Role extends SpatieRole
{
    use RoleAttribute,
        RoleMethod,
        RoleScope;

    /**
     * @var string[]
     */
    protected $with = [
        'permissions',
    ];
}
