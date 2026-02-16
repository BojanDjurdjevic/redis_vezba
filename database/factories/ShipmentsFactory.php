<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipments>
 */
class ShipmentsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),

            'from_city' => $this->faker->city(),
            'from_country' => $this->faker->country(),

            'to_city' => $this->faker->city(),
            'to_country' => $this->faker->country(),

            // cena u dinarima (npr 1000 - 50000)
            'price' => $this->faker->numberBetween(1000, 50000),

            // status max 10 karaktera
            'status' => $this->faker->randomElement([
                'pending',
                'shipped',
                'delivered',
                'cancelled'
            ]),

            // pravi novog usera ako ne postoji
            'user_id' => User::factory(),

            'details' => $this->faker->paragraph(),
        ];
    }
}
