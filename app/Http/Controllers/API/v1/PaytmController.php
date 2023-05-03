<?php
namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paytm;
//require_once(base_path().'vendor/autoload.php');
use App\Models\Booking\BookingAvailabilty;
//use paytm\paytmchecksum;
//use paytm\checksum\PaytmChecksumLibrary;
use PaytmChecksum;
use Illuminate\Support\Facades\Redirect;

class PaytmController extends Controller
{
     public function index(Request $request){
         
        require_once(base_path()."/vendor/paytm/vendor/paytm/paytmchecksum/PaytmChecksum.php");

        require_once(base_path().'/vendor/paytm/vendor/autoload.php');
        $mid='bMByNw59418378787342';
        $mkey='JWvIn4Qz3uGatmDV';
        $paytmParams = array();
        $orderId=$request->orderId;
        //print_r($orderId);die;
        $amount=$request->amount;
        $currency="INR";
        $custId=$request->custId;
        $callbackUrl= url('/')."/api/v1/customer/paytmchecksum";
        $paytmParams["body"] = array(
               "mid"           =>  $mid,
                "orderId"       => $orderId,
                "userInfo"      => array(
                "custId"    =>$custId),
                "CHANNEL_ID"=>"WAP",
                "txnAmount"     => array(
                "value"     => $amount,
                "currency"  => $currency),
                "websiteName"   => "DEFAULT",
                "callbackUrl"   =>"https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=".$orderId,
             
                "INDUSTRY_TYPE_ID" => "Retail",
                "requestType"   => "Payment"
            );
      
            // $hk=json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES);
           //  print_r($hk);die;
          /*
        * Generate checksum by parameters we have in body
        * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
        */
       //$PaytmChecksumObject=new PaytmChecksum();
       $checksum =PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $mkey);
      
       $verifySignature = PaytmChecksum::verifySignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $mkey, $checksum);
       
          // return ["message"=>"success","response"=>$checksum];
         //  die;
        // echo sprintf("generateSignature Returns: %s\n", $checksum);
       // echo sprintf("verifySignature Returns: %b\n\n", $verifySignature);
      //die;exit;
          if($verifySignature) {
                               
                                    $paytmParams['head'] = array(
                                        "signature"    => $checksum
                                    );
                            // echo $checksum;die;
                            
                                    $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
                                       //die($post_data);
                                      /* for Staging */
                                     //$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$orderId;
                                   /// die($url);
                                    /* for Production */
                                     $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$orderId;
                                    
                                    $ch = curl_init($url);
                                   
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                                    $response = curl_exec($ch);
                           
                                    $decod=json_decode($response);
                                    $head=$decod->head;
                                          print_r($response);die;
                                return    $response;
                                  //return ["message"=>"success","response"=>$head->signature];
                                  die;exit;
                                 //   print_r();die;
                                  return $response;
                            }  else {
                                    
                                	echo "Checksum Mismatched" .": ". $paytmChecksum;
                                	die;
                            }

    
     }
    
     public function validateChecksum(Request $request){
         require_once(base_path()."/vendor/paytm/vendor/paytm/paytmchecksum/PaytmChecksum.php");

        require_once(base_path().'/vendor/paytm/vendor/autoload.php');
        $mid='DHCNwi51212455568704';
       
        $custId="CUST_001";

            $arr= array(
            "requestType"   => "Payment",
            "mid"           =>  $mid,
            "websiteName"   => "WEBSTAGING",
            "orderId"       => $request->orderId,
            "callbackUrl"   => "WEBSTAGING",
            "txnAmount"     => array(
            "value"         => 1.00,
            "currency"      => "INR",
            ),
            "userInfo"      => array(
            "custId"        =>$custId,
            ),
        );

             /* string we need to verify against checksum */  
     $body = json_encode($arr, JSON_UNESCAPED_SLASHES);
           //print_r($body);die;
          // $body = '{"\mid\":"\DHCNwi51212455568704\","\orderId\":"\test23\"}';
         //global $checksum;
        /* checksum that we need to verify */
         $paytmChecksum =$request->signature;
      // print_r($paytmChecksum);die;
   
       
            /**
            * Verify checksum
           * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
          */
         //$PaytmChecksumObject=new PaytmChecksum();

        $isVerifySignature = PaytmChecksum::verifySignature($body, 'p2@&hGyQu#MMkcgc',$paytmChecksum);
       //print_r($isVerifySignature);die;
        if($isVerifySignature) {
        	echo "Checksum Matched";
        } else {
        	echo "Checksum Mismatched" .": ". $paytmChecksum;
        }
}
}