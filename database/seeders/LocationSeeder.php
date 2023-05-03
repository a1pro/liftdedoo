<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = location::find(1);
        if (!$location) {
            $location = new location();
            $location->id = "1";
        }
        $location->location="Asansol";

        $location->save();

        $location = location::find(2);
        if (!$location) {
            $location = new location();
            $location->id = "2";
        }
        $location->location="Durgapur";

        $location->save();
    }
}
