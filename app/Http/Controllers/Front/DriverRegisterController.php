<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class DriverRegisterController extends Controller
{
    public function index(){
        $result['vehicle']=VehicleType::all();
        return view('front.driver.driver_register',$result);
    }
}
