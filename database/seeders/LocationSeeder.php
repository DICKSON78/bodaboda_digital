<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            // Central Business District - Real Dodoma Locations
            ['name' => 'Dodoma Bus Terminal', 'area' => 'Makole', 'latitude' => -6.1731, 'longitude' => 35.7419],
            ['name' => 'Jamhuri Stadium', 'area' => 'Central', 'latitude' => -6.1658, 'longitude' => 35.7496],
            ['name' => 'Dodoma Regional Referral Hospital', 'area' => 'Central', 'latitude' => -6.1820, 'longitude' => 35.7400],
            ['name' => 'University of Dodoma Main Campus', 'area' => 'Mikocheni', 'latitude' => -6.1945, 'longitude' => 35.7634],
            ['name' => 'Nelson Mandela Freedom Square', 'area' => 'Central', 'latitude' => -6.1720, 'longitude' => 35.7425],
            ['name' => 'Dodoma Municipal Council', 'area' => 'Central', 'latitude' => -6.1700, 'longitude' => 35.7400],
            ['name' => 'Tanzania Parliament Buildings', 'area' => 'Central', 'latitude' => -6.1690, 'longitude' => 35.7440],
            ['name' => 'Huduma Centre Dodoma', 'area' => 'Central', 'latitude' => -6.1680, 'longitude' => 35.7380],
            ['name' => 'Dodoma Central Market', 'area' => 'Central', 'latitude' => -6.1780, 'longitude' => 35.7430],
            ['name' => 'Dodoma Post Office', 'area' => 'Central', 'latitude' => -6.1725, 'longitude' => 35.7410],
            ['name' => 'Regional Police Headquarters', 'area' => 'Central', 'latitude' => -6.1690, 'longitude' => 35.7390],
            ['name' => 'Bank of Tanzania Dodoma', 'area' => 'Central', 'latitude' => -6.1710, 'longitude' => 35.7430],
            
            // Major Streets and Areas
            ['name' => 'Kikuyu Avenue', 'area' => 'Central', 'latitude' => -6.1750, 'longitude' => 35.7450],
            ['name' => 'Nyerere Square', 'area' => 'Central', 'latitude' => -6.1705, 'longitude' => 35.7420],
            ['name' => 'Lumumba Street', 'area' => 'Central', 'latitude' => -6.1735, 'longitude' => 35.7445],
            ['name' => 'Sokoine Drive', 'area' => 'Central', 'latitude' => -6.1760, 'longitude' => 35.7460],
            
            // Residential Areas - Real Dodoma Neighborhoods
            ['name' => 'Makole Area A', 'area' => 'Makole', 'latitude' => -6.1600, 'longitude' => 35.7300],
            ['name' => 'Makole Area B', 'area' => 'Makole', 'latitude' => -6.1550, 'longitude' => 35.7350],
            ['name' => 'Mikocheni Area A', 'area' => 'Mikocheni', 'latitude' => -6.1900, 'longitude' => 35.7600],
            ['name' => 'Mikocheni Area B', 'area' => 'Mikocheni', 'latitude' => -6.1950, 'longitude' => 35.7650],
            ['name' => 'Mikocheni Area C', 'area' => 'Mikocheni', 'latitude' => -6.1980, 'longitude' => 35.7680],
            ['name' => 'Ipagala Block A', 'area' => 'Ipagala', 'latitude' => -6.1450, 'longitude' => 35.7200],
            ['name' => 'Ipagala Block B', 'area' => 'Ipagala', 'latitude' => -6.1500, 'longitude' => 35.7250],
            ['name' => 'Chinangali', 'area' => 'Chinangali', 'latitude' => -6.1550, 'longitude' => 35.7350],
            ['name' => 'Majengo ya Makao', 'area' => 'Majengo', 'latitude' => -6.1650, 'longitude' => 35.7350],
            ['name' => 'Ntyugudu', 'area' => 'Ntyugudu', 'latitude' => -6.1700, 'longitude' => 35.7550],
            ['name' => 'Makulu', 'area' => 'Makulu', 'latitude' => -6.1750, 'longitude' => 35.7600],
            ['name' => 'Mlimwa City', 'area' => 'Mlimwa', 'latitude' => -6.1800, 'longitude' => 35.7500],
            
            // Educational Institutions
            ['name' => 'St. Mary\'s School Dodoma', 'area' => 'Central', 'latitude' => -6.1745, 'longitude' => 35.7470],
            ['name' => 'Dodoma Secondary School', 'area' => 'Central', 'latitude' => -6.1770, 'longitude' => 35.7390],
            ['name' => 'Kikuyu Primary School', 'area' => 'Central', 'latitude' => -6.1720, 'longitude' => 35.7460],
            
            // Government Offices
            ['name' => 'Prime Minister\'s Office', 'area' => 'Central', 'latitude' => -6.1675, 'longitude' => 35.7455],
            ['name' => 'Ministry of Finance', 'area' => 'Central', 'latitude' => -6.1660, 'longitude' => 35.7470],
            ['name' => 'Regional Commissioner Office', 'area' => 'Central', 'latitude' => -6.1685, 'longitude' => 35.7365],
            
            // Commercial Areas
            ['name' => 'Dodoma City Mall', 'area' => 'Central', 'latitude' => -6.1740, 'longitude' => 35.7480],
            ['name' => 'Mlimwa Shopping Center', 'area' => 'Mlimwa', 'latitude' => -6.1815, 'longitude' => 35.7515],
            ['name' => 'Makole Market', 'area' => 'Makole', 'latitude' => -6.1580, 'longitude' => 35.7320],
            
            // Religious Institutions
            ['name' => 'Anglican Cathedral Dodoma', 'area' => 'Central', 'latitude' => -6.1730, 'longitude' => 35.7405],
            ['name' => 'Roman Catholic Church', 'area' => 'Central', 'latitude' => -6.1708, 'longitude' => 35.7435],
            ['name' => 'Mosque Dodoma Central', 'area' => 'Central', 'latitude' => -6.1765, 'longitude' => 35.7420],
            
            // Health Facilities
            ['name' => 'Mwalimu Health Center', 'area' => 'Makole', 'latitude' => -6.1620, 'longitude' => 35.7340],
            ['name' => 'Mikocheni Health Center', 'area' => 'Mikocheni', 'latitude' => -6.1920, 'longitude' => 35.7620],
            ['name' => 'Ipagala Dispensary', 'area' => 'Ipagala', 'latitude' => -6.1480, 'longitude' => 35.7220],
            
            // Transportation Hubs
            ['name' => 'Ubungo Bus Stand', 'area' => 'Central', 'latitude' => -6.1715, 'longitude' => 35.7385],
            ['name' => 'Mikocheni Bus Stop', 'area' => 'Mikocheni', 'latitude' => -6.1930, 'longitude' => 35.7610],
            ['name' => 'Makole Taxi Stand', 'area' => 'Makole', 'latitude' => -6.1590, 'longitude' => 35.7310],
            
            // Landmarks and Monuments
            ['name' => 'Independence Monument', 'area' => 'Central', 'latitude' => -6.1695, 'longitude' => 35.7415],
            ['name' => 'Mwalimu Julius Nyerere Statue', 'area' => 'Central', 'latitude' => -6.1702, 'longitude' => 35.7428],
            ['name' => 'Dodoma Railway Station', 'area' => 'Central', 'latitude' => -6.1665, 'longitude' => 35.7375],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
