<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\BookingAvailabilty;
use App\Models\User;
use App\Models\vehicle;
use App\Models\driver;
use App\Models\location;
use Auth;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class BookingAvailabilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show booking form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBookingForm()
    {

        $booking = BookingAvailabilty::leftJoin('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->leftJoin('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->leftJoin('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->join('drivers as three', function ($join) {
            $join->on('booking_availabilties.driver_id', '=', 'three.id');
        })->join('vehicle_types as four', function ($join) {
            $join->on('booking_availabilties.vehicle_id', '=', 'four.id');
        })
            ->select([
                'booking_availabilties.*',
                'one.location as startLocation',
                'two.location as endLocation',
                'four.vehicle_name as vehicle_name',
            ])->get();

        $locations = location::all();
        $vehicle = vehicle::leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->leftJoin('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('vehicles.user_id', Auth::user()->id)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName')->orderBy('vehicle_name')->get();
        $locations = location::all();
        return view('front.driver.driver-availability-booking', compact('locations', 'vehicle', 'booking'));
    }

    /**
     * Show only driver info.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddData()
    {
        $id = Auth::user();
        $booking = BookingAvailabilty::leftJoin('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->join('vehicles as four', function ($join) {
            $join->on('booking_availabilties.vehicle_id', '=', 'four.id');
        })->join('vehicle_types as v_type', function ($join) {
            $join->on('v_type.id', '=', 'four.vehicle_type_id');
        })->Join('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->Join('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->select([
                'booking_availabilties.*',
                'one.location as startLocation',
                'two.location as endLocation',
                'four.vehicle_registration_number as vehicleRegistartionNumber',
            ])->where("booking_availabilties.user_id", $id->id)->where('booking_availabilties.booking_confirm_status',"!=","1")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))->get();
        
        $vehicle = vehicle::leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->leftJoin('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('vehicles.user_id', Auth::user()->id)->select('vehicles.id as vehicleId','vehicle_types.vehicle_name as vehicleName')->orderBy('vehicle_name')->get();
        
        $locations = location::all();
        return view('front.driver.availability-booking', ['locations' => $locations, 'vehicle' => $vehicle, 'booking' => $booking,'driverId'=>$id]);
    }

    /**
     * Add driver my availability booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_time = Carbon::createFromFormat('d-m-Y H:i', $request->start_time)->format('Y-m-d H:i');
        $end_time = Carbon::createFromFormat('d-m-Y H:i', $request->end_time)->format('Y-m-d H:i');        
        try{
            $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
            $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
            $vehicleId = vehicle::where('id',$request->vehicle_type)->first();
            $id = Auth::User()->id;
            if (Auth::User()->status == 0) {

                $startDate = date('Y-m-d H:i',strtotime($start_time));
                $endDate = date('Y-m-d H:i',strtotime($end_time));
                $selectDriverInDate = DB::select("SELECT start_time, end_time FROM booking_availabilties WHERE user_id = '$id' AND ('$startDate' between start_time and end_time OR '$endDate' between start_time and end_time OR (start_time >= '$startDate' AND end_time <= '$endDate'))  AND (start_time <= '$startDate' OR  end_time >= '$endDate' OR start_time <= '$endDate')" );
          

                if(!empty($selectDriverInDate)){
                    Session()->flash('block', 'Driver Already Booked at given date & time, please select different date range');
                    return redirect()->back();
                }else{
                    $driver = driver::where('user_id', $id)->first();
                    $booking = new BookingAvailabilty();
                    $booking->user_id = $id;
                    $booking->driver_id = $driver->id;
                    $booking->start_location_id = $startLocationId;
                    $booking->start_time = $start_time;
                    $booking->end_time = $end_time;
                    $booking->end_location_id = $endLocationId;
                    $booking->vehicle_id = $request->vehicle_type;
                    $calculateDistance = $this->calculateDistanceByLocation($startLocationId,$endLocationId);
                    $distanceKm = $calculateDistance['0']->distance_in_km;
                    $booking->distance = round($distanceKm);
                    $price = round($distanceKm) * $vehicleId->rate_per_km ;
                    $priceCommission = $price * 35/100;
                    $finalPrice = $price + round($priceCommission);
                    $booking -> distance_price = $finalPrice;
                    if($booking->distance < 30){
                     Session()->flash('block', 'Minimum distance should be 40 kilometers.');
                     return redirect()->back();
                    }
                    else{
                    $booking -> save();
                    Session()->flash('booking', 'You have Successfully booked your availability');
                    return redirect()->route('add.booking.availability');
                }
                }
            } else {
                Session()->flash('block', 'Your account is temporary blocked. Please contact support to resolve this issue.');
                return redirect()->back();
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }

    /**
     * Calculate distance between two location
     *
     * @return $startLocationId = Start location Id
     * @return $endLocationId = End Location Id
     */

    public function calculateDistanceByLocation($startLocationId,$endLocationId)
    {
        $distance = DB::select("SELECT a.location AS from_city, b.location AS to_city, 111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.Latitude)) * COS(RADIANS(b.latitude)) * COS(RADIANS(a.longitude - b.longitude)) + SIN(RADIANS(a.latitude)) * SIN(RADIANS(b.latitude))))) AS distance_in_km FROM locations AS a JOIN locations AS b ON a.id <> b.id WHERE a.id = '$startLocationId' AND b.id = '$endLocationId'");       
        return $distance;
    }

    /**
     * Show driver booking history.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewBookingHistory(Request $request)
    {
        $booking = BookingAvailabilty::leftJoin('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->leftJoin('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location', '=', 'two.id');
        })->leftJoin('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location', '=', 'one.id');
        })
            ->select([
                'booking_availabilties.*',
                'users.mobile as usermobile',
                'users.name as drivername',
                'one.location as startLocation',
                'two.location as endLocation',

            ])->get();

        return view('front.driver.my-availability-history', compact('booking'));
    }


    public function searchDriverBooking(Request $request){
        $id = Auth::user()->id;
        $search = $request->input('search');
        $booking = BookingAvailabilty::leftJoin('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->join('vehicles as four', function ($join) {
            $join->on('booking_availabilties.vehicle_id', '=', 'four.id');
        })->join('vehicle_types as v_type', function ($join) {
            $join->on('v_type.id', '=', 'four.vehicle_type_id');
        })->Join('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->Join('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->select([
                'booking_availabilties.*',
                'one.location as startLocation',
                'two.location as endLocation',
                'four.vehicle_registration_number as vehicleRegistartionNumber',
            ])->where("booking_availabilties.user_id", $id)->where('booking_availabilties.booking_confirm_status',"!=","1")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))->where('four.vehicle_registration_number', 'LIKE', "%{$search}%")->get();

        return view('front.driver.search-driver-availability-booking', ['booking' => $booking]);
    }
}
