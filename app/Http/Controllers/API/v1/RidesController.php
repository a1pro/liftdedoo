<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\User;
use App\Models\vehicle;
use App\Models\VehicleType;
use App\Models\booking_request;
use App\Models\Booking\BookingAvailabilty;

use Illuminate\Support\Facades\Hash;

class RidesController extends Controller
{
        /**
    
    * @OA\Post(
    *      path="/api/v1/customer/myrides",
    * tags={"customer"},
    *      summary="List of Available Drivers",
    *      description="Returns list of available driver near 30km",

      * @OA\Parameter(
    *          name="customer_mobile_number",
    *          in="query",
    *          description="Provide Customer Mobile Number",
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
    function customerRides(Request $request)
    {
        // die('nhgfh');
       $bearertoken = $request->bearerToken();
       $mobilenumber =$request->customer_mobile_number;
    // $userid = User::where('mobile','=',$mobilenumber)->first()->id;
    //   if($userid){
    //       $bookings =BookingAvailabilty::where('user_id','=',$userid)->first();
    //      }
     
       try {
        $booking = booking_request::Join('locations as two', function ($join) {
            $join->on('booking_requests.booking_start_location_id', '=', 'two.id');
        })->Join('locations as one', function ($join) {
            $join->on('booking_requests.booking_end_location_id', '=', 'one.id');
        })->Join('booking_availabilties', function ($join) {
            $join->on('booking_requests.booking_availability_id', '=', 'booking_availabilties.id');
        })->select([
            'booking_requests.*',
            'two.location as start_location',
            'one.location as end_location',
            'booking_availabilties.driver_id as driverId',
            'booking_availabilties.vehicle_id as vehicleId'
        ])->where('booking_requests.customer_mobile_number','=', $request->customer_mobile_number)->orderBy('booking_requests.id', 'DESC')->get();
     print_r($booking);die();
        // $bookingInfo = [];
        // foreach ($booking as $bookingRequest) {
        //     $vehicle = vehicle::where('id', $bookingRequest->vehicleId)->first();
        //     $user = User::where('id', $bookingRequest->driverId)
        //         ->where('user_id', Auth::user()->id)
        //         ->first();

        //     if ($user != "") {
        //         $bookingData['id'] = $bookingRequest->id;
        //         $bookingData['customer_name'] = $bookingRequest->customer_name;
        //         $bookingData['customer_mobile_number'] = $bookingRequest->customer_mobile_number;
        //         $bookingData['endLocation'] = $bookingRequest->endLocation;
        //         $bookingData['startLocation'] = $bookingRequest->startLocation;
        //         $bookingData['price'] = $bookingRequest->price;
        //         $bookingData['payment_option'] = $bookingRequest->payment_option;
        //         $bookingData['status'] = $bookingRequest->status;
        //         $bookingData['vehicle_number'] = $vehicle->vehicle_registration_number;
        //         $bookingData['vehicle_type_id'] = $vehicle->vehicle_type_id;

        //         array_push($bookingInfo, $bookingData);
        //     }
        //  }
        
        return ["bookinghistory"=>$booking];
       
    } 
    catch (\Exception $e) {
        return ["bookinghistory"=>$booking,  $e->getMessage()];
        }
       if(User::where("mobile",'=',$mobilenumber)->exists())
       {
           $token = User::where("mobile",'=',$mobilenumber)->first()->remember_token;
            
           if(Hash::check($bearertoken,$token))
           {
            
           }else
           {
               return ["unauthorized", "details" =>$token];
           }
           }else
           {
               return ["message"=>"user not registered"];
           }
           
        }

           /**
    
    * @OA\Post(
    *      path="/api/v1/driver/myrides",
    * tags={"driver"},
    *      summary="List of Available Drivers",
    *      description="Returns list of available driver near 30km",

      * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="Provide Driver Mobile Number",
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

        function driverRideHistory(Request $request)
        {
           $drivernumber= $request->driver_mobile_number;
            try {
                $uid = User::where('mobile','=',$drivernumber)->first()->id;
                $bookingavailablityid = BookingAvailabilty::where('user_id','=',$uid)->get();
                $booking = booking_request::Join('locations as two', function ($join) {
                    $join->on('booking_requests.booking_start_location_id', '=', 'two.id');
                })->Join('locations as one', function ($join) {
                    $join->on('booking_requests.booking_end_location_id', '=', 'one.id');
                })->Join('booking_availabilties', function ($join) {
                    $join->on('booking_requests.booking_availability_id', '=', 'booking_availabilties.id');
                })->select([
                    'booking_requests.*',
                    'two.location as startLocation',
                    'one.location as endLocation',
                    'booking_availabilties.driver_id as driverId',
                    'booking_availabilties.vehicle_id as vehicleId'
                ])->where('booking_availabilties.user_id','=', $uid)->orderBy('booking_requests.id', 'DESC')->get();
           
                return ["ridinghistory"=>$booking];
            } catch (\Exception $e) {
                return ["message"=>print_r($e)];
            }
              
        }



}
