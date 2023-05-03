<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User; 
class DeviceController extends Controller
{
              /**
    * @OA\Post(
    *      path="/api/v1/registerdevice",
    *      summary="Vehicle Registration",
    *      description="This will register driver",
        * @OA\Parameter(
    *          name="mobile_number",
    *          in="query",
    *          description="provide Mobile Number",
    *           required=true,
    *       ),
           * @OA\Parameter(
    *          name="device_firebase_token",
    *          in="query",
    *          description="Provide Vehicle Type Id",
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
    function registerDevice(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
         'mobile_number' => 'required',
         'device_firebase_token' => 'required',
       ]);
       if ($validator->fails()) {          
        return response()->json(['error'=>$validator->errors()], 401);                        
        }
        $mobile = $request->mobile_number;
        $device_token = $request->device_firebase_token;

        $uid = User::where('mobile','=',$mobile)->first()->id;

        $users = User::find($uid);
        $users->device_token = $device_token;
        if($users->save())
        {
          return  ["message"=>"success"];
        }else{
          return  ["message"=>"something went wrong"];
        }



    }
}
