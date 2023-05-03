<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{
    /**
     * view Forgot password form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            return view('front.forgot-password');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show OTP form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function otp(Request $request)
    {
     
        try {
            $userMobile=User::where('mobile',$request->mobile)->first();
            if ($userMobile != "") {
                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $pass = array(); //remember to declare $pass as an array
                $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                for ($i = 0; $i < 8; $i++) {
                    $n = rand(0, $alphaLength);
                    $pass[] = $alphabet[$n];
                }
                $password= (implode($pass));

                $newPassWord = Hash::make($password);
                $userMobile->password = $newPassWord;
                $userMobile->update();
                  // click sms api start
                $username = config('app.clicksend_username');
                $key = config('app.clicksend_key');
                $sender_id = config('app.clicksend_sender_id');
                $to = "+91".$userMobile->mobile;
                $message ="Your Temporary Password is: $password.%0a , After Login Please Change Your Password.";

                $url = "https://api-mapper.clicksend.com/http/v2/send.php?method=http&username=".$username."&key=".$key."&to=".$to."&message=".$message."&senderid=".$sender_id."";
                $crl = curl_init();
                          
                curl_setopt($crl, CURLOPT_URL, $url);
                curl_setopt($crl, CURLOPT_FRESH_CONNECT, true);
                curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                $xml_string = curl_exec($crl);
                $xml = simplexml_load_string($xml_string);
                $json = json_encode($xml); 
                $response = json_decode($json,true);

                if(!empty($response)){
                    $smsStatusCode = $response["messages"]["message"]["result"];
                    $smsStatus = $response["messages"]["message"]["errortext"];
                    if($smsStatusCode == 0000 && $smsStatus == "Success"){
                        Session()->flash('status', 'Your New Password Sent Successfully to your Mobile Number');                
                    }elseif($smsStatusCode == 2022 && $smsStatus == "Invalid Credentials"){
                        Session()->flash('status', 'Something Went Wrong');
                    }else{
                        Session()->flash('status', 'Something Went Wrong');
                    }
                }
                return redirect()->back();
            } 
            else {
                Session()->flash('cancel', 'Please Enter Valid Mobile Number');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * driver and agency change password form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);

            $user = User::where('mobile', $request->mobile)->first();
            $user->password = Hash::make($request->new_password);
            $user->update();
            return redirect("login");
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
