<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            // ContactUsSeeder::class,
            // LocationSeeder::class,
            // CmsPagesSeeder::class,
            // DriverSeeder::class,
            // travelAgentSeeder::class,
            // VehicleTypesSeeder::class,
            // VehicleSeeder::class,
            //  BookingSeeder::class,
        ]);
    }
}
