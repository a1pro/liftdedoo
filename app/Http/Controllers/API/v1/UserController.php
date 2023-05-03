<?php

namespace App\Http\Controllers\API\v1;
// require_once(__DIR__ . '/vendor/autoload.php');
// require __DIR__.'/../vendor/autoload.php';

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\State;
use App\Models\driver;
use App\Models\City;
use App\Models\Customer;
use App\Models\booking_request;
use App\Models\Booking\BookingAvailabilty;
use ClickSend;
// use GuzzleHttp\Client;

    
class UserController extends Controller
{  
 
    function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }
 /**
    * @OA\Get(
    *      path="/api/v1/users",
    *      summary="Users List",
    *      description="Returns list of projects",
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
    function index(Request $request)
    {
        $userdata = User::all();
        return response()->json(['userdetails'=>$userdata]);
    }

             /**
    * @OA\Post(
    *      path="/api/v1/customer/registercustomer",
    *      summary="Customer Registration",
    *       tags={"customer"},
    *      description="Register the Customer",
    * @OA\Parameter(
    *          name="email",
    *          in="query",
    *          description="provide email address",
    *           required=false,
    *       ),
    * @OA\Parameter(
    *          name="mobile",
    *          in="query",
    *          description="provide Mobile Number",
    *           required=true,
    *       ),
    * @OA\Parameter(
    *          name="otp",
    *          in="query",
    *          description="Provide Otp",
    *           required=true,
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
    function registerCustomer(Request $request)
    {
        
        $validator = Validator::make($request->all(), 
        [
            
         'mobile' => 'required',
         
         'otp' => 'required',
         
         'email' => 'required',
         
           ]);
      
        if ($validator->fails()) {          
        
        return response()->json(['error'=>$validator->errors()], 401);                        
        }

        $email = $request->email;
        $mobile = $request->mobile;
        $otp = $request->otp;
        $remembertoken = time().$this->random_string(25);
        $encryptedtoken = Hash::make($remembertoken);
        $role = 3;
        $usertype = 1;
        if(User::where([['mobile','=',$mobile]])->exists()){
            $uid = User::where('mobile','=',$mobile)->first()->id;
            $users = User::find($uid);
            $users->email = $email;
            // $users->status = $ot1;
            // $users-> mobile_verify_status= $mobile= 1;
            $users->role = $role;
            $users->mobile_verify_status = '1';
            $users->status = '1';
            $users->user_type = '1';
           // $users->registration_status = 1;
            $users->remember_token = $encryptedtoken;
            if(User::where('email','=', $email)->exists()){
                  return ["message"=>"email already exists "];
            }
            if($users->save()){
                // $this->sendOtp($mobile,$otp);
                return ["message"=>"success","token"=>$remembertoken];
            }else{
                return ["message"=>0];
            }
        }else{
            $users = new User();
            $users->email = $email;
            $users->mobile = $mobile;
            $users->otp = $otp;
            $users->role = $role;
            $users->user_type = '1';
           $users->mobile_verify_status = '1';
             $users->status = '1';
            // $users->registration_status = 1;
            $users->remember_token = $encryptedtoken;
            $msg = $otp;
            if($users->save()){
                // $this->sendOtp($mobile,$otp);
                return [
                    "message"=>"success","token"=>$remembertoken];
            }else{
               return ["message"=>0];
             }
         }
     }
    
  /*  public function registerCustomer(Request $request)
    {
      $mobile = $request->mobile;
      $userid = User::where('mobile','=',$mobile)->first()->id;
    //print_r($userid);die();
      if($userid){
        $customer = new Customer();
        $customer->user_id = $userid;
        $customer->email = strtoupper($request->email);
        $customer->mobile = strtoupper($request->mobile);
         if($customer->save())
        {
            return [
                     "code"=>201,
                     "message"=>"success"
                     
                     ];
            
        }
      }
     else{
            return [
                "code"=>200,
                "message"=>0
                ];
             }
    }*/

 /**
    * @OA\Post(
    *      path="/api/v1/registerphone",
    *      summary="Register Mobile Number",
    *      description="Mobile number registration",
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent()
    *       ),
        * @OA\Parameter(
    *          name="mobile",
    *          in="query",
    *          description="provide Mobile Number",
    *           required=true,
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
      function checkContact(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
         'mobile' => 'required',
          //'token'=> 'required'
       ]);
        // return $request->all();
        if ($validator->fails()) {          
        return response()->json(['error'=>$validator->errors()], 401);                        
        }
        $otp =  rand(100000,999999);

        $mobile = $request->mobile;
        $token = $request->token;
        //print_r($mobile);die;
        if(User::where('mobile','=',$mobile )->where('user_type' ,'=', '0')->exists()){
            
            if(User::where([['mobile','=',$mobile]])->exists()){
              $number=  User::where([['mobile','=',$mobile]])->first();
             //echo($number->id);die;
             driver::where('user_id', $number->id)
       ->update([
           'token' => $token
        ]);
            
            }  
            
          return ["message"=>"This number already registered as a Driver"];
        }
        else{
        $userdetail =User::where('mobile','=',$mobile)->first();


        $role = 3;
   
       //$otp= User::where([['mobile_verify_status','=',$mobile_verify_status]])->exists();

        if($userdetail ){
                $uid = $userdetail->id;
           // print_r($uid);die;
            $mobile_verify_status = $userdetail->mobile_verify_status;
        $otpverificationstatus=$mobile_verify_status;
        if(User::where([['mobile','=',$mobile]])->exists() &&  $otpverificationstatus==0){
        //   return $user
            $otpcount = $userdetail->otp_count;
           $counter = $otpcount+1;
           if($counter!=3)
           {
            if($otpverificationstatus!=1)
                {
            $users = User::find($uid);
            $users->mobile = $mobile;
            $users->otp = $otp;
            $users->otp_count =$counter;
            $users->role = $role;
            if($users->save()){
                            $result="";
                if($otpverificationstatus!=1)
                {
             $result =   $this->sendOtp($mobile,$otp);
                }
                return ["message"=>"success","isotpverified"=>$otpverificationstatus,"otp"=>$otp,"results"=>$result,"uid"=>$uid];
            }else{
                return ["message"=>0,"uid"=>$uid];
            }
        }else{
            return ["message"=>"success","isotpverified"=>$otpverificationstatus,"uid"=>$uid];

        }
           }else{
            return ["message"=>"Your account has been blocked. Please contact to administer.","uid"=>$uid];
           }
           
        } else if(User::where([['mobile','=',$mobile]])->exists() &&  $otpverificationstatus==1){
            if(User::where([['id','=',$uid]])->exists()){
             driver::where('user_id', $uid)
       ->update([
           'token' => $token
        ]);
            }
             return ["message"=>'already registered',"uid"=>$uid];
             
        }else{
            $users = new User();
            $users->mobile = $mobile;
            $users->otp = $otp;
            $users->role = $role;
            $users->otp_count =1;


            $msg = $otp;
            if($users->save()){
                $result =   $this->sendOtp($mobile,$otp);
                                // $result="";

                return ["message"=>"success","isotpverified"=>0,"results"=>$result,"uid"=>$uid];
            }else{
                return ["message"=>0,"uid"=>$uid];
            }
        }
    } else {
            $users = new User();
            $users->mobile = $mobile;
            $users->otp = $otp;
            $users->role = $role;
            $users->otp_count =1;


            $msg = $otp;
            if($users->save()){
                $result =   $this->sendOtp($mobile,$otp);
                                // $result="";

                return ["message"=>"success","isotpverified"=>0,"results"=>$result];
            }else{
                return ["message"=>0,"uid"=>$uid];
            }
    } 
        
    }
    }
    function checkContact11(Request $request)
    {
       
      $mobile = $request->mobile;
      $usertype = $request->user_type;
     if(User::where('user_type',$usertype)->exists())
     {       
         $userexits = User::where('user_type',$usertype)->select('user_type')->first();

         if($userexits->user_type == 0){
            
                 try {
                   $userid = User::where('mobile', $mobile)->first()->id;
                    } 
                    catch (\Exception $e) {
        $otp =  rand(100000,999999);
              $mobile = $request->mobile;
              $role = 3;
              if($mobile=="999999999999")
        {
            return ["message"=>"success","isotpverified"=>0];
        }
           $users = new User();
            $users->mobile = $mobile;
            $users->otp = $otp;
            $users->role = $role;
            $users->otp_count =1;
            $users->user_type = $usertype;
            $users->password = Hash::make($otp);
            $msg = $otp;
             if($users->save()){
                $result =   $this->sendOtp($mobile,$otp);
                return ["message"=>"success","isotpverified"=>0,"status"=>'null',"otp"=>$otp,"results"=>$result];
            }else{
                return ["message"=>0];
            }
   
}
     if(User::where('mobile',$mobile)->exists())
         { 
             $exits = driver::where('user_id','=',$userid)->select('id','name')->get();
               
              if(driver::where('user_id','=',$userid)->select('id')->exists()){
                  return [
                      "status" =>$exits,
                      "message"=>'already exits'];
                  
              }
          else{   
              $otp =  rand(100000,999999);
              $mobile = $request->mobile;
              $role = 3;
              if($mobile=="999999999999")
        {
            return ["message"=>"success","isotpverified"=>0];
        }
          if(User::where([['mobile','=',$mobile]])->exists()){
            
            $userdetail =User::where('mobile','=',$mobile)->first();
            // print_r($userdetail);die();
            $otpverificationstatus = $userdetail->otp_verification_status;
            $uid = $userdetail->id;
            $otpcount = $userdetail->otp_count;
            $counter = $otpcount+1;
            if($counter!=3){
                if($otpverificationstatus!=1){
                     $users = User::find($uid);
                    $users->mobile = $mobile;
                    $users->otp = $otp;
                    $users->otp_count =$counter;
                     $users->user_type = $usertype;
                    $users->role = $role;
                    if($users->save()){
                     $result="";
                          if($otpverificationstatus!=1)
                        {
                          
                            $result =   $this->sendOtp($mobile,$otp);
                        }
                        return ["message"=>"success","isotpverified"=>$otpverificationstatus,"otp"=>$otp,"results"=>$result];
                    }
                    else
                    {
                        return ["message"=>0];
                    }
                    }
                    else
                    {
                       return ["message"=>"success","mobile"=>"all ready send otp","isotpverified"=>$otpverificationstatus];
                    }
                }
                else 
                {
                     return ["message"=>"Your account has been blocked. Please contact to administer."];
                }
            }
            else
            {
                    $users = new User();
                    $users->mobile = $mobile;
                    $users->otp = $otp;
                    $users->role = $role;
                    $users->otp_count =1;
                    $users->password = Hash::make($otp);
                    $msg = $otp;
             if($users->save())
             {
               
                $result =   $this->sendOtp($mobile,$otp);
                
                return ["message"=>"success","isotpverified"=>0,"status"=>'null',"otp"=>$otp,"results"=>$result];
            }else
            {
                
                return ["message"=>0];
            
                
            }
            
            }
            
            } 
           
           }    
             
    } 
 
 elseif($userexits->user_type == 1){
    
                 try {
                   $userid = User::where('mobile', $mobile)->first()->id;
                    } 
                    catch (\Exception $e) {
        $otp =  rand(100000,999999);
              $mobile = $request->mobile;
              $role = 3;
              if($mobile=="999999999999")
        {
            return ["message"=>"success","isotpverified"=>0];
        }
           $users = new User();
            $users->mobile = $mobile;
            $users->otp = $otp;
            $users->role = $role;
            $users->otp_count =1;
            $users->user_type = $usertype;
            $users->password = Hash::make($otp);
            $msg = $otp;
             if($users->save()){
                $result =   $this->sendOtp($mobile,$otp);
                return ["message"=>"success","isotpverified"=>0,"status"=>'null',"otp"=>$otp,"results"=>$result];
            }else{
                return ["message"=>0];
            }
   
}
 if(User::where('mobile',$mobile)->exists())
         { 
             $exits = Customer::where('user_id','=',$userid)->select('id','email')->get();
               
              if(Customer::where('user_id','=',$userid)->select('id')->exists()){
                  return [
                      "status" =>$exits,
                      "message"=>'already exits'];
                  
              }
          else{   
              $otp =  rand(100000,999999);
              $mobile = $request->mobile;
              $role = 3;
              if($mobile=="999999999999")
        {
            return ["message"=>"success","isotpverified"=>0];
        }
          if(User::where([['mobile','=',$mobile]])->exists()){
            
            $userdetail =User::where('mobile','=',$mobile)->first();
            // print_r($userdetail);die();
            $otpverificationstatus = $userdetail->otp_verification_status;
            $uid = $userdetail->id;
            $otpcount = $userdetail->otp_count;
            $counter = $otpcount+1;
            if($counter!=3){
                if($otpverificationstatus!=1){
                     $users = User::find($uid);
                    $users->mobile = $mobile;
                    $users->otp = $otp;
                    $users->otp_count =$counter;
                     $users->user_type = $usertype;
                    $users->role = $role;
                    if($users->save()){
                         $result="";
                          if($otpverificationstatus!=1)
                        {
                            $result =   $this->sendOtp($mobile,$otp);
                        } return ["message"=>"success","isotpverified"=>$otpverificationstatus,"otp"=>$otp,"results"=>$result];
                    }else{
                        return ["message"=>0];
                    }
                    }else{
                    return ["message"=>"success","mobile"=>"all ready send otp","isotpverified"=>$otpverificationstatus];
                  }
                }
                else {
                     return ["message"=>"Your account has been blocked. Please contact to administer."];
                }
            }
            else{
                  $users = new User();
            $users->mobile = $mobile;
            $users->otp = $otp;
            $users->role = $role;
            $users->otp_count =1;
            $users->password = Hash::make($otp);
            $msg = $otp;
             if($users->save()){
                $result =   $this->sendOtp($mobile,$otp);
                return ["message"=>"success","isotpverified"=>0,"status"=>'null',"otp"=>$otp,"results"=>$result];
            }else{
                return ["message"=>0];
            }
            
            }
} 
 }  
 }       
     }
//       try {

//   $userid = User::where('mobile', $mobile)->first()->id;

// } 
// catch (\Exception $e) {
//         $otp =  rand(100000,999999);
//               $mobile = $request->mobile;
//               $role = 3;
//               if($mobile=="999999999999")
//         {
//             return ["message"=>"success","isotpverified"=>0];
//         }
//           $users = new User();
//             $users->mobile = $mobile;
//             $users->otp = $otp;
//             $users->role = $role;
//             $users->otp_count =1;
//             $users->user_type = $usertype;
//             $users->password = Hash::make($otp);
//             $msg = $otp;
//              if($users->save()){
//                 $result =   $this->sendOtp($mobile,$otp);
//                 return ["message"=>"success","isotpverified"=>0,"status"=>'null',"otp"=>$otp,"results"=>$result];
//             }else{
//                 return ["message"=>0];
//             }
   
// }
   
//          if(User::where('mobile',$mobile)->exists())
//          { 
//              $exits = driver::where('user_id','=',$userid)->select('id','name')->get();
               
//               if(driver::where('user_id','=',$userid)->select('id')->exists()){
//                   return [
//                       "status" =>$exits,
//                       "message"=>'already exits'];
                  
//               }
//           else{   
//               $otp =  rand(100000,999999);
//               $mobile = $request->mobile;
//               $role = 3;
//               if($mobile=="999999999999")
//         {
//             return ["message"=>"success","isotpverified"=>0];
//         }
//           if(User::where([['mobile','=',$mobile]])->exists()){
            
//             $userdetail =User::where('mobile','=',$mobile)->first();
//             // print_r($userdetail);die();
//             $otpverificationstatus = $userdetail->otp_verification_status;
//             $uid = $userdetail->id;
//             $otpcount = $userdetail->otp_count;
//             $counter = $otpcount+1;
//             if($counter!=3){
//                 if($otpverificationstatus!=1){
//                      $users = User::find($uid);
//                     $users->mobile = $mobile;
//                     $users->otp = $otp;
//                     $users->otp_count =$counter;
//                      $users->user_type = $usertype;
//                     $users->role = $role;
//                     if($users->save()){
//                          $result="";
//                           if($otpverificationstatus!=1)
//                         {
//                             $result =   $this->sendOtp($mobile,$otp);
//                         } return ["message"=>"success","isotpverified"=>$otpverificationstatus,"otp"=>$otp,"results"=>$result];
//                     }else{
//                         return ["message"=>0];
//                     }
//                     }else{
//                     return ["message"=>"success","mobile"=>"all ready send otp","isotpverified"=>$otpverificationstatus];
//                   }
//                 }
//                 else {
//                      return ["message"=>"Your account has been blocked. Please contact to administer."];
//                 }
//             }
//             else{
//                   $users = new User();
//             $users->mobile = $mobile;
//             $users->otp = $otp;
//             $users->role = $role;
//             $users->otp_count =1;
//             $users->password = Hash::make($otp);
//             $msg = $otp;
//              if($users->save()){
//                 $result =   $this->sendOtp($mobile,$otp);
//                 return ["message"=>"success","isotpverified"=>0,"status"=>'null',"otp"=>$otp,"results"=>$result];
//             }else{
//                 return ["message"=>0];
//             }
            
//             }
// } 
       
              
//       }  

}

            
      
    
    
   

     /**
    * @OA\Post(
    *      path="/api/v1/otpverification",
    *      summary="Verify Otp Code",
    *      description="Verify Otp Code",
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent()
    *       ),
        * @OA\Parameter(
    *          name="mobile",
    *          in="query",
    *          description="provide Mobile Number",
    *           required=true,
    *       ),
            * @OA\Parameter(
    *          name="otp_code",
    *          in="query",
    *          description="provide otp Code",
    *           required=true,
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
    function otpvalidation(Request $request)
    {

        $validator = Validator::make($request->all(),
         [
             'mobile' => 'required|numeric|min:10',  
             'otp_code' => 'required|numeric|min:6',
 
         ]);
         if($validator->fails())
        {
            return response()->json(['message'=>$validator->errors()]);
        }
        $phonenumber = $request->mobile;
        $otpcode = $request->otp_code;
        if(User::where([['mobile','=',$phonenumber],['otp','=',$otpcode]])->exists())
        {
            
            $uid = User::where([['mobile','=',$phonenumber],['otp','=',$otpcode]])->first()->id;
            $activetoken = time().$this->random_string(25);
            $encryptedtoken = Hash::make($activetoken);
            
            $rider = User::find($uid);
            $rider->otp_count = 0;
            $rider->remember_token = $encryptedtoken;
            $rider->mobile_verify_status = '1';
            $rider->status = '1';
            $rider->update();
            
            return ["message"=>"success","userid"=>$uid,'status'=>$rider,"token"=>$activetoken];
            
        }else{

            $userdetail =User::where([['mobile','=',$phonenumber]])->first();
            $uid = $userdetail->id;
            $otpcount = $userdetail->otp_count;
            //$counter = $otpcount+1;
            $counter = $otpcount;
            if($counter!=3)
            {
            $rider = User::find($uid);
            $rider->otp_count =$counter;
            $rider->update();
            return ["message"=>"Incorrect OTP"];

            }else{
                return ["message"=>"Your account has been blocked. Please contact to administer."];
            }
        }
   }

    function sendOtp($mobile, $message)
    {
        // require_once(__DIR__ . '/vendor/autoload.php');

        // Configure HTTP basic authorization: BasicAuth
        $config = ClickSend\Configuration::getDefaultConfiguration()
                      ->setUsername('support24x7@liftdedoo.com')
                      ->setPassword('C1C527F4-9E0C-43FD-5592-8D8D5685A069');
        
        $apiInstance = new ClickSend\Api\SMSApi(new \GuzzleHttp\Client(),$config);
        $msg = new \ClickSend\Model\SmsMessage();
        $msg->setBody($message." is verification code of liftdedoo. Please dnt share this with anyone"); 
        $msg->setTo("+91".$mobile);
        $msg->setSource("sdk");
        
        // \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
        $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
        $sms_messages->setMessages([$msg]);
        
        try {
            $result = $apiInstance->smsSendPost($sms_messages);
            return $result;
        } catch (Exception $e) {
            echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
        }
    }


         /**
    * @OA\Post(
    *      path="/api/v1/getuserdetail",
    *      summary="Get details",
    *      description="get user detail",
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent()
    *       ),
        * @OA\Parameter(
    *          name="mobile",
    *          in="query",
    *          description="provide Mobile Number",
    *           required=true,
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
function mydetails(Request $request)
{
    $mobilenumber = $request->mobile;
    $details =   User::where('mobile','=',$mobilenumber)->first();

    return ["details"=>$details];
}

   public function stateotpverification(Request $request)
   {
      $all_state= State::orderBy('name')->get();
     
       if($all_state){
            return [
                     "code"=>201,
                     "status"=>"success",
                     "state"=>$all_state,
                     "message"=>"state"
                   ];
        }else{
             return [
                     "code"=>200,
                     "status"=>"failed",
                     "message" =>"Not found"
                    ];   
        }
   }

// get city name with alphabetical 
   public function cityotpverification(Request $request)
   {
       $validator = Validator::make($request->all(),
         [
             'state_id' => 'required',  
         ]);
        if($validator->fails())
        {
            return response()->json(['message'=>$validator->errors()]);
        }
       $select =City::where('state_id',$request->state_id)->select('id','name')->orderBy('name')->get();
       
      if($select){
            return [
                     "code"=>201,
                     "status"=>"success",
                     "city"=>$select,
                     "message"=>"city"
                   ];
        }else{
             return [
                     "code"=>200,
                     "status"=>"failed",
                     "message" =>"Not found"
                    ];   
        }
   }
   
   public function CustomerDetail(Request $request)
   {

     $mobile = $request->customer_mobile_number;
          
        if(User::where('mobile','=',$mobile)->first())
            {
         $userid = User::where('mobile','=',$mobile)->first()->id;
 
     if(booking_request::where('customer_mobile_number','=',$mobile)->where('status','!=',2)->where('cancel_by_driver','!=','1')->select('booking_availability_id')->exists())
     {
        
         
         $avai_id=booking_request::where('customer_mobile_number','=',$mobile)->where('status','!=',2)->where('cancel_by_driver','!=','1')->first();
         
         
         
         
         
         
        
             
                if(BookingAvailabilty::where('id','=',$avai_id->booking_availability_id)->select('id')->exists()){
                 $customer_req_data = booking_request::where('customer_mobile_number',$mobile)
                 ->where('booking_requests.status','!=',2)->where('booking_requests.cancel_by_driver','!=','1')
                ->leftJoin('booking_availabilties', 'booking_requests.booking_availability_id', '=', 'booking_availabilties.id')
                ->leftjoin('drivers', 'booking_availabilties.driver_id', '=', 'drivers.id')
                ->leftjoin('users', 'drivers.user_id', '=', 'users.id')
                ->leftjoin('vehicles', 'booking_availabilties.vehicle_id', '=', 'vehicles.id')
                ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.id')
                ->select('booking_requests.*','booking_availabilties.*','drivers.*','users.*','vehicles.*','vehicle_types.*')->get();
                      

      }  else {
               $customer_req_data = [];
               // $customer_cancelride =[];
              
      }
      } else {
               $customer_req_data = [];  
         
      } 
 
   
        
     
    
    $pickuplatlng = $request->pickuplatlng;
    $droplatlng = $request->droplatlng;
    $pickup_location = $request->pickup_location;
    $pickup = explode(",",$pickuplatlng);
    $locationsData=driver::select(DB::raw('*, SQRT(POW(69.1 * (currentlatitude - '.$pickup[0].'), 2) + POW(69.1 * ('.$pickup[1].'-currentlongitude) * COS(currentlatitude / 57.3), 2)) AS distance'))
                                 ->havingRaw('distance < 31')->OrderBy('distance')->get();
               
      $arrLatLon=$locationsData->toArray();
      
   

    
   $current_customer_data = User::where('mobile','=',$mobile)->get();
  
            
    $customer_cancelride = booking_request::where('customer_mobile_number',$mobile)->where('cancel_by_driver','!=', '0')->select('booking_availability_id','cancel_by_driver','cancel_notification','price','pickup_lat','pickup_long','destinationLat','destinationLog')->get();
        
       if(isset($customer_cancelride)){
    //         foreach($customer_cancelride as $customer_cancel){
    //             $customer_cancelride[]= array(
    //                 "booking_request_id" =>$customer_cancel->id,
    //                 'cancel_by_driver'   =>$customer_cancel->cancel_by_driver,
    //                 'cancel_notification' =>$customer_cancel->cancel_notification,
    //                 'price'              =>$customer_cancel->price,
    //                 'start_location'     =>$customer_cancel->start_location,
    //                 'end_location'       =>$customer_cancel->end_location,
                    
                    
    //                 );
    //   }
    }else{
           $customer_cancelride =[];
       }
              
      
         return [
                 "code"=>201,
                "status" =>'success',
                "req_data"=>$customer_req_data,
                "cancel_by_driver" =>$customer_cancelride,
                "current_customer" =>$current_customer_data,
                "drivers" =>$arrLatLon
             ];
    
    
 }

    else{
        return [
                     "code"=>200,
                     "status" =>'failed',
                    
                    ]; 
    }
}
}
     
//   }

//  }