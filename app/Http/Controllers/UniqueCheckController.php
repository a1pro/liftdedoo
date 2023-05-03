<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\driver;
use App\Models\vehicle;
use App\Models\travel_agent;
use Str;
class UniqueCheckController extends Controller
{

    public function uniqueMobileNumber(Request $request)
    {
        if($request->id !="")
        {
            $usermob = User::where('mobile',$request->mobile)->where('id','!=',$request->id)->first();
        }
        else
        {
            $usermob = User::where('mobile',$request->mobile)->first();
           
        }
        if(!empty($usermob))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function uniqueEmailNumber(Request $request)
    {
        if($request->email != "")
        {
            $useremail = User::where('email',$request->email)->first();
            if(!empty($useremail))
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }
        
    }

    public function uniqueLicenseNumber(Request $request)
    {
        if($request->id !="")
        {
            $driverlice = driver::where('license_number',$request->license_number)->where('user_id','!=',$request->id)->first();
        }
        else
        {
            $driverlice = driver::where('license_number',$request->license_number)->first();
        }
        if(!empty($driverlice))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function uniqueCarNumber(Request $request)
    {
        if($request->vehicleId!="")
        {
            $carnum = vehicle::where('vehicle_registration_number',$request->vehicle_registration_number)->where('id','!=',$request->vehicleId)->first();
        }
        else
        {
            $carnum = vehicle::where('vehicle_registration_number',$request->vehicle_registration_number)->first();
        }
        
        if(!empty($carnum))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    public function uniqueRegNumber(Request $request)
    {
        $regnum = travel_agent::where('registration_number',$request->registration_number)->first();
        if(!empty($regnum))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
