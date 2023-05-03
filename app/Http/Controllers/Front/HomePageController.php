<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\BookingAvailabilty;
use DB;
use Auth;
use App\Models\location;
use App\Models\VehicleType;
use App\Models\booking_request;
use App\Models\User;
use App\Models\driver;
use App\Models\travel_agent;
use App\Models\cms_pages;
class HomePageController extends Controller
{
    public function adminlogin()
    {
    
        if(Auth::user() == null){
            return view('auth.login');
        }
        else if(Auth::user()->role == 1 || Auth::user()->role == 2 )
        {
            return redirect()->back();
        }

    }

    /**
     * Show index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking = BookingAvailabilty::leftJoin('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->Join('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->Join('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->Join('vehicles as five', function ($join) {
            $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
        })->Join('drivers', function ($join) {
            $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
        })->leftJoin('booking_requests', function ($join) {
            $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
        })
        ->select([
            'booking_availabilties.*',
            'five.vehicle_registration_number as vehicleNumber',
            'five.id as vehicle_type_id',
            'five.capacity as capacity',
            'five.rate_per_km as rate_per_km',
            'one.location as startLocation',
            'two.location as endLocation',
            'drivers.name as driverName',
            'drivers.license_number as driverLicenceNumber',
            'drivers.age as driverAge',
            'drivers.travel_agent_id as travelAgentId',
            'booking_requests.id as bookingRequestId',
            'booking_requests.status as bookingRequestStatus',
            'booking_requests.paytm_payment_status as payment_status',
            'users.mobile as driverMobile'
        ])->where('booking_availabilties.booking_confirm_status',"=","0")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))->orderby('booking_requests.id','desc')->take(5)->get();
        $about=cms_pages::where('page_slug','home')->first();

        return view('front.index', compact('booking','about'));
    }

    /**
     * userLogin function use for check user is admin or not .
     *
     * @return \Illuminate\Http\Response
     */
    public function userlogin()
    {
        if (!empty(Auth::user())) {
            return redirect('my-account');
        } else {
            return view('front.user_login');
        }
    }

