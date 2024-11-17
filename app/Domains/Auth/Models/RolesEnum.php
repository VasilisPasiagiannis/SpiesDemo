<?php

namespace App\Domains\Auth\Models;

enum RolesEnum: int
{
    case Administrator = 1;
    case API = 2;

    public function label(): string
    {
        return match ($this) {
            self::Administrator => 'Administrator',
            self::API => 'API Access',
        };
    }
}
