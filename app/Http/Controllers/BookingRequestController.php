<?php
namespace App\Http\Controllers;
use App\Models\booking_request;
use Illuminate\Http\Request;
use App\Models\Booking\BookingAvailabilty;
use App\Models\driver;
use App\Models\User;
use App\Models\vehicle;
use App\Models\travel_agent;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Paytm;
use PaytmChecksum;

class BookingRequestController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\booking_request  $booking_request
     * @return \Illuminate\Http\Response
     */
    public function show(booking_request $booking_request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\booking_request  $booking_request
     * @return \Illuminate\Http\Response
     */
    public function edit(booking_request $booking_request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\booking_request  $booking_request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, booking_request $booking_request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\booking_request  $booking_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(booking_request $booking_request)
    {
        //
    }


    /**
     * Check user Mobile No for book lift
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function checkUserMobile(Request $request)
    {
        $res = $request->mobile_no;
        return response()->json($res);
    }

    /**
     * Verify OTP
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function verifyOtp(Request $request){
            return response()->json("verified");
    }

    /**
     * Add customer data for booking
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addCustomerData(Request $request){
        $res = $request->name;
        return response()->json($res);
    }

     /**
     * Add Payment for booking
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function addPayment(Request $request){
        //dd($request->all());
        
        try {  
            if($request->bookingId=='dzire' || $request->bookingId=='innova'){

                $price= $request->booking_total_price * 5/100;

                $bookingAdd = new booking_request();
                $bookingAdd ->booking_cab = $request->bookingId;
                $bookingAdd ->customer_name = $request->name;
                $bookingAdd ->customer_mobile_number = $request->mobile_no;
                $bookingAdd ->customer_email = $request->email;
                $bookingAdd ->customer_address = $request->location;
                $bookingAdd ->customer_mobile_verified = "1";
                $bookingAdd ->booking_start_location_id  = $request->start_location_id;
                $bookingAdd ->booking_end_location_id  = $request->end_location_id;
                $bookingAdd ->payment_option = $request->flexRadioDefault;
                $bookingAdd ->payment_amount = round($price);
                $bookingAdd ->price = $request->booking_total_price;
                $bookingAdd ->distance_in_km = $request->distanceKm;
                $bookingAdd ->status = "3";
                $bookingAdd ->save();

            }else{
                $bookingCar = BookingAvailabilty::where('id', $request->bookingId)->first();
                if($request->flexRadioDefault == "0")
                {
                    $price= $bookingCar->distance_price * 15/100;
                }
                else
                {
                    $price= $bookingCar->distance_price * 5/100;
                }
            
                $bookingAdd = new booking_request();
                $bookingAdd -> booking_availability_id = $request->bookingId;
                $bookingAdd -> customer_name = $request->name;
                $bookingAdd -> customer_mobile_number = $request->mobile_no;
                $bookingAdd -> customer_email = $request->email;
                $bookingAdd -> customer_address = $request->location;
                $bookingAdd -> customer_mobile_verified = "1";
                $bookingAdd -> booking_start_location_id  = $bookingCar->start_location_id;
                $bookingAdd -> booking_end_location_id  = $bookingCar->end_location_id;
                $bookingAdd -> payment_option = $request->flexRadioDefault;
                $bookingAdd -> payment_amount = round($price);
                $bookingAdd -> price = $bookingCar ->distance_price;
                $bookingAdd -> distance_in_km = $bookingCar->distance;
                $bookingAdd -> status = "3";
                $bookingAdd -> save();
            }
            $payment = PaytmWallet::with('receive');
            $payment->prepare([
                'order' => rand(1,10000), 
                // 'order' =>$order_id, 
                'user' => $bookingAdd->customer_name,
                'mobile_number' =>  $bookingAdd -> customer_mobile_number,
                'email' => "noemail@liftdedoo.com",
                'booking_id'=>$bookingAdd->id,
                'address' => $bookingAdd -> customer_address, // your user email address
                'amount' => round($price),// amount will be paid in INR.
                'callback_url' =>  url('payment-status/'.$bookingAdd->id) , // callback URL
            ]);
            return $payment->receive();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    public function paymentCallback($id)
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();    
        $order_id = $transaction->getOrderId(); // return a order id 
        $transaction->getTransactionId(); // return a transaction id
        $booking_request = booking_request::where('id', $id)->first();
        $booking_request->order_id= $order_id;
        $booking_request->transaction_id= $transaction->getTransactionId();
        $booking_request->update();
        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            booking_request::where('id', $id)->update(['paytm_payment_status' => 1,'status'=>0]);
            return redirect(route('front_homepage'))->with('message', "Payment successfull, booking Confirmed. Customer service representative will contact you shortly! ");

        } else if ($transaction->isFailed()) {
           booking_request::where('id', $id)->update(['paytm_payment_status' => 0,'status'=>4]);
            return redirect(route('front_homepage'))->with('error', "Your payment is failed.");
            
        } else if ($transaction->isOpen()) {
           booking_request::where('id', $id)->update(['paytm_payment_status' => 2]);
            return redirect(route('front_homepage'))->with('message', "Your payment is processing.");
        }
        $transaction->getResponseMessage(); 
    }
    /**
     * Show booking details in admin side
     *
     * @return \Illuminate\Http\Response
     */

    public function bookingDetails($status)
    {
        try {

            $bookings = $this->getBookingDetailByStatus($status);
            $status = $status;
            return view('admin.booking_request.booking_request',compact('bookings','status'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
    /**
     * Show booking details in admin side accoording to status
     *
     * @return \Illuminate\Http\Response
     */
    public function getBookingDetailByStatus(int $status) : array
    {
        try {
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
                    'booking_availabilties.start_time as startTime',
                    'booking_availabilties.end_time as endTime'
                ])->where('booking_requests.paytm_payment_status','!=',"")->orderBy('booking_requests.id','DESC');

            if($status == "0")
            {
               $booking = $booking->where('booking_requests.status',$status)->get();
            }
            elseif($status == "1")
            {
                $booking = $booking->where('booking_requests.status',$status)->get();
            }
            elseif($status == "2")
            {
                $booking = $booking->where('booking_requests.status',"2")->orwhere('booking_requests.status',"3")->get();
            }
            $bookingInfo=[];
            foreach($booking as $bookingRequest)
            {
                $driver=driver::where('id',$bookingRequest->driverId)->first();
                if($driver != "")
                {
                    $bookingData['id'] =$bookingRequest->id;
                    $bookingData['name'] =$driver->name;
                    $bookingData['customer_name'] =$bookingRequest->customer_name;
                    $bookingData['customer_mobile_number'] =$bookingRequest->customer_mobile_number;
                    $bookingData['endLocation'] =$bookingRequest ->endLocation;
                    $bookingData['startLocation'] =$bookingRequest->startLocation;
                    $bookingData['price'] =$bookingRequest->price;
                    $bookingData['startTime'] =$bookingRequest->startTime;
                    $bookingData['endTime'] =$bookingRequest->endTime;
                    $bookingData['payment_option'] =$bookingRequest->payment_option;
                    $bookingData['status'] =$bookingRequest->status;
                    array_push($bookingInfo, $bookingData);
                }
            }
            return $bookingInfo;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show booking details of driver and customer in admin side
     *$id as $id booking request id
     * @return \Illuminate\Http\Response
     */

    public function driverCustomerDetails($id){
        try {
            $booking = booking_request::Join('booking_availabilties', function ($join) {
                $join->on('booking_requests.booking_availability_id', '=', 'booking_availabilties.id');
            })->Join('locations as two', function ($join) {
                $join->on('booking_requests.booking_start_location_id', '=', 'two.id');
                })->Join('locations as one', function ($join) {
                    $join->on('booking_requests.booking_end_location_id', '=', 'one.id');
                })->select([
                    'booking_requests.*',
                    'two.location as startLocation',
                    'one.location as endLocation',
                    'booking_availabilties.*',
                    'booking_requests.created_at as bookingTime'
                ])->where('booking_requests.id', $id)->first();


            if($booking !="")
            {
                $vehicle = vehicle::where('id',$booking->vehicle_id)->first();
                $driver = driver::where('drivers.id',$booking->driver_id)->Join('users', function ($join) {
                    $join->on('users.id', '=', 'drivers.user_id');
                    })->first();
            }
            else
            {
                $vehicle = "";
                $driver = "";
            }
            return view('admin.booking_request.customer-driver-details',compact('booking','vehicle','driver'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Confirm booking request from admin
     *$bookingRequestId as $bookingRequestId booking request id
     * @return \Illuminate\Http\Response
     */

     public function confirmPayment($bookingRequestId)
    {
        try{
            $booking = booking_request::where('booking_requests.id', $bookingRequestId)->first();
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
            $bookingAvailability->booking_confirm_status ="1";
            $booking->status="1";
            $bookingAvailability ->update();
            $booking->update();
             // click sms api start
            $username = config('app.clicksend_username');
            $key = config('app.clicksend_key');
            $sender_id = config('app.clicksend_sender_id');
            // click sms api to send customer to driver Details Start

            $to = "+91".$booking->customer_mobile_number;
            $bookingRequest = new booking_request;
            $bookingId = $bookingRequest->addFiveDigitNo($booking->id);

            $message ="Confirmed!,Dear $booking->customer_name, Pickup: $bookingAvailability->startLocation, Drop: $bookingAvailability->endLocation, Fare:RS $booking->price/- Booking Id: $bookingId, Driver Name: $driverInfo->name, Phone: $driverMobile->mobile";
            // click sms api to send customer to driver Details End
            $url = "https://api-mapper.clicksend.com/http/v2/send.php?method=https&username=".$username."&key=".$key."&to=".$to."&message=".$message."&senderid=".$sender_id."";
            $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")); 
            //Basically adding headers to the request
            $context = stream_context_create($opts);
            $data = file_get_contents($url,false,$context);
            //$data = htmlspecialchars($data);

            //$data = file_get_contents($url);
            $parsed_xml = simplexml_load_string($data);

            // click sms api to send driver to customer Details start
            if($driverInfo->travel_agent_id =="")
            {
                
            $toDriver = "+91".$driverMobile->mobile;
            $customerMessage ="New Booking!,Dear $driverInfo->name, Pickup:$bookingAvailability->startLocation, Drop:$bookingAvailability->endLocation, Fare: RS$booking->price/-, Customer Name: $booking->customer_name, Phone:$booking->customer_mobile_number.";
            $url2 = "https://api-mapper.clicksend.com/http/v2/send.php?method=https&username=".$username."&key=".$key."&to=".$toDriver."&message=".$customerMessage."&senderid=".$sender_id."";
            $opts2 = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")); 
            //Basically adding headers to the request
            $context2 = stream_context_create($opts2);
            $data2 = file_get_contents($url2,false,$context2);
            //$data2 = htmlspecialchars($data2);
            //$data2 = file_get_contents($url2);
            $parsed_xml2 = simplexml_load_string($data2);

           }
             // click sms api to send driver to customer Details End
           
            if($driverInfo->travel_agent_id !="")
            {
                $driverTravel= travel_agent::where('id',$driverInfo->travel_agent_id)->first();
                $travelMobile = User::where('id',$driverTravel->user_id)->first();
                 // click sms api to send travel-agency driver to customer Details start
                $toAgentDriver = "+91".$travelMobile->mobile;
                $customerMessage ="New Booking!,Dear $driverTravel->agency_name, Driver Name: $driverInfo->name, Fare:RS $booking->price/- Customer Name: $booking->customer_name, Phone: $booking->customer_mobile_number.";

                $url3 = "https://api-mapper.clicksend.com/http/v2/send.php?method=https&username=".$username."&key=".$key."&to=".$toAgentDriver."&message=".$customerMessage."&senderid=".$sender_id."";
                $opts3 = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")); 
                //Basically adding headers to the request
                $context3 = stream_context_create($opts3);
                $data3 = file_get_contents($url3,false,$context3);

                //$data3 = file_get_contents($url3);
                $parsed_xml3 = simplexml_load_string($data3);
                   // click sms api to send travel-agency to customer Details End
            }
           
            if(!empty($parsed_xml)){
                $smsStatusCode = $parsed_xml->messages->message->result;
                $smsStatus = $parsed_xml->messages->message->errortext;
                if($smsStatusCode == 0000 && $smsStatus == "Success"){
                    Session()->flash('status', 'Booking Confirmed Successfully ');
                }elseif($smsStatusCode == 2022 && $smsStatus == "Invalid Credentials"){
                    Session()->flash('status', 'Booking is confirmed but Something Went Wrong from sms side ');
                }else{
                    Session()->flash('status', 'Booking is confirmed but Something Went Wrong from sms side');
                }
            }
            return redirect()->back();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Cancel booking request from admin
     *$bookingRequestId as $bookingRequestId booking request id
     * @return \Illuminate\Http\Response
     */

    public function cancelPayment($bookingRequestId)
    {
        try{
            $booking = booking_request::where('id', $bookingRequestId)->first();
            $bookingAvailability = BookingAvailabilty::where('id',$booking->booking_availability_id)->first();
            $bookingAvailability->booking_confirm_status ="0";
            $date= Date("Y-m-d H:i:s");
            $bookingAvailability->update();
            $booking->status="2";
            $booking->cancel_time=$date;
            $booking->update();
            Session()->flash('cancel', 'Booking Cancelled Successfully ');
            return redirect()->back();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function paymentPending()
    {
        $bookings = booking_request::Join('locations as two', function ($join) {
            $join->on('booking_requests.booking_start_location_id', '=', 'two.id');
            })->Join('locations as one', function ($join) {
                $join->on('booking_requests.booking_end_location_id', '=', 'one.id');
            })->Join('booking_availabilties', function ($join) {
                $join->on('booking_requests.booking_availability_id', '=', 'booking_availabilties.id');
            })->Join('drivers', function ($join) {
                $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
            })->Join('travel_agents', function ($join) {
                $join->on('drivers.travel_agent_id', '=', 'travel_agents.id');
            })->select([
                'booking_requests.*',
                'two.location as startLocation',
                'one.location as endLocation',
                'booking_availabilties.driver_id as driverId',
                'booking_availabilties.start_time as startTime',
                'booking_availabilties.end_time as endTime',
                'booking_availabilties.payment_status',
                'drivers.travel_agent_id as travelAgentId',
                'travel_agents.agency_name as agencyName'
            ])->where('booking_requests.status',1)->where('booking_availabilties.payment_status',"0")->where('booking_availabilties.booking_confirm_status',"1")->orderBy('booking_requests.id','DESC')->where('drivers.travel_agent_id', '!=',"")->get();
        $status = 1;
        return view('admin.booking_request.payment_pending',compact('bookings','status'));
    }

    public function collectPendingPayment($bookingId)
    {
        $booking = BookingAvailabilty::where("id",$bookingId)->first();
        $booking->payment_status = "1";
        $booking->update();
        Session()->flash('status', 'Payment Successfull');
        if($booking){
            return redirect('booking-requests/1');
        }
    }
   

}
