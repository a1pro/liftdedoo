<?php

namespace App\Http\Controllers;

use App\Models\driver;
use App\Models\User;
use App\Models\vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\booking_request;
use App\Models\Booking\BookingAvailabilty;
use App\Models\location;
use DB;
use Illuminate\Support\Carbon;


class DriverController extends Controller
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
     * Show driver car registration information.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDriverCarRegistration()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $driver = driver::where('user_id', $id)->first();
        $vehicle = vehicle::all();
        $vehicleType = VehicleType::orderBy('vehicle_name')->get();
        return view('front.driver.driver-car-registration', ['vehicleType' => $vehicleType, 'driver' => $driver, 'user' => $user, 'vehicle' => $vehicle]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDriverCarHistory()
    {
        $driverHistory = vehicle::leftJoin('vehicle_types as two', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'two.id');
        })
            ->select([
                'vehicles.*',
                'two.*'
            ])->orderBy('id', 'DESC')->get();
        $vehicle = vehicle::all();
        $vehicleType = VehicleType::all();
        return view('front.driver.driver-car-history', ['vehicleType' => $vehicleType, 'driverHistory' => $driverHistory, 'vehicle' => $vehicle]);
    }

    /**
     * Store a car Information Data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addDriverCarInfo(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $driveCar = new vehicle();
        $driveCar->user_id = $user->id;
        $driveCar->vehicle_registration_number = strtoupper($request->vehicle_registration_number);
        $driveCar->vehicle_type_id = $request->vehicle_name;
        $driveCar->rate_per_km = $request->rate_per_km;
        $driveCar->capacity = $request->capacity;
        $driveCar->save();
        Session()->flash('save', 'You have successfully added your vehicle');
        return redirect('driver-car-info');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function showDriverCarInfo(driver $driver)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $driver = driver::where('user_id', $id)->first();
        $vehicle = vehicle::all();
        $vehicleType = VehicleType::orderBy('vehicle_name')->get();
        $driverHistory = vehicle::leftJoin('vehicle_types as two', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'two.id');
        })
            ->select([
                'vehicles.*',
                'two.vehicle_name'
            ])->orderBy('id', 'DESC')->where('vehicles.user_id', $id)->get();
        return view('front.driver.driver-car-info', ['vehicleType' => $vehicleType, 'driver' => $driver, 'user' => $user, 'vehicle' => $vehicle, 'driverHistory' => $driverHistory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function EditDriverProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $driver = driver::where('user_id', $id)->first();
        $allVehicles = VehicleType::all();
        return view('front.edit-driver', ['driver' => $driver, 'user' => $user, 'allVehicles' => $allVehicles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @para0m  \Illuminate\Http\Request  $request
     * @param  \App\Modelrs\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, driver $driver)
    {
        $dob = Carbon::createFromFormat('d/m/Y', $request->age)->format('Y-m-d');
        $id = Auth::user()->id;
        $user = User::find($id);
        if($user->mobile != $request->mobile)
        {
            Session()->flash('error', 'You can’t edit mobile number, for more please contact support');
            return redirect()->back();
        }
        $user->mobile = $request->mobile;
        $user->update();
        $driver = driver::where('user_id', $id)->first();
        $driver->name = $request->name;
        $driver->dob = $dob;
        $driver->gender = $request->gender;
        if( $driver->license_number != $request->license_number)
        {
            Session()->flash('error', 'You can’t edit license number, for more please contact support');
            return redirect()->back();
        }
        $driver->license_number = $request->license_number;
        $driver->update();
        Session()->flash('update', 'Data successfully updated');
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(driver $driver, $id)
    {
        $vehicle = vehicle::where(['id' => $id])->first();
        $vehicleType = VehicleType::all();
        return view('front.driver.edit-driver-car-info', ['driver' => $driver, 'vehicleType' => $vehicleType, 'vehicle' => $vehicle]);
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
        $driver = vehicle::where('id',$request->vehicleId)->first();
        $driver->vehicle_type_id = $request->vehicle_name;
        $driver->vehicle_registration_number = strtoupper($request->vehicle_registration_number);
        $driver->rate_per_km = $request->rate_per_km;
        $driver->capacity = $request->capacity;
        $driver->update();

        Session()->flash('update', 'Your vehicle info updated successfully');
        return redirect("driver-car-info");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function delete(driver $driver, $id)
    {
        $vehicleDelete = vehicle::where("id", $id)->first();
        $bookingVehicle = BookingAvailabilty::where('vehicle_id',$vehicleDelete->id)->get();
        if(count($bookingVehicle) > 0)
        {
            foreach($bookingVehicle as $bookingVehicleDelete)
            {
                $bookRequestDelete = booking_request::where('booking_availability_id',$bookingVehicleDelete->id)->get();
                if(count($bookRequestDelete) > 0)
                {
                    foreach($bookRequestDelete as $requestBookingDelete)
                    {
                        $requestBookingDelete -> delete();
                    }
                }
                $bookingVehicleDelete -> delete();
            }
        }
        $vehicleDelete->delete();
        Session()->flash('delete', 'Vehicle info deleted successfully ');
        return redirect()->back();
    }

    /**
     * Search table data.
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

        return view('front.driver.search-driver-car-info', compact('searchs'));
    }

    /**
     * Search table data.
     *
     *Display Driving Booking History to Driver
     *
     */

    public function driverBookingHistory()
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
                'booking_availabilties.vehicle_id as vehicleId'
            ])->where('booking_requests.status','!=', "0")->orderBy('booking_requests.id', 'DESC')->get();
            $bookingInfo = [];
            foreach ($booking as $bookingRequest) {
                $vehicle = vehicle::where('id', $bookingRequest->vehicleId)->first();
                $driver = driver::where('id', $bookingRequest->driverId)
                    ->where('user_id', Auth::user()->id)
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
                    $bookingData['vehicle_number'] = $vehicle->vehicle_registration_number;
                    $bookingData['vehicle_type_id'] = $vehicle->vehicle_type_id;

                    array_push($bookingInfo, $bookingData);
                }
            }
            return view('front.driver.driver-booking-history', compact('bookingInfo'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


     /**
     * Search table driver history.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function searchBookingHistory(Request $request)
    {
        $search = $request->search;
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
            'booking_availabilties.vehicle_id as vehicleId'
        ])->orderBy('booking_requests.id', 'DESC')->where('booking_requests.status','!=', "0")->where('customer_mobile_number', 'LIKE', "%{$search}%")->get();
        $bookingInfo = [];
        foreach ($booking as $bookingRequest) {
            $vehicle = vehicle::where('id', $bookingRequest->vehicleId)->first();
            $driver = driver::where('id', $bookingRequest->driverId)
                ->where('user_id', Auth::user()->id)
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
                $bookingData['vehicle_number'] = $vehicle->vehicle_registration_number;
                $bookingData['vehicle_type_id'] = $vehicle->vehicle_type_id;

                array_push($bookingInfo, $bookingData);
            }
        }

        return view('front.driver.driver-booking-history', compact('bookingInfo'));
    }


    /**
     * Delete Booking Availability.
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */

    public function deleteBookAvailability(Request $request, $id)
    {
        try {
            $bookMyAvailability = BookingAvailabilty::where("id", $id)->first();
            $bookRequestDelete = booking_request::where('booking_availability_id',$bookMyAvailability->id)->get();
            if(count($bookRequestDelete) > 0)
            {
                foreach($bookRequestDelete as $requestBookingDelete)
                {
                    $requestBookingDelete -> delete();
                }
            }
            $bookMyAvailability->delete();
            Session()->flash('delete', 'Your  Data Deleted Successfully ');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Edit Booking Availability.
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function editBookAvailability(Request $request, $id)
    {
        try {
            $bookingId = $id;
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

            $locations = location::all();
            $vehicle = vehicle::leftJoin('users', function ($join) {
                $join->on('vehicles.user_id', '=', 'users.id');
            })->leftJoin('vehicle_types', function ($join) {
                $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
            })->where('vehicles.user_id', Auth::user()->id)->select('vehicles.id as vehicleId', 'vehicle_types.vehicle_name as vehicleName')->get();
            $locations = location::all();

            return view('front.driver.edit-availability-booking', compact('bookingId','locations', 'vehicle', 'booking'));
        } catch (\Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }

      /**
     * Edit Booking Availability.
     *
     * @param  \App\Models\driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function updateBooking(Request $request)
    {
        try {
            $booking =  BookingAvailabilty::where('id',$request->bookingId)->first();
            $start_time =  date('Y-m-d H:i',strtotime($request->start_time));
            $end_time = date('Y-m-d H:i',strtotime($request->end_time));
            $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
            $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
            $vehicleId = vehicle::where('id',$request->vehicle_type)->first();
            $id = Auth::User()->id;

           
            $bookingId= $request->bookingId;

            $startDate = date('Y-m-d H:i',strtotime($start_time));
            $endDate = date('Y-m-d H:i',strtotime($end_time));

            if($startDate == $booking->start_time && $endDate == $booking->end_time)
            {
                $driver = driver::where('user_id', $id)->first();
                $booking =  BookingAvailabilty::where('id',$bookingId)->first();
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
                $priceCommission = $price * 25/100;
                $finalPrice = $price + round($priceCommission);
                $booking -> distance_price = $finalPrice;
                $booking->update();
                Session()->flash('update', 'Your availability booking updated successfully ');
                return redirect("driver-availability-booking");
            }
            else
            {
                $selectDriverInDate = DB::select("SELECT start_time, end_time,id FROM booking_availabilties WHERE user_id = '$id' AND ('$startDate' between start_time and end_time OR '$endDate' between start_time and end_time OR  (start_time >= '$startDate' AND end_time <= '$endDate'))  AND (start_time <= '$startDate' OR  end_time >= '$endDate' OR start_time <= '$endDate') AND (id != '$bookingId')");

                if(!empty($selectDriverInDate)){
                    Session()->flash('block', 'Driver already booked at given date & time, please select different date range');
                    return redirect()->back();
                }else
                {
                    $driver = driver::where('user_id', $id)->first();
                    $booking =  BookingAvailabilty::where('id',$bookingId)->first();
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
                    $priceCommission = $price * 25/100;
                    $finalPrice = $price + round($priceCommission);
                    $booking -> distance_price = $finalPrice;
                    $booking->update();
                    Session()->flash('update', 'Your availability booking updated successfully ');
                    return redirect("driver-availability-booking");
                }
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


     public function driverAppList()
    {
        //  die('frrfrf'); 
        // $driverdetails = driver::all();
    $driverdetails = driver::select('drivers.id as driverid','drivers.name','drivers.profile_image',
        'drivers.license_number','drivers.license_doc','drivers.state',
        'drivers.city','drivers.license_number',
        'drivers.profile_verification_status',
        'drivers.document_verification_status','users.mobile','users.id as userid')
        ->leftJoin('users','drivers.user_id','=','users.id')
        ->where('users.role','=', 1)
        ->latest('drivers.created_at')->get();

       
         return view('app-admin.drivers.driverlist',compact('driverdetails'));
    }

    // function deletedriverapp(Request $request)
    // {
    //         $did = $request->did;


    // }

    function approveprofile(Request $request)
    {
        // die('bgdt');
        $did = $request->driver_id;
        $drivers = driver::find($did);
        $drivers->profile_verification_status = 1;
       
         
        if($drivers->save())
        {
            return back();
        }

    }
    function approvedocs(Request $request)
    {
        $did = $request->driver_id;
        $drivers = driver::find($did);
        $drivers->document_verification_status = 1;
        if($drivers->save())
        {
            return back();
        }

    }
    function approvevehicle(Request $request)
    {
       // die('ggdf');
        $vid = $request->vehicle_id;
        $vehicles = vehicle::find($vid);
        $vehicles->verification_status = 1;
        if($vehicles->save())
        {
            return back();
        }

    }

    



}
