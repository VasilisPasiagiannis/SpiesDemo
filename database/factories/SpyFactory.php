<?php

namespace Database\Factories;

use App\Domains\Agencies\Models\AgencyEnum;
use App\Domains\Spies\Models\Spy;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpyFactory extends Factory
{
    protected $model = Spy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'agency' => $this->faker->randomElement(AgencyEnum::values()), // Correctly get the string value from enum
            'country_of_operation' => $this->faker->country(),
            'birthday' => $this->faker->date(),
            'deathday' => $this->faker->optional()->date(),
        ];
    }


}
