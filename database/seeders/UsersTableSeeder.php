<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\contact_right;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        if (!$user) {
            $user = new User();
            $user->id = "1";
        }

        $user->email = "admin@liftdedoo.com";
        $user->password = Hash::make('Admin@123');
        $user->mobile = "1234567891";

        $user->role = "0";
        $user->save();

        $user = User::find(2);
        if (!$user) {
            $user = new User();
            $user->id = "2";
        }

        $user->email = "driver@liftdedoo.com";
        $user->password = Hash::make('Driver@123');
        $user->mobile = "1234567892";
        $user->role = "1";
        $user->save();

        $user = User::find(3);
        if (!$user) {
            $user = new User();
            $user->id = "3";
        }

        $user->email = "agency@liftdedoo.com";
        $user->password = Hash::make('Agency@123');
        $user->mobile = "1234567893";
        $user->role = "2";
        $user->save();
    }

}
