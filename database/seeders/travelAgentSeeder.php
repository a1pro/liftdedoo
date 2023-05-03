<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\travel_agent;
use Illuminate\Database\Seeder;

class travelAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agent = travel_agent::find(1);
        if (!$agent) {
            $agent = new travel_agent();
            $agent->id = "1";
        }
        $agent->user_id="3";
        $agent->agency_name="Agent";
        $agent->registration_number = "1967";
        $agent->number_of_vehicles = "3";
        $agent->save();
    }
}
