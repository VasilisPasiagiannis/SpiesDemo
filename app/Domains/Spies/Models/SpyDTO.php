<?php

namespace App\Domains\Spies\Models;

use Illuminate\Http\Resources\Json\JsonResource;

class SpyDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'agency' => $this->agency,
            'country_of_operation' => $this->country_of_operation,
            'birthday' => $this->birthday?->format('Y-m-d'),
            'deathday' => $this->deathday?->format('Y-m-d'),
        ];
    }
}
