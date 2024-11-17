<?php

namespace App\Domains\Spies\Models;

use App\Domains\Agencies\Models\AgencyEnum;
use Database\Factories\SpyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Spy extends Model
{
    use HasFactory;
//    use SoftDeletes;

    protected $table = 'spies';
    protected $fillable = [
        'name',
        'surname',
        'agency',
        'country_of_operation',
        'birthday',
        'deathday',
    ];

    protected $casts = [
        'birthday'  => 'date:Y-m-d',
        'deathday'  => 'date:Y-m-d',
        'agency' => AgencyEnum::class, // Automatically casts to/from the enum
    ];

    protected static function newFactory(): SpyFactory|Factory
    {
        return SpyFactory::new();
    }


}
