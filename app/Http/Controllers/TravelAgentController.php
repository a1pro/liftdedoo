<?php

namespace App\Http\Controllers;

use App\Models\travel_agent;
use App\Models\User;
use App\Models\driver;
use App\Models\vehicle;
use App\Models\VehicleType;
use App\Models\Booking\BookingAvailabilty;
use Illuminate\Support\Facades\DB;
use App\Models\location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use App\Http\Requests;
use Illuminate\Support\Carbon;
use App\Models\booking_request;

class TravelAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show agency driver info.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $travelAgentId = travel_agent::where('user_id', Auth::user()->id)->pluck("id")->first();
        $driver = User::select('users.*', 'drivers.age as age', 'drivers.license_number as license_number', 'drivers.name as name')
            ->join('drivers', 'users.id', '=', 'drivers.user_id')->where('users.role', '1')->where('drivers.travel_agent_id', $travelAgentId)->orderBy('name', 'ASC')->get();
        return view('front.travelagent.agency-driver-info', compact('driver'));
    }

    /**
     * Show agency car registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCar()
    {
        $vehicleType = VehicleType::orderBy('vehicle_name')->get();
        return view('front.travelagent.agency-car-registration', ['vehicleType' => $vehicleType]);
    }

    /**
     * Show agency driver registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDriver()
    {

        return view('front.travelagent.agency-driver-registration');
    }

    /**
     * Store agency car information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAgencyCarInfo(Request $request)
    {
        $travel = travel_agent::where("user_id", Auth::user()->id)->first();
        $vehicle = vehicle::where("user_id", Auth::user()->id)->get();
        if (count($vehicle) < $travel->number_of_vehicles) {
            $id = Auth::user()->id;
            $user = User::find($id);
            $agencyCar = new vehicle();
            $agencyCar->user_id = $user->id;
            $agencyCar->vehicle_registration_number = strtoupper($request->vehicle_registration_number);
            $agencyCar->vehicle_type_id = $request->vehicle_name;
            $agencyCar->rate_per_km = $request->rate_per_km;
            $agencyCar->capacity = $request->capacity;
            $agencyCar->save();
            Session()->flash('save', 'Agencies vehicle info added successfully ');
            return redirect('agency-car-info');
        } else {
            Session()->flash('limit', 'Your vehicle limit is over, Please increase your limit from your account section');
            return redirect('agency-car-info');
        }
    }

    /**
     * Show agency car information.
     *
     * @param  \App\Models\travel_agent  $travel_agent
     * @return \Illuminate\Http\Response
     */
    public function showAgencyCarInfo(travel_agent $travel_agent)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $carInfo = vehicle::where('user_id', Auth::id())->get();
        $vehicleType = VehicleType::orderBy('vehicle_name')->get();
        $agencyCarHistory = vehicle::leftJoin('vehicle_types as two', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'two.id');
        })
            ->select([
                'vehicles.*',
                'two.vehicle_name'
            ])->orderBy('id', 'DESC')->where('vehicles.user_id', $id)->get();
        return view('front.travelagent.agency-car-info', ['carInfo' => $carInfo, 'vehicleType' => $vehicleType, 'agencyCarHistory' => $agencyCarHistory]);
    }

    /**
     * Store Agency Drivers Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addAgencyDriverInfo(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::create([
            'mobile' => $request->mobile,
            'role' => $request->role,
            'password' => Hash::make('Driver@123'),
            'mobile_verify_status' =>'1',
        ]);
        if ($user->role == 1) {
            $agent = travel_agent::where('user_id', $id)->first();
            $driver = new driver();
            $driver->user_id = $user->id;
            $driver->travel_agent_id = $agent->id;
            $driver->name = $request->name;
            $driver->gender = $request->gender;
            $driver->age = $request->age;
            $driver->dob = "2021/11/1";
            $driver->license_number = strtoupper($request->license_number);
            $driver->save();
            Session()->flash('save', 'You have successful registered');
            return redirect('agency-driver-info');
        }
    }

    /**
     * Show Agency Drivers Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showAgencyDriverHistory(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $agencydriver = User::leftJoin('drivers as two', function ($join) {
            $join->on('users.id', '=', 'two.user_id');
        })
            ->select([
                'users.*',
                'two.*'
            ])->where('role', '!=', 0)->where('drivers.user_id', $id)->orderBy('name', 'ASC')->get();

        return view('front.travelagent.agency-driver-history', compact('agencydriver'));
    }

    /**
     * Show the form for editing the travel agent data.
     *
     * @param  \App\Models\travel_agent  $travel_agent
     * @return \Illuminate\Http\Response
     */
    public function EditTravelProfile(travel_agent $travel_agent)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $travel = travel_agent::where('user_id', $id)->first();
        return view('front.edit-travel', ['travel' => $travel, 'user' => $user]);
    }

    /**
     * View Car Information.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function viewAgencyCarHistory()
    {

        $carInfo = vehicle::leftJoin('vehicle_types as two', function ($join) {
            $join->on('vehicles.vehicle_type', '=', 'two.id');
        })->leftJoin('vehicle_types as one', function ($join) {
            $join->on('vehicles.capacity', '=', 'one.id');
        })
            ->select([
                'vehicles.*',
                'two.vehicle_name as vehicle_name',
                'one.seat_capacity as seat_capacity'
            ])->get();


        return view("front.travelagent.agency-car-history", compact('carInfo'));
    }

    /**
     * Update the travel agent data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\travel_agent  $travel_agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, travel_agent $travel_agent)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $vehicleCount = vehicle::where('user_id',$id)->count();
        if($vehicleCount > $request->number_of_vehicles )
        {
            Session()->flash('error', 'You can’t edit below your total addded vehicles');
            return redirect()->back();
        }
        if( $user->mobile != $request->mobile)
        {
            Session()->flash('error', 'You can’t edit mobile number, for more please contact support');
            return redirect()->back();
        }
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->update();

        $travel = travel_agent::where('user_id', $id)->first();
        if( $travel->registration_number != $request->registration_number)
        {
            Session()->flash('error', 'You can’t edit license number, for more please contact support');
            return redirect()->back();
        }
        $travel->agency_name = $request->agency_name;
        $travel->registration_number = $request->registration_number;
        $travel->number_of_vehicles = $request->number_of_vehicles;
        $travel->update();
        Session()->flash('update', 'Data updated successfully ');
        return redirect()->route('home');
    }

    /**
     * Show book my availability.
     *
     * @return \Illuminate\Http\Response
     */
    public function bookMyAvailability()
    {

        $id = Auth::user();

        $booking = BookingAvailabilty::join('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->leftJoin('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->leftJoin('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->join('drivers as three', function ($join) {
            $join->on('booking_availabilties.driver_id', '=', 'three.id');
        })->join('users as driverMobile', function ($join) {
            $join->on('three.user_id', '=', 'driverMobile.id');
        })->select([
            'booking_availabilties.*',
            'driverMobile.mobile as usermobile',
            'three.name as drivername',
            'one.location as startLocation',
            'two.location as endLocation',
        ])->where('booking_availabilties.user_id', $id->id)->where('booking_availabilties.booking_confirm_status',"!=","1")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))->orderby('booking_availabilties.id','DESC')->get();

        $travelAgent = travel_agent::where('user_id', Auth::id())->first();
        $driver = driver::where('travel_agent_id', $travelAgent->id)->get();
        $vehicle = vehicle::leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->leftJoin('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('vehicles.user_id', Auth::user()->id)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName','vehicles.vehicle_registration_number')->orderBy('vehicle_name')->get();

        return view('front.travelagent.travel-agency-availability-booking', ['vehicle' => $vehicle, 'driver' => $driver, 'booking' => $booking,'agencyId'=>$id]);
    }


       /**
     * Show book my availability.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchBookMyAvailability(Request  $request)
    {

        $id = Auth::user()->id;
        $search = $request->input('search');
        $booking = BookingAvailabilty::join('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->leftJoin('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->leftJoin('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->join('drivers as three', function ($join) {
            $join->on('booking_availabilties.driver_id', '=', 'three.id');
        })->join('users as driverMobile', function ($join) {
            $join->on('three.user_id', '=', 'driverMobile.id');
        })
            ->select([
                'booking_availabilties.*',
                'driverMobile.mobile as usermobile',
                'three.name as drivername',
                'one.location as startLocation',
                'two.location as endLocation',
            ])->where('booking_availabilties.user_id', $id)->where('booking_availabilties.booking_confirm_status',"!=","1")->where('driverMobile.mobile', 'LIKE', "%{$search}%")->get();


        $travelAgent = travel_agent::where('user_id', Auth::id())->first();
        $driver = driver::where('travel_agent_id', $travelAgent->id)->get();
        $vehicle = vehicle::leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->leftJoin('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('vehicles.user_id', Auth::user()->id)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName')->orderBy('vehicle_name')->get();

        return view('front.travelagent.search-travel-agency-availability-booking', ['vehicle' => $vehicle, 'driver' => $driver, 'booking' => $booking]);
    }


    /**
     * Auto Search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchLocation(Request $request)
    {
        $startLocationId = location::where("location",$request->startLocationName)->pluck("id")->first();
        if (!empty($request->startLocationId)) {

            $res = location::select("location", "id")
                ->where("location", "LIKE", "%{$request->term}%")
                ->where('id', '!=', $startLocationId)
                ->get();
        } else {
            $res = location::select("location", "id")
                ->where("location", "LIKE", "%{$request->term}%")
                ->get();
        }
        return response()->json($res);
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
     * insert Booking details.
     *
     * @return \Illuminate\Http\Response
     */
    public function addBooking(Request $request)
    {
        try {
            $request->validate([
                'vehicle_type' => ['required'],
            ]);
            $id = $request->driverUserId;
            if (Auth::User()->status == 0) {
                $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
                $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
                $vehicleId = vehicle::where('id',$request->vehicle_type)->first();
                $driver = driver::where('user_id', $id)->first();

                 // check car or driver allocated or not 
                 $startDate = date('Y-m-d H:i',strtotime($request->start_time));
                 $endDate = date('Y-m-d H:i',strtotime($request->end_time));
                 $agentId = Auth::user()->id;
                 // DB::enableQueryLog();
 
                 $selectDriverInDate = DB::select("SELECT start_time, end_time FROM booking_availabilties WHERE user_id = '$agentId' AND driver_id = '$driver->id' AND ('$startDate' between start_time and end_time OR '$endDate' between start_time and end_time OR (start_time >= '$startDate' AND end_time <= '$endDate')) AND (start_time <= '$startDate' OR end_time >= '$endDate' OR start_time <= '$endDate') ");
 
                $selectVehicleInDate = DB::select("SELECT start_time, end_time FROM booking_availabilties WHERE user_id = '$agentId' AND vehicle_id= '$request->vehicle_type' AND ('$startDate' between start_time and end_time OR '$endDate' between start_time and end_time OR (start_time >= '$startDate' AND end_time <= '$endDate')) AND (start_time <= '$startDate' OR end_time >= '$endDate' OR start_time <= '$endDate') ");

                if(!empty($selectDriverInDate)){
                    Session()->flash('block', 'Driver already booked at given date & time, please select different driver');
                    return redirect()->back();
                }
                elseif(!empty($selectVehicleInDate)){
                    Session()->flash('block', 'Vehicle already booked at given date & time, please select different vehicle');
                   return redirect()->back();
                }
                else{
                    $booking = new BookingAvailabilty();
                    $booking->user_id = Auth::user()->id;
                    $booking->driver_id = $driver->id;
                    $booking->start_location_id = $startLocationId;
                    $booking->start_time = date('Y-m-d H:i',strtotime($request->start_time));
                    $booking->end_time = date('Y-m-d H:i',strtotime($request->end_time));
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
                    return redirect('travel-agency-availability-booking');
                }
            } else {
                Session()->flash('block', 'Your account is temporary blocked. Please contact support to resolve this issue. ');
                return redirect()->back();
            }
        } catch (\Exception $e) {

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
     * show Booking availability details.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBookMyAvailability(Request $request)
    {

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

            ])->where('booking_availabilties.user_id', $id)->get();

        $travelAgent = travel_agent::where('user_id', Auth::id())->first();
        $driver = driver::where('travel_agent_id', $travelAgent->id)->get();
        $vehicle = vehicle::leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->join('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('users.id', Auth::user()->id)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName','vehicles.vehicle_registration_number')->orderBy('vehicle_name')->get();

        return view('front.travelagent.agency-booking-history', ['vehicle' => $vehicle, 'driver' => $driver, 'booking' => $booking]);
    }

    /**
     * Edit vehicle data.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $vehicle = vehicle::where(['id' => $id])->first();
        $vehicleType = VehicleType::all();
        return view('front.travelagent.edit-agency-car-info', ['vehicleType' => $vehicleType, 'vehicle' => $vehicle,'id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @para0m  \Illuminate\Http\Request  $request
     * @param  \App\Modelrs\user  $user
     * @return \Illuminate\Http\Response
     */
    public function vehicleUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $driver = vehicle::where('id', $request->vehicleId)->first();
        $driver->vehicle_type_id = $request->vehicle_name;
        $driver->vehicle_registration_number = strtoupper($request->vehicle_registration_number);
        $driver->rate_per_km = $request->rate_per_km;
        $driver->capacity = $request->capacity;
        $driver->update();

        Session()->flash('update', 'Your vehicle info updated successfully ');
        return redirect("agency-car-info");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\travel_agent  $travel_agent
     * @return \Illuminate\Http\Response
     */
    public function delete(travel_agent $travel_agent, $id)
    {

        $agencyDelete = vehicle::where("id", $id);
        $agencyDelete->delete();
        Session()->flash('delete', 'Your data deleted successfully ');
        return redirect()->back();
    }

    /**
     * Remove the Driver.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function driverDelete(Request $request, $id)
    {
        try {
            $driverDelete = User::where("id", $id)->first();
            $driver = driver::where("user_id",$driverDelete->id)->first();
            $bookMyAvailability = BookingAvailabilty::where("driver_id", $driver->id)->get();
           
            if(count($bookMyAvailability) > 0)
            {
                foreach($bookMyAvailability as $requestBookingDelete)
                {
                    $bookRequestDelete = booking_request::where('booking_availability_id',$requestBookingDelete->id)->get();
                    if(count($bookRequestDelete) > 0)
                    {
                        foreach($bookRequestDelete as $requestDelete)
                        {
                            $requestDelete -> delete();
                        }
                    }
                    $requestBookingDelete -> delete();
                }
            }
            $driverMultiData=  User::where("mobile", $driverDelete->mobile)->get(); 
            if(count($driverMultiData) > 0)
            {
                foreach($driverMultiData as $driverData)
                {
                    $driverData -> delete();
                }
            }
            else
            {
                $driverDelete->delete();
            }
            
            Session()->flash('delete', 'Your data deleted successfully ');
            return redirect()->back();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Edit driver.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function driverEdit($id)
    {
        try {
            $driver = User::select('users.*', 'drivers.age as age', 'drivers.license_number as license_number', 'drivers.name as name')
                ->join('drivers', 'users.id', '=', 'drivers.user_id')->where('users.id', $id)->first();
            return view("front.travelagent.edit-agency-driver-info", ['driver' => $driver,'id'=>$id]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * update Driver.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function driverUpdate(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $agentId= travel_agent::where('user_id',$id)->first();
            $driver = driver::where('travel_agent_id', $agentId->id)->where('user_id',$request->driverId)->first();
            $user = User::where('id',$request->driverId)->first();
            $user->mobile = $request->mobile;
            $driver->name = $request->name;
            $driver->age = $request->age;
            $driver->gender = $request->gender;
            $driver->license_number = strtoupper($request->license_number);
            $driver->update();
            $user->update();
            Session()->flash('update', 'Driver  Data Updated Successfully ');
            return redirect("agency-driver-info");
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Search vehicle data.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $id = Auth::user()->id;
        $search = $request->input('search');
        $searchs = vehicle::leftJoin('vehicle_types as two', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'two.id');
        })
            ->select([
                'vehicles.*',
                'two.vehicle_name'
            ])->where('vehicle_registration_number', 'LIKE', "%{$search}%")
            ->where('vehicles.user_id', $id)->get();

        return view('front.travelagent.search-agency-car-info', compact('searchs'));
    }

    /**
     * Search driver data.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function searchAgencyDriver(Request $request)
    {
        $id = Auth::user()->id;
        $search = $request->input('search');
        $agencyId = travel_agent::where('user_id', $id)->first();
        $searchs = driver::join('users', function ($join) {
            $join->on('drivers.user_id', '=', 'users.id');
        })->where('travel_agent_id', $agencyId->id)
          ->Where('drivers.license_number', 'LIKE', "%{$search}%")
          ->orderBy('name', 'ASC')->get();

        return view('front.travelagent.search-agency-driver-info', compact('searchs'));
    }

    /**
     * Delete Agency Booking Availability.
     *
     * @param  \App\Models\travel_agent  $travel_agent
     * @return \Illuminate\Http\Response
     */
    public function deleteAgencyBookAvailability(Request $request, $id)
    {
        try {
            $bookMyAvailability = BookingAvailabilty::where("id", $id);
            $bookMyAvailability->delete();
            Session()->flash('delete', 'Your  Data Deleted Successfully ');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }

    /**
     * Edit Agency Booking Availability.
     *
     * @param  \App\Models\travel_agent  $travel_agent
     * @return \Illuminate\Http\Response
     */
    public function editAgencyBookAvailability(Request $request, $id)
    {

        try {
            $bookingId =$id;
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
            })
                ->select([
                    'booking_availabilties.*',
                    'one.location as startLocation',
                    'two.location as endLocation',

                ])->where("booking_availabilties.id", $id)->first();
            $travelAgent = travel_agent::where('user_id', Auth::id())->first();
            $driver = driver::where('travel_agent_id', $travelAgent->id)->get();

            $vehicle = vehicle::leftJoin('users', function ($join) {
                $join->on('vehicles.user_id', '=', 'users.id');
            })->join('vehicle_types', function ($join) {
                $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
            })->where('users.id', Auth::user()->id)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName')->get();

            return view('front.travelagent.edit-travel-agency-availability-booking', ['bookingId'=>$bookingId,'vehicle' => $vehicle, 'booking' => $booking, 'driver' => $driver]);
        } catch (\Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }

    /**
     * Update Agency Booking Availability.
     *
     * @param  \App\Models\travel_agent  $travel_agent
     * @return \Illuminate\Http\Response
     */
    public function updateAgencyBookAvailability(Request $request)
    {
        try {
            $request->validate([
                'vehicle_type' => ['required'],
            ]);
            $id = $request->driverUserId;

            $user = User::create([

                'mobile' => $request->mobile,
                'password' => Hash::make('Driver@123'),
                'role' => $request->role,

            ]);
            $driver = driver::where('user_id', $id)->first();
            $booking = BookingAvailabilty::where('id',$request->bookingId)->first();
            $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
            $bookingId= $request->bookingId;
            $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
            $vehicleId = vehicle::where('id',$request->vehicle_type)->first();

            $startDate = date('Y-m-d H:i',strtotime($request->start_time));
            $endDate = date('Y-m-d H:i',strtotime($request->end_time));
            $agentId = Auth::user()->id;
            if($startDate == $booking->start_time && $endDate == $booking->end_time && $booking->vehicle_id == $request->vehicle_type && $driver->user_id==$request->driverUserId)
            {
                $booking->driver_id = $driver->id;
                $booking->start_location_id = $startLocationId;
                $booking->start_time = date('Y-m-d H:i',strtotime($request->start_time));
                $booking->end_time = date('Y-m-d H:i',strtotime($request->end_time));
                $booking->end_location_id = $endLocationId;
                $booking->vehicle_id = $request->vehicle_type;
                $calculateDistance = $this->calculateDistanceByLocation($startLocationId,$endLocationId);
                $distanceKm = $calculateDistance['0']->distance_in_km;
                $booking->distance = round($distanceKm);
                $price = round($distanceKm) * $vehicleId->rate_per_km ;
                $priceCommission = $price * 25/100;
                $finalPrice = $price + round($priceCommission);
                $booking -> distance_price = $finalPrice;
                $booking->update();

                Session()->flash('update', 'You have successfully updated availability booking');
                return redirect('travel-agency-availability-booking');
            }
            else
            {
                $selectDriverInDate = DB::select("SELECT start_time, end_time FROM booking_availabilties WHERE user_id = '$agentId' AND driver_id = '$driver->id' AND ('$startDate' between start_time and end_time OR '$endDate' between start_time and end_time OR (start_time >= '$startDate' AND end_time <= '$endDate')) AND (start_time <= '$startDate' OR end_time >= '$endDate' OR start_time <= '$endDate') AND (id != '$bookingId')");

                $selectVehicleInDate = DB::select("SELECT start_time, end_time FROM booking_availabilties WHERE user_id = '$agentId' AND vehicle_id= '$request->vehicle_type' AND ('$startDate' between start_time and end_time OR '$endDate' between start_time and end_time OR (start_time >= '$startDate' AND end_time <= '$endDate')) AND (start_time <= '$startDate' OR end_time >= '$endDate' OR start_time <= '$endDate') AND (id != '$bookingId')");
     
                if(!empty($selectDriverInDate)){
                     Session()->flash('block', 'Driver already booked at given date & time, please select different driver');
                     return redirect()->back();
                }
                elseif(!empty($selectVehicleInDate)){
                     Session()->flash('block', 'Vehicle already booked at given date & time, please select different Vehicle');
                     return redirect()->back();
                }
                else
                {
                     $booking->driver_id = $driver->id;
                     $booking->start_location_id = $startLocationId;
                     $booking->start_time = date('Y-m-d H:i',strtotime($request->start_time));
                     $booking->end_time =date('Y-m-d H:i',strtotime($request->end_time));
                     $booking->end_location_id = $endLocationId;
                     $booking->vehicle_id = $request->vehicle_type;
                     $calculateDistance = $this->calculateDistanceByLocation($startLocationId,$endLocationId);
                     $distanceKm = $calculateDistance['0']->distance_in_km;
                     $booking->distance = round($distanceKm);
                     $price = round($distanceKm) * $vehicleId->rate_per_km ;
                     $priceCommission = $price * 25/100;
                     $finalPrice = $price + round($priceCommission);
                     $booking -> distance_price = $finalPrice;
                     $booking->update();
     
                     Session()->flash('update', 'You have successfully updated availability booking');
                     return redirect('travel-agency-availability-booking');
                }
            }

           
        } catch (\Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }

    
    /**
     * Show Agency's Driver Booking History.
     *
     * @param  \App\Models\travel_agent 
     * @return \Illuminate\Http\Response
     */

    public function travelAgencyBookingHistory() 
    {
        try {
            $id = Auth::user()->id;
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
                'booking_availabilties.vehicle_id as vehicleId',
                'booking_availabilties.start_time as bookingDate',
            ])->where('booking_requests.status','!=', "0")->orderBy('booking_requests.id', 'DESC')->where('booking_availabilties.user_id', $id)->get();
            $bookingInfo = [];
            foreach ($booking as $bookingRequest) {
                $vehicle = vehicle::where('id', $bookingRequest->vehicleId)->first();
                $travelAgent = travel_agent::where('user_id', Auth::user()->id) ->first();
                if($travelAgent != "")
                {
                    $driver = driver::Join('users', function ($join) {
                        $join->on('users.id', '=', 'drivers.user_id');
                    })->select([
                        'users.mobile',
                        'drivers.*'
                    ])->where('drivers.id', $bookingRequest->driverId)
                        ->where('drivers.travel_agent_id', $travelAgent->id)
                        ->first();
                    if ($driver != "") {
                        $bookingData['id'] = $bookingRequest->id;
                        $bookingData['customer_name'] = $bookingRequest->customer_name;
                        $bookingData['customer_mobile_number'] = $bookingRequest->customer_mobile_number;
                        $bookingData['endLocation'] = $bookingRequest->endLocation;
                        $bookingData['startLocation'] = $bookingRequest->startLocation;
                        $bookingData['price'] = $bookingRequest->price;
                        $bookingData['payment_option'] = $bookingRequest->payment_option;
                        $bookingData['status'] = $bookingRequest->status;
                        $bookingData['bookingDate'] = $bookingRequest->bookingDate;
                        $bookingData['vehicle_number'] = $vehicle->vehicle_registration_number;
                        $bookingData['vehicle_type_id'] = $vehicle->vehicle_type_id;
                        $bookingData['driverName'] = $driver->name;
                        $bookingData['driverMobile'] = $driver->mobile;
                        array_push($bookingInfo, $bookingData);
                    }
                }
            }
            // dd($bookingInfo);
            return view('front.travelagent.travel-agency-booking-history',compact('bookingInfo'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }    

     /**
     * Show Agency's Driver Booking History.
     *
     * @param  \App\Models\travel_agent 
     * @return \Illuminate\Http\Response
     */

    public function searchAgencyBookingHistory(Request $request) 
    {
        try {
            $search = $request->search;
            $id = Auth::user()->id;
            $booking = booking_request::Join('locations as two', function ($join) {
                $join->on('booking_requests.booking_start_location_id', '=', 'two.id');
            })->Join('locations as one', function ($join) {
                $join->on('booking_requests.booking_end_location_id', '=', 'one.id');
            })->Join('booking_availabilties', function ($join) {
                $join->on('booking_requests.booking_availability_id', '=', 'booking_availabilties.id');
            })->Join('drivers', function ($join) {
                $join->on('drivers.id', '=', 'booking_availabilties.driver_id');
            })->Join('users', function ($join) {
                $join->on('users.id', '=', 'drivers.user_id');
            })->select([
                'booking_requests.*',
                'two.location as startLocation',
                'one.location as endLocation',
                'booking_availabilties.driver_id as driverId',
                'booking_availabilties.vehicle_id as vehicleId',
                'booking_availabilties.start_time as bookingDate',
                'users.mobile'
            ])->orderBy('booking_requests.id', 'DESC')->where('booking_availabilties.user_id', $id)->where('booking_requests.status','!=', "0")->where('users.mobile', 'LIKE', "%{$search}%")->get();
            $bookingInfo = [];
            foreach ($booking as $bookingRequest) {
                $vehicle = vehicle::where('id', $bookingRequest->vehicleId)->first();
                $travelAgent = travel_agent::where('user_id', Auth::user()->id) ->first();
                if($travelAgent != "")
                {
                    $driver = driver::Join('users', function ($join) {
                        $join->on('users.id', '=', 'drivers.user_id');
                    })->select([
                        'users.mobile',
                        'drivers.*'
                    ])->where('drivers.id', $bookingRequest->driverId)
                        ->where('drivers.travel_agent_id', $travelAgent->id)
                        ->first();
                    if ($driver != "") {
                        $bookingData['id'] = $bookingRequest->id;
                        $bookingData['customer_name'] = $bookingRequest->customer_name;
                        $bookingData['customer_mobile_number'] = $bookingRequest->customer_mobile_number;
                        $bookingData['endLocation'] = $bookingRequest->endLocation;
                        $bookingData['startLocation'] = $bookingRequest->startLocation;
                        $bookingData['price'] = $bookingRequest->price;
                        $bookingData['payment_option'] = $bookingRequest->payment_option;
                        $bookingData['status'] = $bookingRequest->status;
                        $bookingData['bookingDate'] = $bookingRequest->bookingDate;
                        $bookingData['vehicle_number'] = $vehicle->vehicle_registration_number;
                        $bookingData['vehicle_type_id'] = $vehicle->vehicle_type_id;
                        $bookingData['driverName'] = $driver->name;
                        $bookingData['driverMobile'] = $driver->mobile;
                        array_push($bookingInfo, $bookingData);
                    }
                }
            }
            // dd($bookingInfo);
            return view('front.travelagent.travel-agency-booking-history',compact('bookingInfo'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }    
}
