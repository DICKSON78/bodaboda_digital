<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@bodaboda.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Create test users for CI
        User::factory()->count(5)->create();

        // Create test riders for CI (needed for rides foreign key)
        \DB::table('riders')->insert([
            [
                'user_id' => 1,
                'license_number' => 'RIDER001',
                'bike_plate' => 'ABC123',
                'bike_image' => 'bike1.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'license_number' => 'RIDER002',
                'bike_plate' => 'XYZ789',
                'bike_image' => 'bike2.jpg',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create test rides data
        \DB::table('rides')->insert([
            [
                'passenger_id' => 1,
                'rider_id' => 1,
                'pickup_lat' => -6.8167,
                'pickup_lng' => 39.2800,
                'dest_lat' => -6.8200,
                'dest_lng' => 39.2830,
                'fare' => 5000,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'passenger_id' => 2,
                'rider_id' => 2,
                'pickup_lat' => -6.8167,
                'pickup_lng' => 39.2800,
                'dest_lat' => -6.8250,
                'dest_lng' => 39.2900,
                'fare' => 3000,
                'status' => 'ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'passenger_id' => 3,
                'rider_id' => 1,
                'pickup_lat' => -6.8167,
                'pickup_lng' => 39.2800,
                'dest_lat' => -6.8300,
                'dest_lng' => 39.2950,
                'fare' => 7000,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
