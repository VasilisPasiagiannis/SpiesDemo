<?php

namespace App\Domains\Agencies\Models;

enum AgencyEnum : string
{
    case CIA = 'CIA';
    case MI6 = 'MI6';
    case KGB = 'KGB';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
