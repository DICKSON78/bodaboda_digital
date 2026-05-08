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

        // Create test passengers for CI
        User::factory()->createMany([
            [
                'name' => 'John Passenger',
                'email' => 'passenger1@bodaboda.com',
                'password' => bcrypt('password123'),
                'role' => 'passenger',
            ],
            [
                'name' => 'Jane Passenger',
                'email' => 'passenger2@bodaboda.com',
                'password' => bcrypt('password123'),
                'role' => 'passenger',
            ],
            [
                'name' => 'Bob Passenger',
                'email' => 'passenger3@bodaboda.com',
                'password' => bcrypt('password123'),
                'role' => 'passenger',
            ],
        ]);

        // Create test rider users for CI
        $riderUsers = User::factory()->createMany([
            [
                'name' => 'John Rider',
                'email' => 'rider1@bodaboda.com',
                'password' => bcrypt('password123'),
                'role' => 'rider',
            ],
            [
                'name' => 'Jane Rider',
                'email' => 'rider2@bodaboda.com',
                'password' => bcrypt('password123'),
                'role' => 'rider',
            ],
        ]);

        // Create test riders for CI (needed for rides foreign key)
        \DB::table('riders')->insert([
            [
                'user_id' => 5,  // John Rider user_id
                'license_number' => 'RIDER001',
                'bike_plate' => 'ABC123',
                'bike_image' => 'bike1.jpg',
                'status' => 'online',
                'is_approved' => true,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone_number' => '+255123456789',
                'current_lat' => -6.8167,
                'current_lng' => 39.2800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,  // Jane Rider user_id
                'license_number' => 'RIDER002',
                'bike_plate' => 'XYZ789',
                'bike_image' => 'bike2.jpg',
                'status' => 'online',
                'is_approved' => true,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'phone_number' => '+255987654321',
                'current_lat' => -6.8200,
                'current_lng' => 39.2830,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create test rides data
        \DB::table('rides')->insert([
            [
                'passenger_id' => 2,  // John Passenger
                'rider_id' => 1,      // John Rider
                'pickup_lat' => -6.8167,
                'pickup_lng' => 39.2800,
                'dest_lat' => -6.8200,
                'dest_lng' => 39.2830,
                'fare' => 5000,
                'status' => 'completed',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(1),
            ],
            [
                'passenger_id' => 3,  // Jane Passenger
                'rider_id' => 2,      // Jane Rider
                'pickup_lat' => -6.8167,
                'pickup_lng' => 39.2800,
                'dest_lat' => -6.8250,
                'dest_lng' => 39.2900,
                'fare' => 3000,
                'status' => 'ongoing',
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(15),
            ],
            [
                'passenger_id' => 4,  // Bob Passenger
                'rider_id' => 1,      // John Rider
                'pickup_lat' => -6.8167,
                'pickup_lng' => 39.2800,
                'dest_lat' => -6.8300,
                'dest_lng' => 39.2950,
                'fare' => 7000,
                'status' => 'completed',
                'created_at' => now()->subHours(4),
                'updated_at' => now()->subHours(3),
            ],
        ]);

        // Create test ratings data
        \DB::table('ratings')->insert([
            [
                'ride_id' => 1,
                'from_user_id' => 1,  // Admin user rates
                'to_user_id' => 5,    // John Rider receives rating
                'rating' => 5,
                'comment' => 'Excellent service!',
                'created_at' => now()->subHours(1),
                'updated_at' => now()->subHours(1),
            ],
            [
                'ride_id' => 1,
                'from_user_id' => 5,  // John Rider rates
                'to_user_id' => 2,    // John Passenger receives rating
                'rating' => 4,
                'comment' => 'Good passenger',
                'created_at' => now()->subHours(1),
                'updated_at' => now()->subHours(1),
            ],
            [
                'ride_id' => 3,
                'from_user_id' => 4,  // Bob Passenger rates
                'to_user_id' => 5,    // John Rider receives rating
                'rating' => 5,
                'comment' => 'Very professional',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
        ]);
    }
}
