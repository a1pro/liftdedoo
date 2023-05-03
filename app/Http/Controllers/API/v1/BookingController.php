<?php
namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\booking_request;
use App\Models\future_booking;
use App\Models\future_request;
use App\Models\User;
use App\Models\driver;
use App\Models\vehicle;
use App\Models\Booking\BookingAvailabilty;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use ClickSend;
class BookingController extends Controller
{

    public function calculateDistanceByLocation($pickuplatlng,$droplatlng)
    {
        $pickup = explode(",",$pickuplatlng);
        $drop = explode(",",$droplatlng);
       //$drop =$droplatlng
        $distance = DB::select("SELECT  111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS($pickup[0])) * COS(RADIANS($drop[0]))* COS(RADIANS($pickup[1] - $drop[1])) + SIN(RADIANS($pickup[0])) * SIN(RADIANS($drop[0]))))) as distance_km")[0]->distance_km;
        return $distance;
    }
         /**
    * @OA\Post(
    *      path="/api/v1/customer/bookdriver",
    * tags={"customer"},
    *      summary="List of Available Drivers",
    *      description="Returns list of available driver near 30km",
     * @OA\Parameter(
    *          name="booking_availability_id",
    *          in="query",
    *          description="Provide booking availability id",
    *           required=true,
    *       ), * @OA\Parameter(
    *          name="customer_mobile_number",
    *          in="query",
    *          description="Provide Customer Mobile Number",
    *           required=true,
    *       ), * @OA\Parameter(
    *          name="start_location_latlng",
    *          in="query",
    *          description="Provide Start Location latlng",
    *           required=true,
    *       ), * @OA\Parameter(
    *          name="end_location_latlng",
    *          in="query",
    *          description="Provide End location",
    *           required=true,
    *       ), * @OA\Parameter(
    *          name="payment_option",
    *          in="query",
    *          description="Provide Payment Option",
    *           required=false,
    *       ), * @OA\Parameter(
    *          name="payment_amount",
    *          in="query",
    *          description="Provide Payment Amount",
    *           required=false,
    *       ),
    * @OA\Parameter(
    *          name="price",
    *          in="query",
    *          description="Provide Price",
    *           required=false,
    *       ),
        * @OA\Parameter(
    *          name="distance_in_km",
    *          in="query",
    *          description="Provide Distance in km",
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
    function BookDriver(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
         'booking_availability_id' => 'required',
         'customer_mobile_number' => 'required',
         'distance_in_km' => 'required',
         'start_location' => 'required',
         'end_location' => 'required',
         'payment_status'=> 'required',
         'remey_payment'=>'required',
         'pickup_lat'=> 'required',
         'pickup_long'=>'required',
         'destinationLat'=> 'required',
         'destinationLog'=>'required',
         'payment_type'=>'required',
         'wallet_balance'=>'required',
         'paytm_money' => 'required',
             
            
       ]);
       
       
        if ($validator->fails()) {          
        return response()->json(['error'=>$validator->errors()], 401);                        
        }
        $payment_type=$request->payment_type;
       
        $payment_types = 'paytm' ;
     
        
        if($payment_type === $payment_types){
        $userdata = User::where('mobile','=',$request->customer_mobile_number)->select ('*')->first();
     
        $pricedata=BookingAvailabilty::where('id', $request->booking_availability_id)->select ('*')->first();
        
        $driver_id=$pricedata->driver_id;
        
        $inserDrivernumber = driver::where('id','=',$driver_id)->select ('*')->first();
        
        $user_number= $inserDrivernumber->user_id;
     
        $usernum = User::where('id',$user_number)->select ('*')->first();
      
        $booking_availability_id = $request->booking_availability_id;
        
        $customer_name = $request->customer_name;
     
        $customer_email = $userdata->email;
       
        $customer_mobile_number = $request->customer_mobile_number;
        $start_location_id = $request->start_location_id;
        $end_location_id = $request->end_location_id;
        $start_location = $request->start_location;
        $end_location = $request->end_location;
        $payment_option = $request->payment_option;
        $payment_amount = $request->payment_amount;
        $price =$pricedata->distance_price;
        $payment_status =$request->payment_status;
        $remey_payment =$request->remey_payment;
        $pickup_lat =$request->pickup_lat;
        $pickup_long =$request->pickup_long;
        
        $destinationLat =$request->destinationLat;
        $destinationLog =$request->destinationLog;
        $paytm_money =$request->paytm_money;
        $wallet_balance =$request->wallet_balance;
        
        //print_r($destinationLat);die;
        $token =$request->token;
        //print_r($token);
        $distance_in_km = $request->distance_in_km;
        $randomNumber = random_int(1000, 9999);
          
           User::where('mobile','=',$request->customer_mobile_number)->update(['paytm_money'=>$paytm_money ,'wallet_balance' =>$wallet_balance]); 
        
        
        
        $uid = BookingAvailabilty::where('id','=',$booking_availability_id)->first()->user_id;
        if($uid)
        {
          $ride=BookingAvailabilty::where ('id',$booking_availability_id)->update(['ride_status'=>'1']);
        }
        $bookings = new booking_request();
        $bookings->journey_otp =  $randomNumber;// $otp;
        $bookings->booking_availability_id = $booking_availability_id;
        $bookings->customer_mobile_number = $customer_mobile_number;
        $bookings->customer_email=$customer_email;
        $bookings->booking_start_location_id = $start_location_id;
        $bookings->booking_end_location_id = $end_location_id;
        $bookings->start_location = $start_location;
        $bookings->end_location = $end_location;
        $bookings->payment_option = $payment_option;
        $bookings->payment_amount = $payment_amount;
        $bookings->price =$price ;
        $bookings->payment_status =$payment_status ;
        $bookings->remey_payment =$remey_payment;
        $bookings->driver_number =$usernum->mobile;
        $bookings->distance_in_km = $distance_in_km;
        $bookings->pickup_lat =$pickup_lat;
        $bookings->pickup_long = $pickup_long;
        
        $bookings->destinationLat =$destinationLat;
        $bookings->destinationLog = $destinationLog;
        if($bookings->save())
        {
      
                $driverData=driver::where('user_id', $uid)->first();
                $result_otp =   $this->sendOtp($customer_mobile_number,$randomNumber);
                $bookings=["booking"=>[$bookings->toArray()],"driver"=>[$driverData]];
                $token=$driverData->token;
                   
                 $notification_title = "Booking Request";
                 $notification_body = "You have Booking Request From ".$customer_mobile_number;
                /* $descriptiondetail = ["notification_type"=>"bookingrequest","customer_mobile_number"=>$customer_mobile_number,
                 "distance"=>$distance_in_km,"price"=>$price,"booking_availability_id"=>$booking_availability_id,"booking_request_id"=>$bookingrequestid];*/
                 $fcmresponse = $this->sendDriverBookingNotification($token, array(
                "title" => $notification_title, 
                "body" => $notification_body,
                 'description'=>"New booking request",
                ));
       
