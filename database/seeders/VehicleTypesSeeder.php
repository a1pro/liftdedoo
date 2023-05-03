<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicle = VehicleType::find(1);
        if (!$vehicle) {
            $vehicle = new VehicleType();
            $vehicle->id = "1";
        }
        $vehicle->vehicle_name = "swift";
        $vehicle->seat_capacity = "4";
        $vehicle->save();

        $vehicle = VehicleType::find(2);
        if (!$vehicle) {
            $vehicle = new VehicleType();
            $vehicle->id = "2";
        }
        $vehicle->vehicle_name = "xuv500";
        $vehicle->seat_capacity = "6";
        $vehicle->save();
    }
}
