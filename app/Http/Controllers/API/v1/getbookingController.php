<?php

namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\booking_request;
use App\Models\User;
use App\Models\driver;
use App\Models\vehicle;
use App\Models\Booking\BookingAvailabilty;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class getbookingController extends Controller
{
  
        public function index(Request $request) {
          
       $data = BookingAvailabilty::where('driver_id', $request->driver_id)->first();
       //echo($data);die;
        if( $data  ){
           
            $driverBookings = booking_request::where('booking_availability_id', $data->id )
            ->get();
            //print_r($driverBookings);die;
             //$list1 = array( "price"=>$data->distance_price, "user_id"=>$driverBookings->user_id);
             return ["message"=>"success","response"=>$driverBookings ];
        }else{
               return ["message"=>"not found"];
        }
        }
}