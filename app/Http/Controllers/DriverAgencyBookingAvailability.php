<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking\BookingAvailabilty;
use App\Models\location;
use App\Models\vehicle;
use App\Models\VehicleType;
use App\Models\driver;
use App\Models\travel_agent;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;
class DriverAgencyBookingAvailability extends Controller
{
    /**
     * Show driver form.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowDriverForm($id)
    {
        try {
            $driverId= $id;
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
            })->where('vehicles.user_id', $driverId)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName')->orderBy('vehicle_name')->get();

            return view("admin.driver-agency-booking.driver-booking-availibality", compact('driverId','locations', 'vehicle', 'booking'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show driver form.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAdminDriver(Request $request)
    {
        try {
            $id = Auth::User()->id;
            $driver = driver::where('user_id', $request->driverId)->first();
            $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
            $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
            $vehicleId = vehicle::where('id',$request->vehicle_type)->first();
            if ($driver != null) {
                $booking = new BookingAvailabilty();
                $booking->user_id =  $request->driverId;
                $booking->driver_id = $driver->id;
                $booking->start_location_id = $startLocationId;
                $booking->start_time =  date('Y-m-d H:i',strtotime($request->start_time));
                $booking->end_time =  date('Y-m-d H:i',strtotime($request->end_time));
                $booking->end_location_id = $endLocationId;
                $booking->vehicle_id = $request->vehicle_type;
                $calculateDistance = $this->calculateDistanceByLocation($startLocationId,$endLocationId);
                $distanceKm = $calculateDistance['0']->distance_in_km;
                $booking->distance = round($distanceKm);
                $price = round($distanceKm) * $vehicleId->rate_per_km ;
                $priceCommission = $price * 25/100;
                $finalPrice = $price + round($priceCommission);
                $booking -> distance_price = $finalPrice;
                $booking->save();

                Session()->flash('booking', 'You have successfully booked your availability');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show driver form.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowAgencyForm($id)
    {
        try {
            $agencyId= $id;
            $id = Auth::user()->id;
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
                    'users.mobile as usermobile',
                    'three.name as drivername',
                    'four.vehicle_name as vehicle_name',
                    'one.location as startLocation',
                    'two.location as endLocation',

                ])->get();
            $agent= travel_agent::where('user_id',$agencyId)->first();
            $driver = driver::orderBy('name')->where('travel_agent_id',$agent->id )->get();
            $vehicle = vehicle::leftJoin('users', function ($join) {
                $join->on('vehicles.user_id', '=', 'users.id');
            })->leftJoin('vehicle_types', function ($join) {
                $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
            })->where('vehicles.user_id', $agencyId)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName')->orderBy('vehicle_name')->get();
            return view("admin.driver-agency-booking.agency-booking-availibality", [ 'vehicle' => $vehicle, 'driver' => $driver, 'booking' => $booking, 'agencyId'=>$agencyId]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show driver form.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAgencyDriver(Request $request)
    {
        $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
        $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
        try {

            $request->validate([
                'vehicle_type' => ['required'],
            ]);
            $id = $request->driverUserId;
            if (Auth::User()->status == 0) {
                $user = User::create([

                    'mobile' => $request->mobile,
                    'password' => Hash::make('Driver@123'),
                    'role' => $request->role,

                ]);
                $driver = driver::where('user_id', $request->driverUserId)->first();
                $vehicleId = vehicle::where('id',$request->vehicle_type)->first();
                if ($driver != null) {
                    $booking = new BookingAvailabilty();
                    $booking->user_id = $request->agencyId;
                    $booking->driver_id = $driver->id;
                    $booking->start_location_id = $startLocationId;
                    $booking->start_time =  date('Y-m-d H:i',strtotime($request->start_time));
                    $booking->end_time =  date('Y-m-d H:i',strtotime($request->end_time));
                    $booking->end_location_id = $endLocationId;
                    $booking->vehicle_id = $request->vehicle_type;
                    $calculateDistance = $this->calculateDistanceByLocation($startLocationId,$endLocationId);
                    $distanceKm = $calculateDistance['0']->distance_in_km;
                    $booking->distance = round($distanceKm);
                    $price = round($distanceKm) * $vehicleId->rate_per_km ;
                    $priceCommission = $price * 25/100;
                    $finalPrice = $price + round($priceCommission);
                    $booking -> distance_price = $finalPrice;
                    $booking->save();
                    Session()->flash('booking', 'You have successfully booked your availability');
                }
                return redirect()->back();
            } else {
                Session()->flash('block', 'Your account is blocked. Please contact support to resolve this issue. ');
                return redirect()->back();
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Fetch mobile number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetchMobile(Request $request)
    {
        $userPhone = User::select('mobile')->where("id", $request->id)->first();
        return response()->json($userPhone);
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
}
