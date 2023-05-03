<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\driver;
use App\Models\vehicle;
use App\Models\VehicleType;
use App\Models\booking_request;
use App\Models\Booking\BookingAvailabilty;
use DB;

class DriverController extends Controller
{
         /**
    * @OA\Post(
    *      path="/api/v1/driver/registerdriver",
     *      tags={"driver"},
    *      summary="Driver Registration",
    *      description="This will register driver",
    * @OA\Parameter(
    *          name="driver_name",
    *          in="query",
    *          description="provide driver name",
    *           required=true,
    *       ),
        * @OA\Parameter(
    *          name="mobile_number",
    *          in="query",
    *          description="provide Mobile Number",
    *           required=true,
    *       ),
            * @OA\Parameter(
    *          name="driving_license_number",
    *          in="query",
    *          description="Provide Driving license Number",
    *           required=true,
    *       ),
               * @OA\Parameter(
    *          name="state",
    *          in="query",
    *          description="Provide state",
    *           required=true,
    *       ),           * @OA\Parameter(
    *          name="city",
    *          in="query",
    *          description="Provide city",
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
    function driverRegistration(Request $request)
    {  

         $mobile = $request->mobile_number;
         $token = $request->token;
       $userid = User::where('mobile','=',$mobile)->first()->id;
      
         if($userid){
            
         DB::beginTransaction(); 
         $driver = new driver();
        $driver->name = $request->name;
        $driver->user_id = $userid;
         $driver->token = $token;
        //$driver->role = 1;
        //$driver->license_number = strtoupper($request->driving_license_number);
        $driver->license_number = strtoupper($request->license_number);
        $driver->city = strtoupper($request->city);
        $driver->state = strtoupper($request->state);
        $driver->gender = strtoupper($request->gender);
        $driver->dob = strtoupper($request->dob);
        $driver->age = strtoupper($request->age);
        
 
            // $driver->driver_mobile_number = strtoupper($request->driver_mobile_number);
            // $driver->name = strtoupper($request->name);
            //   if($request->file('profile_image')) 
            //     {
            //         $file = $request->file('profile_image');
            //         $filename = time().'_'.$file->getClientOriginalName();
            //         $filePath = public_path() . '/storage/Vehicle/';
            //         $file->move($filePath, $filename);
            //     }
            //   $driver->profile_image = $filename;

        if($driver->save())
        {
            $users = User::find($userid);
             $users->user_type = '0';
            $users->role = 1;
            
            $users->save();
            //  dd('$users');die();
            DB::commit();
            return [
                     "code"=>201,
                     "message"=>"success"
                     
                     ];
            DB::rollBack();
            // $driveCar = new vehicle();
            // $driveCar->user_id = $userid;
            // $driveCar->vehicle_registration_number = strtoupper($request->vehicle_registration_number);
            // $driveCar->vehicle_type_id = $request->vehicle_type_id;
            // $driveCar->rate_per_km = $request->rate_per_km;
            // $driveCar->capacity = $request->capacity;
            // if($driveCar->save()){
            //     DB::commit();
            //     return ["message"=>"success"];
            // }else
            // {
            //     return ["message"=>0];
            //     DB::rollBack();
            // }
        }
        }else{
            return [
                "code"=>200,
                "message"=>0
                ];
             }

    }



    



          /**
    * @OA\Post(
    *      path="/api/v1/driver/addvehicle",
     *      tags={"driver"},
    *      summary="Vehicle Registration",
    *      description="This will register driver",
        * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="provide Driver Mobile Number",
    *           required=true,
    *       ),
           * @OA\Parameter(
    *          name="vehicle_type_id",
    *          in="query",
    *          description="Provide Vehicle Type Id",
    *           required=true,
    *       ),
        * @OA\Parameter(
    *          name="vehicle_registration_number",
    *          in="query",
    *          description="Provide Vehicle Registration Number",
    *           required=true,
    *       ),
          * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *  
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="rc_doc",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
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
    function  registerVehicle(Request $request)
    {
        
        $mobile = $request->driver_mobile_number;
        $userid = User::where('mobile','=',$mobile)->first()->id;
        $vehiclenumber = $request->vehicle_registration_number;
        $vehicle = vehicle::where('vehicle_registration_number', '=', $vehiclenumber)->select('vehicle_registration_number')->get();
        //  print_r($vehicle);die();
        // if($userid){
            //  if(User::where(vehicle::where('vehicle_registration_number', '=', $vehiclenumber))){
                
            //      $exits = vehicle::where('user_id','=',$userid)->select('vehicle_registration_number')->get();
       
         if(vehicle::where('vehicle_registration_number', '=', $vehiclenumber)->select('vehicle_registration_number')->exists()){
                      return[ "message"=>'already exits'];
         }
         
            // $VehicleType = VehicleType::where('id','=',$request->vehicle_type_id)->select('id','vehicle_name')->first();
            // //  print_r($VehicleType);die();
            //  $exits = vehicle::where('user_id','=',$userid)->select('id')->first();
         
            // if($exits->id > 0){
            //     $driveCar  = vehicle::find($exits->id);
            //     $driveCar->user_id = $userid;
            //     $driveCar->vehicle_registration_number = strtoupper($request->vehicle_registration_number);
            //     $driveCar->vehicle_type_id = $request->vehicle_type_id;
            //     $driveCar->rate_per_km = $request->rate_per_km;
            //     $driveCar->capacity = $request->capacity;
            //     if($request->file('rc_copy')) 
            //     {
            //         $file = $request->file('rc_copy');
            //         $filename = time().'_'.$file->getClientOriginalName();
            //         $filePath = public_path() . '/storage/Vehicle/';
            //         $file->move($filePath, $filename);
            //     }
            //     $driveCar->rc_copy = $filename;
            //     if($driveCar->update()){ 
            //         return [
            //                 "code"=>201,
            //                 "Vehicle"=>"update vehicle",
            //                 "message"=>"Success",
            //                 "VehicleType"=>$VehicleType->vehicle_name,
            //                 "image_url"=>"https://a1professionals.net/liftdedoo/public/storage/Vehicle/$filename"
            //         ];
            //   } 
            // }
            else{

                $driveCar = new vehicle();
                $driveCar->user_id = $userid;
                $driveCar->vehicle_registration_number = strtoupper($request->vehicle_registration_number);
                $driveCar->vehicle_type_id = $request->vehicle_type_id;
                $driveCar->rate_per_km = $request->rate_per_km;
                $driveCar->capacity = $request->capacity;
                if($request->file('rc_copy')) 
                {
                    $file = $request->file('rc_copy');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $filePath = public_path() . '/storage/Vehicle/';
                    $file->move($filePath, $filename);
                }
                $driveCar->rc_copy = $filename;
                
               if($driveCar->save()){ 
                    return [
                            "code"=>201,
                            "Vehicle"=>"Add vehicle",
                            "message"=>"Success",
                            // "message"=>$driveCar,
                            // "VehicleType"=>$VehicleType->vehicle_name,
                            "image_url"=>"https://a1professionals.net/liftdedoo/public/storage/Vehicle/$filename"
                    ];
               }    
            }
        //  }

        // else{
        //       return [
        //             "code"=>200,
        //             "user"=>"user not found",
        //             "message"=>"failed"
        //         ];
        // }
        
    }




            /**
    * @OA\Post(
    *      path="/api/v1/driver/updatevehicle",
     *      tags={"driver"},
    *      summary="Vehicle Registration",
    *      description="This will register driver dnt send value which dnt need to be changed",
        * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="provide Driver Mobile Number",
    *           required=true,
    *       ),
            * @OA\Parameter(
    *          name="vehicle_id",
    *          in="query",
    *          description="provide vehicle id to be edited",
    *           required=true,
    *       ),
           * @OA\Parameter(
    *          name="vehicle_type_id",
    *          in="query",
    *          description="Provide Vehicle Type Id",
    *       ),
        * @OA\Parameter(
    *          name="vehicle_registration_number",
    *          in="query",
    *          description="Provide Vehicle Registration Number",
    *       ),
          * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *  
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="rc_doc",
     *                     type="file",
     *                ),
     *             )
     *         )
     *     ),
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
    function  updateVehicle(Request $request)
    {
        $mobile = $request->driver_mobile_number;
        $userid = User::where('mobile','=',$mobile)->first()->id;
        $driveCar =  vehicle::where('user_id',$userid)->select('*')->get(); 
        
        
        
        //$driveCar =  vehicle::find($vehicle_id);
        // $driveCar->user_id = $userid;
        //   $vehicleregnum = $request->vehicle_registration_number;
        //         $vehicle_type_id        = $request->vehicle_type_id;
        //     if($vehicleregnum!="")
        //     {
        //         $driveCar->vehicle_registration_number = strtoupper($vehicleregnum);
        //     }
        //     if($vehicle_type_id!="")
        //     {
        //         $driveCar->vehicle_type_id = $vehicle_type_id;
    
        //     }
           
        if($driveCar){
           
            return ["message"=>"success","details"=>$driveCar];
        }else
        {
            return ["message"=>0];
        }
    }


           /**
    * @OA\Post(
    *      path="/api/v1/driver/deletevehicle",
     *      tags={"driver"},
    *      summary="Vehicle Deletion",
    *      description="This will register driver",
        * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="provide Driver Mobile Number",
    *           required=true,
    *       ),
            * @OA\Parameter(
    *          name="vehicle_id",
    *          in="query",
    *          description="provide Driver Mobile Number",
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
    function  deleteVehicle(Request $request)
    {
        //die('hfhdhrj');
        $mobile = $request->driver_mobile_number;
        $userid = User::where('mobile','=',$mobile)->first()->id;
        $id = $request->id;
        $driveCar = vehicle::find($id);
        //  print_r($driveCar);die();
         
        // $driveCar->rate_per_km = $request->rate_per_km;
        // $driveCar->capacity = $request->capacity;
        try{
            if($driveCar->delete()){
                return [
                    "code"=>201,
                    "message"=>"success"];
            }else
            {
                return [
                    "code"=>200,
                    "message"=>0];
            }
        }catch(\Throwable $e)
        {
            return["code"=>200,
            "message"=>"cannot delete this vehicle it has previous booking"];
        }
   
    }
  
          /**
    * @OA\Post(
    *      path="/api/v1/driver/uploadlicense",
     *      tags={"driver"},
    *      summary="Vehicle Registration",
    *      description="This will register driver",
        * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="provide Driver Mobile Number",
    *           required=true,
    *       ),
      * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *  
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="license_doc",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
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
    function uploadLicense(Request $request)
    {
        $mobile = $request->driver_mobile_number;
        $userid = User::where('mobile','=',$mobile)->first()->id;
      if($userid){    
        $driverid = driver::where('user_id','=',$userid)->first()->id;
         if($driverid){
                $driverdetail = driver::find($driverid);
                $driverdetail->document_verification_status = 0;
                 if($request->file('license_doc')) 
                {
                    $file = $request->file('license_doc');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $filePath = public_path() . '/storage/Vehicle/';
                    $file->move($filePath, $filename);
                }
             $driverdetail->license_doc = $filename;
               
                if($driverdetail->save()){
                    return [
                        "code"=>201,
                        "message"=>"success",
                        "image_url"=>"https://a1professionals.net/liftdedoo/public/storage/Vehicle/$filename"
                    // "license"=>$driverdetail
                    ];
                } 
                }
                else{
               return [
                    "code"=>200,
                    "user"=>"user not found",
                    "message"=>"failed"
                ];
        }
    
}
  }
    
// ,'image_url'=>'https://a1professionals.net/liftdedoo/public/storage/'






          /**
    * @OA\Post(
    *      path="/api/v1/driver/updateprofilephoto",
     *      tags={"driver"},
    *      summary="Upload profile Picture",
    *      description="This will register driver",
        * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="provide Driver Mobile Number",
    *           required=true,
    *       ),
      * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *  
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="profile_photo",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
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
    function uploadProfilePhoto(Request $request)
    {
     
        $mobile = $request->driver_mobile_number;
       
        $userid = User::where('mobile','=',$mobile)->first()->id;
        
        if($userid){        
            $driverid = driver::where('user_id','=',$userid)->first()->id;
           
            if($driverid){
                $driverphoto = driver::find($driverid);
                
                if($request->file('profile_image')) 
                {
                    $file = $request->file('profile_image');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $filePath = public_path() . '/storage/Vehicle/';
                    $file->move($filePath, $filename);
                }
                
                $driverphoto->profile_image = $filename;
              
                if($driverphoto->save())
                {       
                    return [
                        "code"=>201,
                        "message"=>"success",
                        "image_url"=>"https://a1professionals.net/liftdedoo/public/storage/Vehicle/$filename"
                        ];
                }
            }else{
                return [
                    "code"=>200,
                    "message"=>"failed"
                ];
            
            }   
        }else{
               return [
                    "code"=>200,
                    "message"=>"failed"
                ];
        }
    }
    
    

  /**
    * @OA\GET(
    *      path="/api/v1/driver/myinfo",
     *      tags={"driver"},
    *      summary="Driver Info",
    *      description="This will display driver's registered vehicles",
        * @OA\Parameter(
    *          name="user_id",
    *          in="query",
    *          description="provide Driver user_id (not driver id)",
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
            function mydetail(Request $request)
            {
              $mobile = $request->driver_mobile_number;
              
              $current_lat = $request->current_lat;
                
              $current_long = $request->current_long;
              
            //   $destination_lat = $request->destination_lat;
              
            //   $destination_long = $request->destination_long;
             
              $id = User::where('mobile','=',$mobile)->first()->id;
              //print_r($id)
              $update= driver::where("user_id",'=',$id)->update(['currentlatitude' => $current_lat ,'currentlongitude' => $current_long ] );
            
              if(BookingAvailabilty::where([["user_id",'=',$id],["online_status",'=',1]])->exists()){
                 
                    //die('fd');
                $onlinestatus = "1";
              }else{
                 $onlinestatus = 0;
              }
              if($id==true){
             
           
            $driverdetail=  driver::where('user_id',$id)->select('id','name','license_number','license_doc','profile_image','online_status','document_verification_status', 'profile_verification_status','currentlatitude','currentlongitude','destinationlatitude','destinationlongitude','destinationname','pickup_location')->first();
                 
            $avauilable_id=BookingAvailabilty::where("user_id",'=',$id)->count();
            
            if($avauilable_id > 0) {  

            $avauilable_id=BookingAvailabilty::where("user_id",'=',$id)->select('id')->first();
            
            if( $avauilable_id !==null && $driverdetail->license_doc !==null && $driverdetail->profile_image !==null ){
                  
              
            $list[] = array('booking_availability_id'=>$avauilable_id->id,'name'=>$driverdetail->name,"id"=>$driverdetail->id,'mobile'=>$mobile,'license_number'=>$driverdetail->license_number,'license_doc'=>$driverdetail->license_doc,'profile_image'=>$driverdetail->profile_image,'online_status'=>$driverdetail->online_status,'document_verification_status'=>$driverdetail->document_verification_status,'profile_verification_status'=>$driverdetail->profile_verification_status,"onlinestatus"=>$onlinestatus,'currentlatitude'=>$driverdetail->currentlatitude,'currentlongitude'=>$driverdetail->currentlongitude,'destinationlatitude'=>$driverdetail->destinationlatitude,'destinationlongitude'=>$driverdetail->destinationlongitude,'destinationname'=>$driverdetail->destinationname,'destinationname'=>$driverdetail->pickup_location);
               
               
                    } else {
                       
            
        $list[] = array('booking_availability_id'=>$avauilable_id->id,'name'=>$driverdetail->name,"id"=>$driverdetail->id,'mobile'=>$mobile,'license_number'=>$driverdetail->license_number,'license_doc'=>$driverdetail->license_doc,'profile_image'=>$driverdetail->profile_image,'online_status'=>$driverdetail->online_status,'document_verification_status'=>$driverdetail->document_verification_status,'profile_verification_status'=>$driverdetail->profile_verification_status,"onlinestatus"=>$onlinestatus,'currentlatitude'=>$driverdetail->currentlatitude,'currentlongitude'=>$driverdetail->currentlongitude,'destinationlatitude'=>$driverdetail->destinationlatitude,'destinationlongitude'=>$driverdetail->destinationlongitude,'destinationname'=>$driverdetail->destinationname,'destinationname'=>$driverdetail->pickup_location);
                
                    }
                    
              }
           
        $list[] = array('booking_availability_id'=>null,'name'=>$driverdetail->name,"id"=>$driverdetail->id,'mobile'=>$mobile,'license_number'=>$driverdetail->license_number,'license_doc'=>$driverdetail->license_doc,'profile_image'=>$driverdetail->profile_image,'online_status'=>$driverdetail->online_status,'document_verification_status'=>$driverdetail->document_verification_status,'profile_verification_status'=>$driverdetail->profile_verification_status,"onlinestatus"=>$onlinestatus,'currentlatitude'=>$driverdetail->currentlatitude,'currentlongitude'=>$driverdetail->currentlongitude,'destinationlatitude'=>$driverdetail->destinationlatitude,'destinationlongitude'=>$driverdetail->destinationlongitude,'destinationname'=>$driverdetail->destinationname,'destinationname'=>$driverdetail->pickup_location);

         if(BookingAvailabilty::where([["user_id",'=',$id]])->exists()){
        
       
        
         $book= BookingAvailabilty::where("user_id",'=',$id)->first()->id;
        //print_r($book);die;
         $fetch_bookrequestdat=BookingAvailabilty::where("user_id",'=',$id)->select ('distance_price')->first();
              
                if($book ){
                    
                    if(booking_request::where([["booking_availability_id",'=',$book]])->exists()){
                   
                   $book2= booking_request::where("booking_availability_id",'=', $book)->first()->id;
                 
                  
                   $fetch_bookrequestdata=booking_request::where('id',$book2)->select ('*')->first();
                
                   if( $fetch_bookrequestdata ){
                      //die('test');
                   $list1[] = array('customer_name'=>$fetch_bookrequestdata->customer_name, 
                   'start_location'=>$fetch_bookrequestdata->start_location, 
                   'end_location'=>$fetch_bookrequestdata->end_location,
                   "customer_email"=>$fetch_bookrequestdata->customer_email,
                   'customer_address'=>$fetch_bookrequestdata->customer_address,
                   'customer_mobile_number'=>$fetch_bookrequestdata->customer_mobile_number, 
                   'customer_mobile_verified'=>$fetch_bookrequestdata->customer_mobile_verified,
                   'booking_start_location_id'=>$fetch_bookrequestdata->booking_start_location_id ,
                   'booking_end_location_id'=>$fetch_bookrequestdata->booking_end_location_id ,
                   'payment_option'=>$fetch_bookrequestdata->payment_option ,
                   'payment_amount'=>$fetch_bookrequestdata->payment_amount ,
                   'price'=>$fetch_bookrequestdat->distance_price ,
                   'distance_in_km'=>$fetch_bookrequestdata->distance_in_km ,
                   'booking_cab'=>$fetch_bookrequestdata->booking_cab ,
                   'status'=>$fetch_bookrequestdata->status  ,
                   'cancel_time'=>$fetch_bookrequestdata->cancel_time  ,
                   'booking_cab'=>$fetch_bookrequestdata->booking_cab  ,
                   'order_id'=>$fetch_bookrequestdata->order_id  ,
                   'transaction_id'=>$fetch_bookrequestdata->transaction_id ,
                   'transaction_id'=>$fetch_bookrequestdata->transaction_id ,
                   'transaction_id'=>$fetch_bookrequestdata->transaction_id ,'transaction_id'=>$fetch_bookrequestdata->transaction_id,'payment_status'=>$fetch_bookrequestdata->payment_status,'remey_payment'=>$fetch_bookrequestdata->remey_payment, 'pickup_lat'=>$fetch_bookrequestdata->pickup_lat ,
                   'pickup_long'=>$fetch_bookrequestdata->pickup_long,
                   'destinationLat'=>$fetch_bookrequestdata->destinationLat,
                   'destinationLog'=>$fetch_bookrequestdata->destinationLog
                   );
                 
                } 
                
                        
                    }
                    else {
                    
                    $list1 = [];
                }
           
                  }
                  
              
                } else{
                    $list1=[];
                }

                return [
                     
                        "detail"=> $list,
                        "request_data"=> $list1, 
                      
                     ];
              
                
            }
            if($driverdetail->license_doc){
             $list[] = array('name'=>$driverdetail->name,"id"=>$driverdetail->id,'mobile'=>$mobile,'license_number'=>$driverdetail->license_number,'license_doc'=>'https://a1professionals.net/liftdedoo/public/storage/Vehicle/'.$driverdetail->license_doc,'profile_image'=>'null','online_status'=>$driverdetail->online_status,'document_verification_status'=>$driverdetail->document_verification_status,'profile_verification_status'=>$driverdetail->profile_verification_status,"onlinestatus"=>$onlinestatus);
             
         }elseif($driverdetail->profile_image){
             $list[] = array('name'=>$driverdetail->name,"id"=>$driverdetail->id,'mobile'=>$mobile,'license_number'=>$driverdetail->license_number,'license_doc'=>'null','profile_image'=>'https://a1professionals.net/liftdedoo/public/storage/Vehicle/'.$driverdetail->profile_image,'online_status'=>$driverdetail->online_status,'document_verification_status'=>$driverdetail->document_verification_status,'profile_verification_status'=>$driverdetail->profile_verification_status,"onlinestatus"=>$onlinestatus);
             
             return [
                "driver"=> $list,
             ];
         }
         
             elseif($driverdetail){
             $list[] = array('name'=>$driverdetail->name,"id"=>$driverdetail->id,'mobile'=>$mobile,'license_number'=>$driverdetail->license_number,'license_doc'=>'null','profile_image'=>'null','online_status'=>$driverdetail->online_status,'document_verification_status'=>$driverdetail->document_verification_status,'profile_verification_status'=>$driverdetail->profile_verification_status,"onlinestatus"=>$onlinestatus);
                //     "driver"=> $list,
       
            return [
                 "driver"=> $list1,
             ];
           }else{
            return [
            "driver"=> "Driver id not found",
           ]; 
         }
      
         $onlinestatus = 0;
         if(BookingAvailabilty::where([["id",'=',$id],["online_status",'=',1]])->exists())
          {
       
          $onlinestatus = 1;
        
          }  
    return [   
        
        "name"=>$driverdetail,"mobile"=>$mobile,
        "profileimageurl"=>config("global.profileimageurl"),
        "license number"=>config("global.license_number"),
        "license image"=>config("global.license_doc"),
        "onlinestatus"=>$onlinestatus,
        'customer_name'=>$fetch_bookrequestdata->customer_name,
        "myvehicles"=> $vehicledetails,"cangoonline"=>1,"isonride"=>"0",
         "myinfo"=>$driverdetail
    ];
    
}

    /**
    * @OA\Post(
    *      path="/api/v1/driver/myvehicles",
     *      tags={"driver"},
    *      summary="Vehicle List",
    *      description="This will display driver's registered vehicles",
        * @OA\Parameter(
    *          name="driver_mobile_number",
    *          in="query",
    *          description="provide Driver Mobile Number",
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
    function myvehicles(Request $request){
        $mobile_number = $request->driver_mobile_number;
        $userid = User::where('mobile','=',$mobile_number)->first()->id;
        $vehicledetails = Vehicle::select('vehicles.*','vehicle_types.vehicle_name','vehicle_types.seat_capacity')
        ->leftJoin('vehicle_types','vehicles.vehicle_type_id','=','vehicle_types.id')->where('vehicles.user_id','=',$userid)->get();
        return $vehicledetails;

    }
            
// get all vehicle types     
    public function vehicletype(Request $request)
   {
    //   die('hjfgh');
      $allvehicle_types= VehicleType::all();
      if($allvehicle_types){
            return [
                     "code"=>201,
                     "status"=>"success",
                     "Vehicles"=>$allvehicle_types,
                     "message"=>"Vehicles"
                  ];
        }else{
             return [
                     "code"=>200,
                     "status"=>"failed",
                     "message" =>"Not found"
                    ];   
        }
   }

// show online status   
   public function onlinestatus(Request $request)
   {
       
      $mobile = $request->driver_mobile_number;
      $status = $request->status;
      $currentlatitude = $request->currentlatitude;
      $currentlongitude= $request->currentlongitude;
      $vehicle_id = $request->vehicle_id;
      $destinationlatitude = $request->destinationlatitude;
      $destinationlongitude = $request->destinationlongitude;
      $destinationname = $request->destinationname;
    
      
      $userid = User::where('mobile','=',$mobile)->first()->id;
      if($userid){
          
         $driverdetail=  driver::where('user_id',$userid)->update(['online_status'=>$status,'currentlatitude'=>$currentlatitude,'currentlongitude'=>$currentlongitude, 'vehicle_id'=>$vehicle_id,'destinationlatitude'=>$destinationlatitude,'destinationlongitude'=>$destinationlongitude, 'destinationname'=>$destinationname]);
        //   print_r($driverdetail);die();
         if($driverdetail){
            $driverdetail=  driver::where('user_id',$userid)->select('id','online_status','currentlatitude','currentlongitude','vehicle_id','destinationlatitude','destinationlongitude','destinationname')->first();
          
            return [
                "driver_status"=> "success",'status'=>$driverdetail->online_status,
             ];
         }else{
            return [
                "driver_status"=> "failed",
                "driver"=> "Driver id not found",
            ]; 
         }
      }else{
         return [
            "user"=> "failed",
            "myvehicles"=> "User id not found",
          ];
    }
      
   }


}

