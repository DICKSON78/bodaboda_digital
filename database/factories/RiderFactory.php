<?php

namespace Database\Factories;

use App\Models\Rider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiderFactory extends Factory
{
    protected $model = Rider::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => 'offline',
            'is_approved' => false,
            'bike_plate' => strtoupper(fake()->bothify('??? ###')),
            'license_number' => strtoupper(fake()->bothify('LIC-#####')),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
}
