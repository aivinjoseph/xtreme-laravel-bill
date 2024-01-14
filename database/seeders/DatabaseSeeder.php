<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BodyType;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Door;
use App\Models\Drive;
use App\Models\Feature;
use App\Models\Fuel;
use App\Models\Manufacturer;
use App\Models\TechnicalCondition;
use App\Models\Transmission;
use App\Models\Trim;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@xtrememotorsinc.com',
            'password' => bcrypt('Khalid@2023'),
            'email_verified_at' => now(),
        ]);
        
        // Manufacturer::insert([
        //     ['name' => 'Audi'],
        //     ['name' => 'Toyota']
        // ]);

        // CarModel::insert([
        //     ['name' => 'A4', 'manufacturer_id' => 1],
        //     ['name' => 'A6', 'manufacturer_id' => 1],
        //     ['name' => 'A8', 'manufacturer_id' => 1],
        //     ['name' => 'Corolla', 'manufacturer_id' => 2],
        //     ['name' => 'Camry', 'manufacturer_id' => 2],
        //     ['name' => 'RAV4', 'manufacturer_id' => 2],
        // ]);

        // BodyType::insert([
        //     ['name' => 'Sedan'],
        //     ['name' => 'SUV'],
        //     ['name' => 'Coupe'],
        //     ['name' => 'Hatchback'],
        //     ['name' => 'Wagon'],
        //     ['name' => 'Convertible'],
        //     ['name' => 'Van'],
        //     ['name' => 'Minivan'],
        //     ['name' => 'Pickup'],
        // ]);

        // Transmission::insert([
        //     ['name' => 'Automatic'],
        //     ['name' => 'Manual'],
        //     ['name' => 'CVT'],
        // ]);

        // Door::insert([
        //     ['name' => '2'],
        //     ['name' => '3'],
        //     ['name' => '4'],
        //     ['name' => '5'],
        // ]);

        // Fuel::insert([
        //     ['name' => 'Gasoline'],
        //     ['name' => 'Diesel'],
        //     ['name' => 'Electric'],
        //     ['name' => 'Hybrid'],
        // ]);

        // TechnicalCondition::insert([
        //     ['name' => 'New'],
        //     ['name' => 'Used'],
        // ]);

        // Drive::insert([
        //     ['name' => 'AWD'],
        //     ['name' => 'FWD'],
        //     ['name' => 'RWD'],
        // ]);

        // Color::insert([
        //     ['name' => 'Black'],
        //     ['name' => 'White'],
        //     ['name' => 'Silver'],
        //     ['name' => 'Gray'],
        //     ['name' => 'Red'],
        //     ['name' => 'Blue'],
        //     ['name' => 'Brown'],
        //     ['name' => 'Green'],
        //     ['name' => 'Yellow'],
        //     ['name' => 'Orange'],
        //     ['name' => 'Purple'],
        //     ['name' => 'Pink'],
        // ]);

        // Feature::insert([
        //     ['name' => 'Advance Key'],
        //     ['name' => 'Active Cruise Control'],
        //     ['name' => 'Bluetooth']
        // ]);

        Trim::insert([
            ['name' => 'Premium'],
            ['name' => 'Premium Plus'],
            ['name' => 'Prestige'],
            ['name' => 'LE'],
            ['name' => 'SE'],
            ['name' => 'XLE'],
            ['name' => 'XSE'],
        ]);
    }
}
