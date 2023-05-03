<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\driver;
use App\Models\travel_agent;
use App\Models\vehicle;
use App\Models\VehicleType;
use App\Models\User;
use App\Models\location;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role=='0')
        {
            return view('admin.index');
        }
        elseif(Auth::user()->role=='1')
        {
            $auth = Auth::user();
            $driver = driver::where('user_id',$auth->id)->first();
            return view('front.driver.driver-dashboard',compact('auth','driver'));
        }
        else
        {
            $auth = Auth::user();
            $agent = travel_agent::where('user_id',$auth->id)->first();
            return view('front.travelagent.travel-agency-dashboard',compact('auth','agent'));
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function myAccount()
    {
        if(Auth::user()->role=='0')
        {
            return view('admin.index');
        }
        elseif(Auth::user()->role=='1')
        {
            $auth = Auth::user();
            $driver = driver::where('user_id',$auth->id)->first();
            return view('front.driver.driver-dashboard',compact('auth','driver'));
        }
        else
        {
            $auth = Auth::user();
            $agent = travel_agent::where('user_id',$auth->id)->first();
            return view('front.travelagent.travel-agency-dashboard',compact('auth','agent'));
        }
    }

    /**
     * Auto Search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchCity(Request $request)
    {
        $startLocationId = location::where("location",$request->startLocationName)->pluck("id")->first();
        if (!empty($request->startLocationId)) {

            $res = location::select("location", "id")
                ->where('id', '!=', $startLocationId)
                ->where("location", "LIKE", "%{$request->term}%")
                ->get();
        } else {
            $res = location::select("location", "id")
                ->where("location", "LIKE", "%{$request->term}%")
                ->get();
        }

        return response()->json($res);
    }

    /**
     * verify driver and agency mobile number
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function verifyMobile(Request $request){

        $mobileNumber =User::where('mobile',$request->mobile_no)->get();
        foreach($mobileNumber as $mobile)
        {
            $mobile -> mobile_verify_status="1";
            $mobile->update();
        }
        return response()->json("success");
    }

}
