<?php

namespace Database\Factories\Property;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'area' => $this->faker->numberBetween(1, 1000),
            'price' => $this->faker->numberBetween(1, 10000000000),
            'description' => $this->faker->text,
            'latitude' => $this->faker->numberBetween(-90, 90),
            'longitude' => $this->faker->numberBetween(-180, 180),
            'user_id' => $this->faker->numberBetween(1, 7),
            'status' => 'in_market',
            'service' => 'sale',
            'is_disabled' =>  $this->faker->boolean,
        ];
    }

}
