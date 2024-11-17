<?php

namespace App\Domains\Auth\Models;

use App\Domains\Auth\Models\Traits\Relationship\PermissionRelationship;
use App\Domains\Auth\Models\Traits\Scope\PermissionScope;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission.
 * @method static find(mixed $permission)
 */
class Permission extends SpatiePermission
{
    use PermissionRelationship,
        PermissionScope;
}
