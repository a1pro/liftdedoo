<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $driver = driver::find(1);
        if (!$driver) {
            $driver = new driver();
            $driver->id = "1";
        }
        $driver->user_id="2";
        $driver->name = "Driver";
        $driver->gender = "male";
        $driver->age = "19";
        $driver->license_number = "997733";
        $driver->dob="2021/11/1";
        $driver->save();
    }

}
