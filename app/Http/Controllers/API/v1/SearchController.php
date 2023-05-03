<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\SearchUser;
use App\Models\User;
use App\Models\Booking\BookingAvailabilty;
use App\Models\location;
use App\Models\booking_request;
use App\Models\driver;
use App\Models\vehicle;
use App\Models\VehicleType;
use App\Http\Controllers\API\v1\DistanceCalculation;
class SearchController extends Controller
{
 /**
    * @OA\Get(
    *      path="/api/v1/locations",
    *      summary="Location List",
    *      description="Returns list of Locations",
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      )
    *     )
    */
    public function locationSearch(){
    $location = location::all();
    return ["locations"=>$location];
    }
    // public function calculateDistanceByLocation($startLocationId,$endLocationId)
    // {
    //     $distance = DB::select("SELECT a.location AS from_city, b.location AS to_city, 111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.Latitude)) * COS(RADIANS(b.latitude)) * COS(RADIANS(a.longitude - b.longitude)) + SIN(RADIANS(a.latitude)) * SIN(RADIANS(b.latitude))))) AS distance_in_km FROM locations AS a JOIN locations AS b ON a.id <> b.id WHERE a.id = '$startLocationId' AND b.id = '$endLocationId'");       
    //     return $distance;
    // }
    public function calculateDistanceByLocation($pickuplatlng,$droplatlng)
    {
        $pickup = explode(",",$pickuplatlng);
        $drop = explode(",",$droplatlng);
        $distance = DB::select("SELECT  111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS($pickup[0])) * COS(RADIANS($drop[0]))* COS(RADIANS($pickup[1] - $drop[1])) + SIN(RADIANS($pickup[0])) * SIN(RADIANS($drop[0]))))) as distance_km")[0]->distance_km;
        return $distance;
    }
     /**
    * @OA\Post(
    *      path="/api/v1/customer/searchdriver",
    *      summary="Search Available Drivers",
        *       tags={"customer"},
    *      description="This will register driver",
    * @OA\Parameter(
    *          name="pickuplatlng",
    *          in="query",
    *          description="provide pickup latlng",
    *           required=true,
    *       ),
        * @OA\Parameter(
    *          name="droplatlng",
    *          in="query",
    *          description="provide drop latlng",
    *           required=true,
    *       ),
           * @OA\Parameter(
    *          name="pickup_location",
    *          in="query",
    *          description="Provide pickup location",
    *           required=true,
    *       ),
               * @OA\Parameter(
    *          name="drop_location",
    *          in="query",
    *          description="Provide drop location",
    *           required=true,
    *       ),
        * @OA\Parameter(
    *          name="phone",
    *          in="query",
    *          description="Provide Phone Number",
    *           required=true,
    *       ),
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      )
    *     )
    */
    function searchDriverAvailablity(Request $request)
    {
        try {
            $pickuplatlng = $request->pickuplatlng;
            $droplatlng = $request->droplatlng;
            $pickup_location = $request->pickup_location;
            $drop_location = $request->drop_location;
            $phone = $request->mobile;
            $pickup = explode(",",$pickuplatlng);
            $locationsData= DB::table('drivers')->select(DB::raw('id, SQRT(POW(69.1 * (currentlatitude - '.$pickup[0].'), 2) + POW(69.1 * ('.$pickup[1].'-currentlongitude) * COS(currentlatitude / 57.3), 2)) AS distance'))
                                 ->havingRaw('distance < 30')->OrderBy('distance')->pluck("id");
                      
            $arrLatLon=$locationsData->toArray();
           
          
            $bookingavailabilities = BookingAvailabilty::where('online_status', '1')->where('ride_status', '0')->whereIn('driver_id',$arrLatLon)->where('drop_location', $drop_location) ->get();
           $bookingavailabilities_id = BookingAvailabilty::select('id')->get();
       // print_r($bookingrequest );die();
            $i=0;
        //   if($bookingrequest == $bookingavailabilities_id ){}else{}
          foreach($bookingavailabilities as $bookings)
          {
                $driver_id = $bookings->driver_id;
                $vehicle_id = $bookings->vehicle_id;
                $driverdetails = driver::where('id','=',$driver_id)->first();
                $vehicledetails = vehicle::select('vehicles.*','vehicle_types.vehicle_name','vehicle_types.seat_capacity')
                    ->leftJoin('vehicle_types','vehicles.vehicle_type_id','=','vehicle_types.id')->where('vehicles.id','=',$vehicle_id)->first();
                $bookingavailabilities[$i]["driver_details"] = [$driverdetails];
                $bookingavailabilities[$i]["vehicle_details"] = [$vehicledetails];
                $i++;
              
          }
                return [
                 "code"=>201,
                "status" =>'success',
                "Details"=> $bookingavailabilities,
          ];
           die;
           $bookingavailabilities;
            $start_time = date('Y-m-d',strtotime($request->start_time));
            $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
            $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
            // $startLocationId = null;
            // $endLocationId = null;
            $phone = $request->input('phone');
             $user_exist = SearchUser::where('search_start_location',$request->start_location)
            ->where('search_end_location',$request->end_location)
            ->where('search_date',$start_time)
            ->where('search_user_phone',$phone)
            ->first();
            if(empty($user_exist) && !empty($phone)){
                $search_user = new SearchUser();
                $search_user->search_start_location = $request->start_location;
                $search_user->search_end_location = $request->end_location;
                $search_user->search_date = $start_time;
                $search_user->search_user_phone = $phone;
                $search_user->save();
            }
            $search = $startLocationId;
            $search2 = $endLocationId;
            $start_time = $start_time;
            $startLocationName = $request->start_location;
            $endLocationName =$request->end_location;
            $capacity = $request->input('capacity');
              $booking = BookingAvailabilty::leftJoin('users', function ($join) {
                $join->on('booking_availabilties.user_id', '=', 'users.id');
            })->Join('locations as two', function ($join) {
                $join->on('booking_availabilties.end_location_id', '=', 'two.id');
            })->Join('locations as one', function ($join) {
                $join->on('booking_availabilties.start_location_id', '=', 'one.id');
            })->Join('vehicles as five', function ($join) {
                $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
            })->leftJoin('booking_requests', function ($join) {
                $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
            })->Join('drivers', function ($join) {
                $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
            })
                ->select([
                    'booking_availabilties.*',
                    'five.vehicle_registration_number as vehicleNumber',
                    'five.vehicle_type_id as vehicleTypeId',
                    'five.capacity as capacity',
                    'five.rate_per_km as rate_per_km',
                    'one.location as startLocation',
                    'two.location as endLocation',
                    'five.capacity as capacity',
                    'booking_requests.id as bookingRequestId',
                    'booking_requests.status as bookingRequestStatus',
                    'drivers.travel_agent_id as travelAgentId',
                    'drivers.name as driverName',
                    'drivers.license_number as driverLicenceNumber',
                    'drivers.age as driverAge',
                    'users.mobile as driverMobile',
                ])->where('booking_availabilties.booking_confirm_status',"=","0")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"));
                if($capacity==5 || $capacity==6 || $capacity==7 )
                {
                    $capacity="6+1";
                }
               
                if($capacity=="6+1" )
                {
                    $booking =$booking->where('booking_availabilties.start_location_id', '=', "{$search}")
                    ->where('booking_availabilties.end_location_id', '=', "{$search2}")
                    ->where('five.capacity', '=', "6+1")
                    ->get();
                }
                else
                {
                    $booking =$booking->where('booking_availabilties.start_location_id', '=', "{$search}")
                    ->where('booking_availabilties.end_location_id', '=', "{$search2}")
                    ->get();
                }

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
                        $startTime = date('Y-m-d', strtotime($book->start_time));
                        $endTime = date('Y-m-d', strtotime($book->end_time));
                        $currentTime = date('Y-m-d', strtotime($request->start_time));

                        if (($currentTime >= $startTime) && ($currentTime <= $endTime))
                        {
                            array_push($book_search, $book);
                        }
                        $vehicle_ids[] = $book->vehicleTypeId;
                        $booking_ids[] = $book->id;
                        $ids = implode(', ',$booking_ids);

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

            $distanceKm = 0;
            $booking_cab_15_percent = 0;
            $booking_cab_total = 0;
            $booking_cab_25_percent = 0;
            $booking_large_cab_total = 0;
            $price = 0;

            if(count($booking) == 0){
                $calculateDistance =   $this->calculateDistanceByLocation($startLocationId,$endLocationId);
                $distance = new DistanceCalculation();
                $calculateDistance = $distance->calculateDistanceByLocation($startLocationId,$endLocationId);
                $distanceKm = $calculateDistance['0']->distance_in_km;
                $booking->distance = round($distanceKm);
                $price = round($distanceKm) * 12 ;
                $priceCommission = $price * 70/100;
                $finalPrice = $price + round($priceCommission);
                $booking_cab_15_percent = $finalPrice;
                $booking_cab_total = 2*$finalPrice;

                $priceCommission = $price * 99/100;
                $finalPrice = $price + round($priceCommission);
                $booking_cab_25_percent = $finalPrice;
                $booking_large_cab_total = 2*$finalPrice;
            }

         $start_timeNew =date('d-m-Y',strtotime($request->start_time));
         return ['vehicleType' => $vehicleType, 'booking' => $book_search, 'strtLocId' => $search, 'endLocId' => $search2, 'start_time' => $start_timeNew,'capacity' => $capacity,'startLocationName' => $startLocationName,'endLocationName' => $endLocationName,'starttime'=> $request->start_time,'minPrice'=>$minPrice,'maxPrice'=>$maxPrice,'times'=>$times ,'booking_cab_15_percent' => $booking_cab_15_percent,'booking_cab_total'=>$booking_cab_total,'booking_cab_25_percent' => $booking_cab_25_percent,'booking_large_cab_total' => $booking_large_cab_total,'distanceKm' => $distanceKm];
         } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    
    
    function updatelatlong(Request $request)
    {

        $mobile = $request->driver_mobile;
        $destinationname = $request->destinationname;
        $lat1 = $request->currentlatitude;
        $lon1=  $request->currentlongitude;
        $lat2 = $request->destinationlatitude;
        $lon2 = $request->destinationlongitude;

        $userid = User::where('mobile','=',$mobile)->first()->id;
        if($userid){
            
            if(($lat1 == $lat2) && ($lon1 == $lon2)) {
                echo 0;
            }else{
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                //$unit = strtoupper($unit);
                $distance= round($miles * 1.609344);
            }
        
            $driverdetail = driver::where('user_id', $userid)->update([
                'currentlatitude' => $request->currentlatitude,
                'currentlongitude'=>$request->currentlongitude,
                'destinationlatitude'=>$request->destinationlatitude,
                'destinationlongitude'=>$request->destinationlongitude,
                'destinationname'=> $destinationname,
                'distance' => $distance
            ]);
            
            return[
                "code" =>201,
                "status"=>'success',
            ];
            
        }else{
          return[
                "code" =>202,
                "status"=>'faileds',
            ]; 
        }
    }
    
    
    
    
    function driversearch(Request $request)
    {
        $mobile = $request->mobile;
        $destinationname = $request->destinationname;
        $lat1 = $request->currentlatitude;
        $lon1= $request->currentlongitude;
        $lat2 = $request->destinationlatitude;
        $lon2 = $request->destinationlongitude;
        $userid = User::where('mobile',$mobile)->first()->id;
        
        
        if(($lat1 == $lat2) && ($lon1 == $lon2)) {
            echo 0;
        }else{
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            //$unit = strtoupper($unit);
            $distance= round($miles * 1.609344);
        }
        if($userid){
          $driverdetail =  driver::where('destinationname', $destinationname )->where('online_status','=',1)->where('distance','<',30)->get();
        }
     
        return[
                "code" =>201,
                "details"=>$driverdetail,
                "cust_id" =>$userid
            ];
    }
    
    function custbookings(Request $request){
      die('dd');  
    }
    
}
