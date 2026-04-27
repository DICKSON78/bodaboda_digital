<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $riders = [
            [
                'name' => 'Juma Hamisi',
                'email' => 'juma@example.com',
                'phone' => '0712345678',
                'plate' => 'MC 123 ABC',
                'lat' => -6.1731,
                'lng' => 35.7419, // Near City Center
            ],
            [
                'name' => 'Said Bakari',
                'email' => 'said@example.com',
                'phone' => '0787654321',
                'plate' => 'MC 456 DEF',
                'lat' => -6.1820,
                'lng' => 35.7500, // Near Area D
            ],
            [
                'name' => 'Amani John',
                'email' => 'amani@example.com',
                'phone' => '0755998877',
                'plate' => 'MC 789 GHI',
                'lat' => -6.1650,
                'lng' => 35.7350, // Near Majengo
            ],
            [
                'name' => 'Kassim Musa',
                'email' => 'kassim@example.com',
                'phone' => '0622334455',
                'plate' => 'MC 321 JKL',
                'lat' => -6.1900,
                'lng' => 35.7200, // Near University of Dodoma area
            ],
        ];

        foreach ($riders as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'rider',
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($data['name']) . '&background=2F6B3F&color=fff',
            ]);

            Rider::create([
                'user_id' => $user->id,
                'first_name' => explode(' ', $data['name'])[0],
                'last_name' => explode(' ', $data['name'])[1] ?? '',
                'phone_number' => $data['phone'],
                'license_number' => 'LIC-' . rand(10000, 99999),
                'bike_plate' => $data['plate'],
                'status' => 'online',
                'is_approved' => true,
                'current_lat' => $data['lat'],
                'current_lng' => $data['lng'],
            ]);
        }
    }
}
