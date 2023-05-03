<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\vehicle;
use App\Models\User;
use App\Models\driver;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicle = vehicle::find(1);
        if (!$vehicle) {
            $vehicle = new vehicle();
            $vehicle->id = "1";
        }
        $vehicle->user_id="2";
        $vehicle->vehicle_type_id = "1";
        $vehicle->rate_per_km = "9";
        $vehicle->vehicle_registration_number = "11559";
        $vehicle->save();
    }
}