                return ["message"=>"success","response"=>[$bookings]];
                $result_DriverBookingNotification=$this->sendDriverBookingNotification($token=$driverData->token);
                 return ["message"=>"success","response"=>$fcmresponse];
                }else{
                    return ["message"=>"something went wrong"];
        }
        }else{
//==================================            
        $userdata = User::where('mobile','=',$request->customer_mobile_number)->select ('*')->first();
        $rpayment = $userdata -> advance_pay;
        $advpayment = $request -> wallet_balance;
        $adpay = $rpayment - $advpayment;
        //print_r($adpay);die;
        $pricedata=BookingAvailabilty::where('id', $request->booking_availability_id)->select ('*')->first();
        
        $driver_id=$pricedata->driver_id;
        
        $inserDrivernumber = driver::where('id','=',$driver_id)->select ('*')->first();
        
        $user_number= $inserDrivernumber->user_id;
     
        $usernum = User::where('id',$user_number)->select ('*')->first();
      
        $booking_availability_id = $request->booking_availability_id;
        
        $customer_name = $request->customer_name;
     
        $customer_email = $userdata->email;
       
        $customer_mobile_number = $request->customer_mobile_number;
        $start_location_id = $request->start_location_id;
        $end_location_id = $request->end_location_id;
        $start_location = $request->start_location;
        $end_location = $request->end_location;
        $payment_option = $request->payment_option;
        $payment_amount = $request->payment_amount;
        $price =$pricedata->distance_price;
        $payment_status =$request->payment_status;
        $remey_payment = $request->remey_payment;
        
        //$remey_payment =  $adpay - $rmpayment;
        //print_r($remey_payment);die;
        $pickup_lat =$request->pickup_lat;
        $pickup_long =$request->pickup_long;
        
        $destinationLat =$request->destinationLat;
        $destinationLog =$request->destinationLog;
        $paytm_money =$request->paytm_money;
        $wallet_balance =$request->wallet_balance;
        //print_r($destinationLat);die;
        $token =$request->token;
        //print_r($token);
        $distance_in_km = $request->distance_in_km;
        $randomNumber = random_int(1000, 9999);
        
         User::where('mobile','=',$request->customer_mobile_number)->update(['paytm_money'=>$paytm_money ,'wallet_balance' =>$wallet_balance]);
        $uid = BookingAvailabilty::where('id','=',$booking_availability_id)->first()->user_id;
        if($adpay < 0){
         User::where('mobile','=',$request->customer_mobile_number)->update(['advance_pay'=>'0']);
        }else{
            User::where('mobile','=',$request->customer_mobile_number)->update(['advance_pay'=>$adpay]);
        }
        if($uid)
        {
          $ride=BookingAvailabilty::where ('id',$booking_availability_id)->update(['ride_status'=>'1']);
        }
        $bookings = new booking_request();
        $bookings->journey_otp =  $randomNumber;// $otp;
        $bookings->booking_availability_id = $booking_availability_id;
        $bookings->customer_mobile_number = $customer_mobile_number;
        $bookings->customer_email=$customer_email;
        $bookings->booking_start_location_id = $start_location_id;
        $bookings->booking_end_location_id = $end_location_id;
        $bookings->start_location = $start_location;
        $bookings->end_location = $end_location;
        $bookings->payment_option = $payment_option;
        $bookings->payment_amount = $payment_amount;
        $bookings->price =$price ;
        $bookings->payment_status =$payment_status ;
        $bookings->remey_payment =$remey_payment;
        $bookings->driver_number =$usernum->mobile;
        $bookings->distance_in_km = $distance_in_km;
        $bookings->pickup_lat =$pickup_lat;
        $bookings->pickup_long = $pickup_long;
        
        $bookings->destinationLat =$destinationLat;
        $bookings->destinationLog = $destinationLog;
        if($bookings->save())
        {
      
                $driverData=driver::where('user_id', $uid)->first();
                $result_otp =   $this->sendOtp($customer_mobile_number,$randomNumber);
                $bookings=["booking"=>[$bookings->toArray()],"driver"=>[$driverData]];
                $token=$driverData->token;
                   
                 $notification_title = "Booking Request";
                 $notification_body = "You have Booking Request From ".$customer_mobile_number;
                /* $descriptiondetail = ["notification_type"=>"bookingrequest","customer_mobile_number"=>$customer_mobile_number,
                 "distance"=>$distance_in_km,"price"=>$price,"booking_availability_id"=>$booking_availability_id,"booking_request_id"=>$bookingrequestid];*/
                 $fcmresponse = $this->sendDriverBookingNotification($token, array(
                "title" => $notification_title, 
                "body" => $notification_body,
                 'description'=>"New booking request",
                ));
       
                return ["message"=>"success","response"=>[$bookings]];
                $result_DriverBookingNotification=$this->sendDriverBookingNotification($token=$driverData->token);
                 return ["message"=>"success","response"=>$fcmresponse];
                }else{
                    return ["message"=>"something went wrong"];
        } 
             
            
            
            
            
            
//=============================            
        }

  }
    public function booking_future_request(Request $request){
        $validator = Validator::make($request->all(),[
         'customer_mobile_number' => 'required',
         'distance_in_km' => 'required',
         'start_location' => 'required',
         'end_location'   => 'required',
         'date'           => 'required',
         'time'           => 'required',
         'currentlatitude' =>'required',
         'currentlongitude' =>'required',
         'destinationlatitude' =>'required',
         'destinationlongitude' =>'required',
        ]);
        if ($validator->fails()) {          
        return response()->json(['error'=>$validator->errors()], 401);                        
        }
        $currentlatitude=$request->currentlatitude;
        $currentlongitude=$request->currentlongitude;
        $pricedata= DB::table('drivers')->select(DB::raw('*, SQRT(POW(69.1 * (currentlatitude - '.$currentlatitude.'), 2) + POW(69.1 * ('.$currentlongitude.'-currentlongitude) * COS(currentlatitude / 57.3), 2)) AS distance'))
                     ->havingRaw('distance < 30')->OrderBy('distance')->get('*');
                    
        if(count($pricedata) > 0){ 
            foreach($pricedata as $row){
               $mobliess= user::where('id',$row->user_id)->first();
                $customer_mobile_number = $request->customer_mobile_number;
                $start_location = $request->start_location;
                $end_location = $request->end_location;
                $time = $request->time;
                $date = $request->date;
                $distance_in_km = $request->distance_in_km;
                $customercurrentlatitude = $request->currentlatitude;
                $customercurrentlongitude= $request->currentlongitude;
                $customerdestinationlatitude = $request->destinationlatitude;
                $customerdestinationlongitude= $request->destinationlongitude;
                //$otp = rand(1000,9999);
                $randomNumber = random_int(1000, 9999);
                $bookings = new future_booking();
                $bookings->journey_otp =  $randomNumber;// $otp;
                $bookings->customer_mobile_number = $customer_mobile_number;
                $bookings->start_location = $start_location;
                $bookings->end_location = $end_location;
                $bookings->time = $time;
                $bookings->date = $date;
                $bookings->driver_mobile=$mobliess->mobile;
                $bookings->customercurrentlat=$customercurrentlatitude;
                $bookings->customercurrentlong=$customercurrentlongitude;
                $bookings->customerdestinationlat=$customerdestinationlatitude;
                $bookings->customerdestinationlong=$customerdestinationlongitude;
                $bookings->drivercurrentlat=$row->currentlatitude;
                $bookings->drivercurrentlong=$row->currentlongitude;
                $bookings->driverdestinationlat=$row->destinationlatitude;
                $bookings->driverdestinationlong=$row->destinationlongitude;
                $bookings->distance_in_km = $distance_in_km;
                if($bookings->save())
                {
                     $f_b_s=$bookings->id;

                     $result_otp =   $this->sendOtp($customer_mobile_number,$randomNumber);
                     if($validator == true){
                          $fetch_data=  DB::table('drivers')->select(DB::raw('*, SQRT(POW(69.1 * (currentlatitude - '.$currentlatitude.'), 2) + POW(69.1 * ('.$currentlongitude.'-currentlongitude) * COS(currentlatitude / 57.3), 2)) AS distance'))
                       ->havingRaw('distance < 30')->OrderBy('distance')->get() ; 
                       //print_r($fetch_data);die;
                       
                          foreach($fetch_data as $data){
                              $moblies= user::where('id',$data->user_id)->first()->mobile;
                              $booking = new future_request();
                              $booking->driver_id = $data->id;
                              $booking->book_id = $f_b_s;
                              $booking->customer_number =$customer_mobile_number;
                              $bookings->driver_mobile=$moblies;
                              $booking->save();
                          }
                            return ["message"=>"success","response"=>200];
                        }else{
                            return ["message"=>"something went wrong","response"=>201];
                        }
                }
            }
        }else{
                return ["message"=>"Driver Not found","response"=>201];
        } 
    }
    public function sendDriverBookingNotification($token) {
      // print_r($token);die;
     /*$json_data=   [
            "to" => 'cIbKjcunQq-kQ4rnDG_4If:APA91bHkSwoVAadKSTquDwj3KqoOVOl1DLFjaIF2TM4tAIkiRGU5Gdi47QZljC_2-bc404oDHWkDbe9oRzEbJMxWCJgkr7lu8V4u4YwwMRU52Wz-A5sOgGJ2LkQyECgcq_IrB6TsE4Vc',
            "notification" => [
                "body" => "SOMETHING",
                "title" => "SOMETHING",
                "icon" => "ic_launcher"
            ],
            "data" => [
                "ANYTHING EXTRA HERE"
            ]
        ];
        $data = json_encode($json_data);
                //FCM API end-point
                $url = 'https://fcm.googleapis.com/fcm/send';
                //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
                $server_key = 'AAAAkKGzq3U:APA91bH04YaEYEjST201bWCOi6Wkx00fjULOQ4iczoHuR4_35Z53wTHoac8xW7x8zyTjD5mwjPKNq7QwIttjDy6hlkhuYVCIT8XnlC6xON4TTqL6hqea33_SyPtYgpUA7VR1TDyM0gL4';
                //header with content_type api key
                $headers = array(
                    'Content-Type:application/json',
                    'Authorization:key='.$server_key
                );
                //CURL request to route notification to FCM connection server (provided by Google)
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $result1= curl_exec($ch);
                return $result1;
                if ($result1 === FALSE) {
                 die('Oops! FCM Send Error: ' . curl_error($ch));
                }
                curl_close($ch);
                exit;
                
                        die;*/
                        
            $SERVER_API_KEY = 'AAAAkKGzq3U:APA91bH04YaEYEjST201bWCOi6Wkx00fjULOQ4iczoHuR4_35Z53wTHoac8xW7x8zyTjD5mwjPKNq7QwIttjDy6hlkhuYVCIT8XnlC6xON4TTqL6hqea33_SyPtYgpUA7VR1TDyM0gL4';
            $title = "Liftdedoo Driver";
            $body = "You have a new ride request";                    
            
        // payload data, it will vary according to requirement
         // payload data, it will vary according to requirement
        // $token="dJ4JiCPlT2WDIBD3GFrTnO:APA91bEo6wLhH0Zv00m-YVwFCgA0CGs517VLGFsG81eanOHXLK0xPy07AcQQq1qGkmYvh6kM31ALpvS4pC36_nhN5upZGBUBCN0Kq39uo7fkjzYKB4m4BMV7OdR9tbj1zP7tvzA1-1lg";
         $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
        
                $extraNotificationData = ["message" => $notification];
                $arrayToSend = array('to' => $token, 'data' => $extraNotificationData,'priority'=>'high');
        // $data = [
        //     "to" => "fKp-s5hdTXiMoTIcvOLZgi:APA91bFlAzvIw6rmwYZUh0VdB4-RIDwQI_5M3TuUcUaYvXs_c4Fa36OvHt3B5Vd7uoN2c-HaAbr3Wh8dQJQh0BBUo1k4D0hDvbjUtjRSi8oITFcuWAsKdpXYRTOoAhnuz2EmhqhTHvJY", // for single device id
        //     "data" => $msg,
        // ];
        $dataString = json_encode($arrayToSend);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
      
        curl_close($ch);
      
        return $response;
        // $response = curl_exec($ch);
      
        //      //Close request
        //         if ($response === FALSE) {
        //         die('FCM Send Error: ' . curl_error($ch));
        //         } else {
        //             //return $response;
        //         }
        //         curl_close($ch);
      
                        
                /*        
                        
                        
                $url = "https://fcm.googleapis.com/fcm/send";
                $token = $token;
                $serverKey = 'AAAAkKGzq3U:APA91bH04YaEYEjST201bWCOi6Wkx00fjULOQ4iczoHuR4_35Z53wTHoac8xW7x8zyTjD5mwjPKNq7QwIttjDy6hlkhuYVCIT8XnlC6xON4TTqL6hqea33_SyPtYgpUA7VR1TDyM0gL4';
                $title = "Liftdedoo Driver";
                $body = "You have a new ride request";
              
                $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
        
                $extraNotificationData = ["message" => $notification];
                $arrayToSend = array('to' => $token, 'data' => $extraNotificationData,'priority'=>'high');
                $json = json_encode($arrayToSend);
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: key='. $serverKey;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            
                //Send the request
                $response = curl_exec($ch);

                //Close request
                if ($response === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
                } else {
                    //return $response;
                }
                curl_close($ch);*/
        }
        /**
     * Add driver my availability booking.
     *
     * @return \Illuminate\Http\Response
     */

    /**
    * @OA\Post(
    *      path="/api/v1/driver/addmyavailability",
    * tags={"driver"},
    *      summary="Add Driver Booking Availability",
    *      description="Returns list of available driver near 30km",
    * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="Provide Driver Mobile Number",
    *           required=true,
    *       ), 
    * @OA\Parameter(
    *          name="pickup_location",
    *          in="query",
    *          description="Provide pickup Location",
    *           required=true,
    *       ),
        * @OA\Parameter(
    *          name="drop_location",
    *          in="query",
    *          description="Provide drop Location",
    *           required=true,
    *       ),
            * @OA\Parameter(
    *          name="pickuplatlng",
    *          in="query",
    *          description="Provide pickup LatLng",
    *           required=true,
    *       ),
                * @OA\Parameter(
    *          name="droplatlng",
    *          in="query",
    *          description="Provide drop LatLng",
    *           required=true,
    *       ),
    
        * @OA\Parameter(
    *          name="vehicle_id",
    *          in="query",
    *          description="Provide Vehicle Id",
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
    public function adddriverBookingAvailability(Request $request)
    {

        $validator = Validator::make($request->all(), 
        [
         'driver_mobile_number' => 'required',
         
         'pickup_location' => 'required',
         
         'drop_location' => 'required',
         
         'pickuplatlng' => 'required',
         
         'droplatlng' => 'required',
         
         'vehicle_id' => 'required',
         
       ]);
        
        if ($validator->fails()) {    
            
        return response()->json(['error'=>$validator->errors()], 401);                        
        } 
        
        $mobile = $request->driver_mobile_number;
        
        $pickup_location = $request->pickup_location;
        
        $drop_location = $request->drop_location;
        
        $pickuplatlng = $request->pickuplatlng;
        
        $droplatlng = $request->droplatlng;
        
       //$drop  = explode(',',$request->droplatlng);
        // $pickuplatlng->double('pickuplatlng');
        // $droplatlng->double('droplatlng');
        $vehicleId = $request->vehicle_id;
       // $rate_per_km=$request->rate_per_km;
        //echo $vehicleId;die;
          $id = User::where('mobile','=',$mobile)->first()->id;
      if(BookingAvailabilty::where('user_id', $id)->exists()){
          return["message"=>"you are already online"];
      }else{
        $distance =  $this->calculateDistanceByLocation($pickuplatlng,$droplatlng);

                    $driver = driver::where('user_id', $id)->first();
                    $drop  = explode(',',$request->droplatlng);
                    $currentlatlon  = explode(',',$request->  pickuplatlng );
                   driver::where('user_id',$id)->update(['vehicle_id'=>$vehicleId,'currentlongitude' =>$currentlatlon[1] , 'currentlatitude' =>$currentlatlon[0],"destinationlongitude"=>$drop[1],"destinationlatitude"=>$drop[0],"destinationname"=>$drop_location,"pickup_location"=>$pickup_location,"online_status"=>1]);
                    $vehicleRate = vehicle::where('id', $vehicleId)->first();
                    $booking = new BookingAvailabilty();
                    $booking->user_id = $id;
                    $booking->driver_id = $driver->id;
                    $booking->pickup_location= $pickup_location;
                    $booking->drop_location = $drop_location;
                    $booking->pickup_location = $pickup_location;
                    $booking->drop_location = $drop_location;
                    $booking->start_time = date('Y-m-d H:i:s');
                    $booking->end_time = date('Y-m-d H:i:s');
                    $booking->vehicle_id = $vehicleId;
                    $booking->online_status ="1";
                    // $booking->rate_per_km =$rate_per_km;
                    $calculateDistance = $this->calculateDistanceByLocation($pickuplatlng,$droplatlng);
                //   $string = strip_tags($calculateDistance);
                //     $stringCut = substr($string, 0, 10);
                //     $endPoint = strrpos($stringCut, ' ');
                //     $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                //     print_r($string);die;
                    //print_r($calculateDistance;);die;
                    // $distanceKm = $calculateDistance['0']->distance_in_km;
                    $distanceKm = $calculateDistance;
                     //print_r( $distanceKm);die;
                    $booking->distance = $distanceKm;
                    $price = round($distanceKm) * $vehicleRate->rate_per_km ;
                   
                    $priceCommission = $price * 35/100;
                    $finalPrice = $price + round($priceCommission);
                    $booking -> distance_price = $finalPrice;
                    if($booking -> save()){
                        return  ["message"=>"success","bookingavailability_id"=>$booking->id ,"online_status"=>$booking->online_status];
                    }else{
                        return   ["message"=>"something went wrong"];
                    }
 
        
              }


}
    /**
    * @OA\Post(
    *      path="/api/v1/driver/changeonlinestatus",
    * tags={"driver"},
    *      summary="List of Available Drivers",
    *      description="Returns list of available driver near 30km",
    * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="Provide Driver Mobile Number",
    *           required=true,
    *       ), 
    * @OA\Parameter(
    *          name="bookingavailablity_id",
    *          in="query",
    *          description="Provide Booking Availability id",
    *           required=true,
    *       ),
        * @OA\Parameter(
    *          name="status",
    *          in="query",
    *          description="Provide status ( 1 for online 0 for offline )",
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
    public function changeBookingAvailability(Request $request)
    {
        
        $validator = Validator::make($request->all(), 
        
        [
         'driver_mobile_number' => 'required',
         
         'bookingavailablity_id' => 'required',
         
         'status' => 'required',
         
       ]);
        // return $request->all();
        if ($validator->fails()) { 
            
        return response()->json(['error'=>$validator->errors()], 401); 
        
        }
        
        $mobile = $request->driver_mobile_number;
        
        $booking_availability_id = $request->bookingavailablity_id;
        
        $status = $request->status;
        
        $booking = BookingAvailabilty::find($booking_availability_id);
        
        $booking->online_status = $status;
        
        if($booking->save()){

            return ["message"=>"success"];
        }else{
            return ["message"=>"something went wrong"];
        }

    }

    public function changeBookingStatus(Request $request){
        
        $validator = Validator::make($request->all(), 
        [
         'status' => 'required',
         
         'booking_request_id' => 'required',
        ]);
           $bookingrequestid = $request->booking_request_id;
           
           $status = $request->status;
           
           $bookingrequest = booking_request::find($bookingrequestid);
           
           $bookingrequest->status = $status;
           
           if($bookingrequest->save()){
    
            return ["message"=>"success"];
          }else{
            return ["message"=>"something went wrong"];
     
      }
   
    }



    public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = 'AAAAuBkmhI0:APA91bEpAtzVe8Kr1yvN8wlX6XLXbBf-BSxFXgl7uyOvGjXg9ZYFrdJ0nzlCSTCuCqwvzz3479LCpC2MF_9jwjZACc3_pv6GXZ76PU-dtyAdokOkC0bKnNBlgZ3TNqkanYewWBQ0YKHc';
  
        // payload data, it will vary according to requirement
        $data = [
            "to" => $device_token, // for single device id
            "data" => $message
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
      
        curl_close($ch);
      
        return $response;
    }
      function sendOtp($mobile, $message)
    {
        
        
       
        // require_once(__DIR__ . '/vendor/autoload.php');
                                                            
    // Configure HTTP basic authorization: BasicAuth
    // $config = ClickSend\Configuration::getDefaultConfiguration()
    //               ->setUsername('support24x7@liftdedoo.com')
    //               ->setPassword('C1C527F4-9E0C-43FD-5592-8D8D5685A069');
    
    // $apiInstance = new ClickSend\Api\SMSApi(new \GuzzleHttp\Client(),$config);
    // $msg = new \ClickSend\Model\SmsMessage();
    // $msg->setBody($message." is verification code of liftdedoo. Please dnt share this with anyone"); 
    // $msg->setTo("+91".$mobile);
    // $msg->setSource("sdk");
    
    // // \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
    // $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
    // $sms_messages->setMessages([$msg]);
    
    // try {
    //     $result = $apiInstance->smsSendPost($sms_messages);
    //     return $result;
    // } catch (Exception $e) {
    //     echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
    // }
        }
      public function startjourney(Request $request) {
          
         $validator = Validator::make($request->all(), 
            [
             
             'booking_availability_id' => 'required',
             
             'journey_otp' => 'required',
           ]);
            if (BookingAvailabilty::where('id', $request->booking_availability_id)->exists() && booking_request::where('journey_otp',$request->journey_otp)->exists()){
            
            $BookingAvailabilty_data=BookingAvailabilty::where('id', $request->booking_availability_id)->first();
            
            booking_request::where('booking_availability_id',$request->booking_availability_id)->update(["status"=>1,"journey_otp"=>null]);
           
            return [
                    "status" => 1,
                    "data" =>[ $BookingAvailabilty_data],
                    "msg" => "Enjoy journey"
                 ];
           
            }  else {
                      return [
                      "status" => 0,
                      "data" => null,
                      "msg" => "something wrong"
                      ];
                
            }
   
    }
     
    public function complete_journey(Request $request) {
     
        $validator = Validator::make($request->all(), 
        [
         'booking_availability_id' => 'required',
       ]);
       
         if (BookingAvailabilty::where('id', $request->booking_availability_id)->exists()){
             
         $id= BookingAvailabilty::where('id', $request->booking_availability_id)->first()->driver_id;
         
         $idd=driver::where('id' ,'=',$id)->update(["online_status"=>0]);
         
         booking_request::where('booking_availability_id',$request->booking_availability_id)->update(["status"=>2]);
         
         BookingAvailabilty::find($request->booking_availability_id)->delete();
         
         return [
             
             
            "code" => 200,
            "status" =>"successfull",
            "message" => "Complete journey"
             ];
           
        }  else {
                  return [
                 "code" => 201,
                "status" =>"failed",
                "message" => "booking id not found"
                  ];}
    }
//--------------------- this api delete availbility of booked driver---------------\\
   public function delete_availablity(Request $request) {
       
     $validator = Validator::make($request->all(), 
     
        [
            
         'bookingavailablity_id' => 'required',
         
       ]);
        if ($validator->fails()) {    
            
        return response()->json(['error'=>$validator->errors()], 401);    
        
        } 
        
        if( booking_request::where('booking_availability_id', $request->bookingavailablity_id)->exists() ){
        
        return ["status"=>"failed","response"=> 202 , 'msg' => "You cant be offline , Because you are on Ride right now."];
    }
        
        
        
        
        
        if(BookingAvailabilty::where('id', $request->bookingavailablity_id)->exists()){
         $id= BookingAvailabilty::where('id', $request->bookingavailablity_id)->first()->driver_id;
         
         $idd=driver::where('id' ,'=',$id)->update(["online_status"=>0]);
         
         BookingAvailabilty::find($request->bookingavailablity_id)->delete();
         
        return [
                  "status" => "success",
                  "response"=> 200,
                  "msg" => 'entry delete'
                  ];
                   
             
   }
   else{
       return [
                  "status" => "failed",
                  "response"=> 201,
                  "msg" => 'availablity_id not found'
                  ];
                   
             }
   }
             
    //*********this api show all request of driver have*************\\
             
             
    public function get_driver_future_request(Request $request){
        
         $validator = Validator::make($request->all(), 
         
            [
                
             'mobile' => 'required',
             
           ]);
           
           
            if ($validator->fails()) {     
                
                return response()->json(['error'=>$validator->errors()], 401);   
                
            } 
            $mobile = $request->mobile;
            
            $data= future_booking::where('driver_mobile', $mobile)->get();
         
              if(count($data) > 0){ 
             
            foreach($data as $row){
                
                $frequest_id= future_request::where('book_id',$row->id)->first();
               
              
                $alldata[]= array(
                    'future_request_id'=>$frequest_id->id,
                    'id'                      =>$row->id,
                    'customer_mobile_number'  =>$row->customer_mobile_number,
                    'start_location'          =>$row->start_location,
                    'end_location'            =>$row->end_location,
                    'journey_datejourney'     =>$row->date,
                    'journey_time'            =>$row->time,
                    'journey_otp'             =>$row->journey_otp,
                    'customercurrentlat'      =>$row->customercurrentlat,
                    'customercurrentlong'     =>$row->customercurrentlong,
                    'customerdestinationlat'  =>$row->customerdestinationlat,
                    'customerdestinationlong' =>$row->customerdestinationlong,
                    
                    );
         
              }
             
              if($alldata){
                return ["message"=>"success","response"=>$alldata];
              }
             
           }else{
                
                 return ["message"=>"no request found","response"=>[]];
              }
            
            
              }
     //*************this api change status of future request table************\\
     
       public function show_intrest(Request $request){
           
            $validator = Validator::make($request->all(), 
            [
                
             'id' => 'required',
            
           ]);
           
             if ($validator->fails()) {          
              
                return response()->json(['error'=>$validator->errors()], 401); 
                
            } 
            
              $id = $request->id;
          
              $future_request   = future_request::where('id', $id)->update(["status"=>'1']);
          
               return ["message"=>"success","response"=>$future_request];
       }
     
     //-----------------this api show all intrest to customer where  status is 1----------------\\
           public function get_myintrest(Request $request){
       
            $validator = Validator::make($request->all(), 
            [
             'mobile' => 'required',
           ]);
           
          if ($validator->fails()) {          
              
                return response()->json(['error'=>$validator->errors()], 401);                        
            } 
             
            $mobile = $request->mobile;
            
            $data= future_booking::where('customer_mobile_number', $mobile )->select("*")->get();
            
            $future_request=future_request::where('customer_number', $mobile )->select("name","future_request.id","book_id","driver_id",
            
            "customer_number","status","driver_mobile")
            
            ->join('drivers', 'future_request.driver_id', '=','drivers.id')
            
            ->get();
           
             return ["message"=>"success","response"=> $data, "request"=>$future_request];
          }
          
    //-----------------this api store driver id to futurebooking table and delete all request from future request tabel-------\\ 
    
            public function assign_driver(Request $request){
             
                
            $validator = Validator::make($request->all(), 
            [
             'id' => 'required',
             'book_id' => 'required',
           ]);
           
           
           if ($validator->fails()) {          
                return response()->json(['error'=>$validator->errors()], 401);                        
            } 
            
            
            $id = $request->id;
            
            $book_id = $request->book_id;
            
            $future_request  = future_request::where('id', $id )->where("book_id",$book_id)->first()->driver_id;
            
            $update_driverId = future_booking::where ('id',$book_id)->update(['assign_driver'=>$future_request]);
            
            if($update_driverId){
                
            $future_request  = future_request::where('book_id', $book_id )->delete();
            
            }
            
            return ["message"=>"success","response"=> 200 ];
            
            }
            
            
    public function cancel_ride_by_driver(Request $request){
               
            $validator = Validator::make($request->all(), 
            [
             'driver_id' => 'required',
            
             'booking_availability_id' => 'required',
             
            
           ]);
           
           
           if ($validator->fails()) {          
                
                return response()->json(['error'=>$validator->errors()], 401);                        
           
            } 
            
            $driver_id = $request-> driver_id;
            
            $book_id = $request-> booking_availability_id;
            
         
         
          if(BookingAvailabilty::where('id', $book_id)->exists()){
             
              $id= BookingAvailabilty::where('id', $book_id)->first()->driver_id;
         
              $idd=driver::where('id' ,'=',$id)->update(["online_status"=>0]);
           
              $update_driverId = booking_request::where ('booking_availability_id',$book_id)->select("*")->first();
            
              $remay_payment = $update_driverId->price;
            
           // $priceadvance=$remay_payment*15/100;
            
              $user_number = $update_driverId ->customer_mobile_number;
            
              $cancel_update = booking_request::where ('id',$update_driverId->id) ->update(['cancel_by_driver'=> '1']);
              
              //$update = User::where ('mobile','=',$user_number) ->update(['cancel_by_driver'=> '1']);
            
              $advance_money = User::where('mobile','=',$user_number)->select("*")->first();
              
              $paytm_money = $advance_money->paytm_money;
              $wallet_balance = $advance_money->wallet_balance;
              $advance= $advance_money->advance_pay;
              
              if($paytm_money > 0 && $wallet_balance > 0){
                  $advanceaddition= $paytm_money + $wallet_balance;
                  $userdata = User::where('mobile','=',$user_number)->update(['advance_pay'=>$advanceaddition, 'wallet_balance' =>'0','paytm_money'=>'0' ]);
              }elseif($advance > 0 &&  $wallet_balance > 0 ){
                 $advanceaddition =  $advance + $wallet_balance;
                 $userdata = User::where('mobile','=',$user_number)->update(['advance_pay'=>$advanceaddition,  'wallet_balance' =>'0','paytm_money'=>'0' ]); 
              }elseif($paytm_money > 0){
                  $advanceaddition = $paytm_money;
                  $userdata = User::where('mobile','=',$user_number)->update(['advance_pay'=>$advanceaddition, 'paytm_money'=>'0']);
              }elseif($wallet_balance > 0 ){
                  $advanceaddition = $wallet_balance;
                  $userdata = User::where('mobile','=',$user_number)->update(['advance_pay'=>$advanceaddition, 'wallet_balance'=>'0']);
              }
              
            
              
            
            
           
            BookingAvailabilty::find($request->booking_availability_id)->delete();
        
           return ["status"=>"success","response"=> 200 , 'message' => "cancel ride "];
            
            
          }
     
    }



    
    
        public function cancel_notification(Request $request){
               
            $validator = Validator::make($request->all(), 
            [
             'available_id' => 'required',
           
           ]);
           
           
           if ($validator->fails()) {          
                
                return response()->json(['error'=>$validator->errors()], 401);                        
           
            } 
            
            $request_id = $request-> available_id;
            
         
            $cancel_update = booking_request::where ('booking_availability_id',$request_id) ->update(['cancel_notification'=> '1']);
            
            return ["status"=>"success","response"=> 200 , 'message' => "notification status change "];
            
            
  
}
    
}