     /**
     * Auto Search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchLocationIndex(Request $request)
    {
        $res = location::select("location", "id")
            ->where("location", "LIKE", "%{$request->term}%")
            ->get();

        return response()->json($res);
    }

     /**
     * View All Available List of Book-Availability.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function availableLift(){
        $booking = BookingAvailabilty::leftJoin('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->Join('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->Join('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->Join('vehicles as five', function ($join) {
            $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
        })->Join('drivers', function ($join) {
            $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
        })->leftJoin('booking_requests', function ($join) {
            $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
        })
        ->select([
            'booking_availabilties.*',
            'five.vehicle_registration_number as vehicleNumber',
            'five.id as vehicle_type_id',
            'five.vehicle_type_id as vehicleTypeId',
            'five.capacity as capacity',
            'five.rate_per_km as rate_per_km',
            'one.location as startLocation',
            'two.location as endLocation',
            'drivers.travel_agent_id as travelAgentId',
            'booking_requests.id as bookingRequestId',
            'booking_requests.status as bookingRequestStatus',
            'drivers.name as driverName',
            'drivers.license_number as driverLicenceNumber',
            'drivers.age as driverAge',
            'users.mobile as driverMobile',
            'booking_requests.paytm_payment_status as payment_status',
            'booking_requests.paytm_payment_status as payment_status',
        ])->where('booking_availabilties.booking_confirm_status',"=","0")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))->orderBy('booking_availabilties.id','DESC')->paginate(12);
        $book_search=[];
        $vehicle_ids =[];
        $booking_ids =[];
        $ids = null;
        $maxPrice = 0;
        $minPrice = 0;
        $times = 0;
        if(count($booking) >0)
        {
            foreach($booking as $book)
            {
               
                
                $vehicle_ids[] = $book->vehicleTypeId;
                $booking_ids[] = $book->id;
                $ids = implode(', ', $booking_ids);
            }
        }
        $vehicleType = VehicleType::whereIn('id',$vehicle_ids)->orderBy('vehicle_name','ASC')->get();
        if(isset($ids) && !empty($ids)){
            $priceMaxMin = BookingAvailabilty::select(array('booking_availabilties.*', DB::raw("(SELECT MIN(distance_price) from booking_availabilties where id IN(".$ids.")) minPrice"), DB::raw("(SELECT MAx(distance_price) from booking_availabilties where id IN(".$ids.")) maxPrice")))->whereIn('id',$booking_ids)->first();
            
           
            if(isset($priceMaxMin->minPrice) &&  isset($priceMaxMin->maxPrice)){
                if($priceMaxMin->minPrice >=1000){
                    $minPrice = floor($priceMaxMin->minPrice / 1000) * 1000;
                    $times = 1000;
                } else {
                    $minlength = strlen(floor($priceMaxMin->minPrice));
                    $times = str_pad('1', $minlength, "0");
                    $minPrice =  floor($priceMaxMin->minPrice / $times) * $times;
                }
                if($priceMaxMin->maxPrice >=1000){
                    $times = 1000;
                    $maxPrice = floor($priceMaxMin->maxPrice / 1000) * 1000;
                } else {
                    $maxlength = strlen(floor($priceMaxMin->maxPrice));
                    $times = str_pad('1', $minlength, "0");
    
                    $maxPrice =  floor($priceMaxMin->maxPrice / $times) * $times;
                }
            
            }
        }
       
        $capacity ="";
        $requestStartTime= "";
        $requestEndTime = "";
        $vehicleName = "";
        $start_location = "";
        $end_location = "";
        return view('front.view-more-lifts', compact('booking','vehicleType','capacity','requestStartTime','requestEndTime','vehicleName','start_location','end_location','minPrice','maxPrice','times'));
    }
    public function getViewMoreLeftSearch(Request $request)
    {
        try {

            $vehicleId = explode(',', $request->carTypes);
            $priceRanges = explode(',', $request->priceRanges);
            $minRange = explode(',', $request->minRange);
            $maxRange = explode(',', $request->maxRange);
            $booking = BookingAvailabilty::leftJoin('users', function ($join) {
                $join->on('booking_availabilties.user_id', '=', 'users.id');
            })
            ->Join('locations as two', function ($join) {
                $join->on('booking_availabilties.end_location_id', '=', 'two.id');
            })
            ->Join('locations as one', function ($join) {
                $join->on('booking_availabilties.start_location_id', '=', 'one.id');
            })
            ->Join('vehicles as five', function ($join) {
                $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
            })
            ->Join('drivers', function ($join) {
                $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
            })
            ->Join('vehicle_types as vehicle_name', function ($join) {
                $join->on('vehicle_name.id', '=', 'five.vehicle_type_id');
            })
            ->leftJoin('booking_requests', function ($join) {
                $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
            })
            ->select([
                'booking_availabilties.*',
                'five.vehicle_registration_number as vehicleNumber',
                'five.id as vehicle_type_id',
                'five.capacity as capacity',
                'one.location as startLocation',
                'two.location as endLocation',
                'drivers.travel_agent_id as travelAgentId',
                'vehicle_name.vehicle_name as vehicleName',
                'vehicle_name.id as vehicleId',
                'booking_requests.id as bookingRequestId',
                'booking_requests.status as bookingRequestStatus',
            ])->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))
            ->where('booking_availabilties.booking_confirm_status',"=","0")->orderBy('booking_availabilties.id','DESC');

            if (is_null($request->carTypes) == false) {
                $booking->whereIn('vehicle_name.id',$vehicleId);
            }
            if (is_null($request->priceRanges) == false) {
                $booking->where(function($query) use ($minRange) {
                    foreach ($minRange as $key => $min) {
                        if ($key === 0) {
                            $query->where('booking_availabilties.distance_price', '>=', $min);
                            continue;
                        }
                        $query->orWhere('booking_availabilties.distance_price', '>=', $min);
                    }

                });
                
            }
            if (is_null($request->priceRanges) == false) {
                $booking->where(function($query) use ($maxRange) {
                    foreach ($maxRange as $key => $max) {
                        if ($key === 0) {
                            $query->where('booking_availabilties.distance_price', '<=', $max);
                            continue;
                        }
                        $query->orWhere('booking_availabilties.distance_price', '<=', $max);
                    }
                    
                });
                
            }
            
            $booking = $booking->paginate(12);
            return view('front.search_list', [ 'booking' => $booking]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function searchAvailableLift(Request $request){
        try{
            $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
            $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
            $requestStartTime =$request->start_time;
            $requestEndTime =$request->end_time;
            $start_time= date('Y-m-d H:i',strtotime($request->start_time));
            $end_time = date('Y-m-d H:i',strtotime($request->end_time));
            $vehicleName = $request->vehicleName;
            $capacity = $request->capacity;
            $start_location = $request->start_location;
            $end_location = $request->end_location;

            $booking = BookingAvailabilty::leftJoin('users', function ($join) {
                $join->on('booking_availabilties.user_id', '=', 'users.id');
            })->Join('locations as two', function ($join) {
                $join->on('booking_availabilties.end_location_id', '=', 'two.id');
            })->Join('locations as one', function ($join) {
                $join->on('booking_availabilties.start_location_id', '=', 'one.id');
            })->Join('vehicles as five', function ($join) {
                $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
            })->Join('drivers', function ($join) {
                $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
            })->Join('vehicle_types as vehicle_name', function ($join) {
                $join->on('vehicle_name.id', '=', 'five.vehicle_type_id');
            })->leftJoin('booking_requests', function ($join) {
                $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
            })
            ->select([
                'booking_availabilties.*',
                'five.vehicle_registration_number as vehicleNumber',
                'five.id as vehicle_type_id',
                'five.capacity as capacity',
                'five.rate_per_km as rate_per_km',
                'one.location as startLocation',
                'two.location as endLocation',
                'drivers.travel_agent_id as travelAgentId',
                'vehicle_name.*',
                'booking_requests.id as bookingRequestId',
                'booking_requests.status as bookingRequestStatus',
                'drivers.name as driverName',
                'drivers.license_number as driverLicenceNumber',
                'drivers.age as driverAge',
                'users.mobile as driverMobile',
                'booking_requests.paytm_payment_status as payment_status',
            ])->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))
            ->where('booking_availabilties.booking_confirm_status',"=","0")->orderBy('booking_availabilties.id','DESC');
            if(!empty($capacity)){
                $booking= $booking ->where('vehicle_name.seat_capacity',$request->capacity);
            }

            if(!empty($requestStartTime)){
                $booking= $booking->where('booking_availabilties.start_time','>=',date('Y-m-d H:i',strtotime($request->start_time)));
            }

            if(!empty($requestEndTime)){
                $booking= $booking->where('booking_availabilties.end_time','<=',date('Y-m-d H:i',strtotime($request->end_time)));
            }

            if(!empty($startLocationId)){
                $booking= $booking
                ->where('one.id',$startLocationId);
            }

            if(!empty($endLocationId)){
                $booking= $booking->where('two.id',$endLocationId);
            }
            
            if(!empty($vehicleName)){
                $booking= $booking->where('vehicle_name.id',$request->vehicleName);
            }
            $booking = $booking->paginate(12);
            $vehicleType = VehicleType::orderBy('vehicle_name','ASC')->get();
            return view('front.view-more-lifts', compact('booking','vehicleType','capacity','requestStartTime','requestEndTime','vehicleName','start_location','end_location'));
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    
    public function fetchLocation(Request $request)
    {
       $location = location::where('location',$request->value)->first();
       if(!empty($location))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * Cancel Booking Request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function cancelBooking(Request $request){
        
        $orignalBookingIdModal = new booking_request;
        $bookingId = $orignalBookingIdModal->FetchOrignalDigitNo($request->bookingId);

        $booking = booking_request::leftJoin('booking_availabilties', function ($join) {
            $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id');
        })->select([
            'booking_availabilties.end_time as end_time',
            'booking_requests.*',
        ])->where('booking_requests.id',$bookingId)->first();

        if($booking !="")
        {
            $bookingAvailability = BookingAvailabilty::Join('locations as two', function ($join) {
                $join->on('booking_availabilties.end_location_id', '=', 'two.id');
            })->Join('locations as one', function ($join) {
                $join->on('booking_availabilties.start_location_id', '=', 'one.id');
            })->join('vehicles as four', function ($join) {
                $join->on('booking_availabilties.vehicle_id', '=', 'four.id');
            })->join('vehicle_types as v_type', function ($join) {
                $join->on('v_type.id', '=', 'four.vehicle_type_id');
            })->select([
                    'booking_availabilties.*',
                    'one.location as startLocation',
                    'two.location as endLocation',
                    'v_type.vehicle_name as vehicleName',
                ])->where('booking_availabilties.id',$booking->booking_availability_id)->first();
            $driverInfo = driver::where('id',$bookingAvailability->driver_id)->first();
            $driverMobile = User::where('id',$driverInfo->user_id)->first();
            if($booking->status == "2" || $booking->status == "3")
            {
                Session()->flash('cancel', 'Your Booking is Already Cancelled');
                return redirect()->back();
            }
            elseif($bookingAvailability->end_time < date("Y-m-d H:i"))
            {
                Session()->flash('cancel', 'You can’t cancel booking now, please contact support for any help');
                return redirect()->back();
            }
            else
            {
                $bookingAvailability->booking_confirm_status ="0";
                $booking->status="3";
                $date= Date("Y-m-d H:i:s");
                $booking->cancel_time=$date;
                $bookingAvailability->update();
                $booking->update();
                  
                // click sms api start
                $username = config('app.clicksend_username');
                $key = config('app.clicksend_key');
                $sender_id = config('app.clicksend_sender_id');
                // click sms api to send customer to driver Details Start
                        
                $to = "+91".$booking->customer_mobile_number;

                $message ="Dear $booking->customer_name, Your BookingId: $request->bookingId is Cancelled. Thanks LiftDedoo Team";
                // click sms api to send customer to driver Details End
                $url = "https://api-mapper.clicksend.com/http/v2/send.php?method=https&username=".$username."&key=".$key."&to=".$to."&message=".$message."&senderid=".$sender_id."";
                
                $data = file_get_contents($url);
                $parsed_xml = simplexml_load_string($data);

                // click sms api to send driver to customer Details start
                $toDriver = "+91".$driverMobile->mobile;
                $customerMessage ="Dear $driverInfo->name, Your Booking Is Cancelled. Thanks LiftDedoo Team.";

                $url2 = "https://api-mapper.clicksend.com/http/v2/send.php?method=https&username=".$username."&key=".$key."&to=".$toDriver."&message=".$customerMessage."&senderid=".$sender_id."";
                $data2 = file_get_contents($url2);
                $parsed_xml2 = simplexml_load_string($data2);
                // click sms api to send driver to customer Details End
                
                if($driverInfo->travel_agent_id !="")
                {
                    $driverTravel= travel_agent::where('id',$driverInfo->travel_agent_id)->first();
                    $travelMobile = User::where('id',$driverTravel->user_id)->first();
                    // click sms api to send travel-agency driver to customer Details start
                    $toDriver = "+91".$travelMobile->mobile;
                     $customerTravelMessage ="Dear $driverTravel->agency_name, Customer cancelled last booking.Please contact customer. Customer Mobile: $booking->customer_mobile_number.";
                    $url3 = "https://api-mapper.clicksend.com/http/v2/send.php?method=https&username=".$username."&key=".$key."&to=".$toDriver."&message=".$customerTravelMessage."&senderid=".$sender_id."";
                    $data3 = file_get_contents($url3);
                    $parsed_xml2 = simplexml_load_string($data3);
                    // click sms api to send travel-agency to customer Details End
                } 
               
                if(!empty($parsed_xml)){
                    $smsStatusCode = $parsed_xml->messages->message->result;
                    $smsStatus = $parsed_xml->messages->message->errortext;
                    if($smsStatusCode == 0000 && $smsStatus == "Success"){
                        Session()->flash('status', 'Booking Cancel Successfully ');                
                    }elseif($smsStatusCode == 2022 && $smsStatus == "Invalid Credentials"){
                        Session()->flash('status', 'Booking is Canceled but Something Went Wrong from sms side ');
                    }else{
                        Session()->flash('status', 'Booking is Canceled but Something Went Wrong from sms side');
                    }
                }
                Session()->flash('success', '“Your booking '.$request->bookingId.'  is cancelled,please contact support for any help');
                return redirect()->back();
            }
        }
        else
        {
            Session()->flash('cancel', 'Sorry no booking ID found, Please try again');
            return redirect()->back();
        }
    }

    public function MobileNoValidate(Request $request)
    {

        $this->validate($request, [
            'mobile_no'    => 'required'
        ]);

        $userrole = User::where('mobile',$request->mobile_no)->first();
        if($userrole){
        
            return response()->json(['status' => 'success' , 'user_exist'=>"1"]);
        }
        else{
            return response()->json(['status' => 'failure' , 'user_exist'=>"0"]);

        }

    }

    public function Mobilelogin(Request $request)
    {

        $this->validate($request, [
            'mobile_no'    => 'required'
        ]);

        $userrole = User::where('mobile',$request->mobile_no)->first();
        if($userrole){
        
            $identity = $request->input("mobile_no");

            if(Auth::loginUsingId($userrole->id)){

            }
            return response()->json(['status' => 'success' , 'user_exist'=>"1"]);
        }
        else{
            return response()->json(['login-random'=>"Mobile Number and Password doesn't Match ."]);

        }

    }
}
