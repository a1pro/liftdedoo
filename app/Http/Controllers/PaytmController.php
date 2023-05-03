<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paytm;
use App\Models\Booking\BookingAvailabilty;

class PaytmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the location data in table.
     *
     * @return \Illuminate\Http\Response
     */
     public function PaytmChecksum(){
         die("5");
         
     }
    public function index()
    {
        $paytmDetails=paytm::latest()->first();
        
        if($paytmDetails =="")
        {
            $paytmDetails="";
        }
        return view('admin.paytm',compact('paytmDetails'));
    }

    public function store(Request $request)
    {
        $paytmDetails=paytm::latest()->first();


        if($paytmDetails =="")
        {
            
            $paytmDetails = new Paytm();
            $paytmDetails->paytm_environment = $request->paytm_environment;
            $paytmDetails->paytm_merchant_id = $request->paytm_merchant_id;
            $paytmDetails->paytm_merchant_key = $request->paytm_merchant_key;
            $paytmDetails->paytm_merchant_website = $request->paytm_merchant_website;
            $paytmDetails->paytm_channel = $request->paytm_channel;
            $paytmDetails->paytm_industry_type = $request->paytm_industry_type;
            $paytmDetails->save();
        }
        else
        {
        
            $paytmDetails->paytm_environment = $request->paytm_environment;
            $paytmDetails->paytm_merchant_id = $request->paytm_merchant_id;
            $paytmDetails->paytm_merchant_key = $request->paytm_merchant_key;
            $paytmDetails->paytm_merchant_website = $request->paytm_merchant_website;
            $paytmDetails->paytm_channel = $request->paytm_channel;
            $paytmDetails->paytm_industry_type = $request->paytm_industry_type;
            $paytmDetails->update();
        }
        Session()->flash('change', 'Your Paytm Details Successfully ');
        return redirect()->route('paytm.details')->with(['paytmDetails'=>$paytmDetails]);
    }
    
     public function paytmPayment()
     {
         $payments = BookingAvailabilty::all();
         return view('admin.paytmpayment', compact('payments'));
     }
}
