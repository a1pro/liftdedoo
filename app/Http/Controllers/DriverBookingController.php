<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\User;
use App\Models\Booking\BookingAvailabilty;

class DriverBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function view()
    {

        $users = BookingAvailabilty::leftJoin('users', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'users.id');
        })->Join('locations as two', function ($join) {
            $join->on('booking_availabilties.end_location_id', '=', 'two.id');
        })->Join('locations as one', function ($join) {
            $join->on('booking_availabilties.start_location_id', '=', 'one.id');
        })->Join('vehicles as five', function ($join) {
            $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
        })->join('drivers as three', function ($join) {
            $join->on('booking_availabilties.driver_id', '=', 'three.id');
        })->join('users as six', function ($join) {
            $join->on('booking_availabilties.user_id', '=', 'six.id');
        })->leftjoin('travel_agents as agent', function ($join) {
            $join->on('agent.user_id', '=', 'users.id');
        })
            ->select([
                'booking_availabilties.*',
                'six.role as role',
                'agent.agency_name as agencyName',
                'five.vehicle_registration_number as vehicleNumber',
                'three.name as drivername',
                'one.location as startLocation',
                'two.location as endLocation',
            ])->where('booking_availabilties.booking_confirm_status',"!=","1")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))->orderBy('id', 'DESC')->get();

        return view('admin.driver_booking.booking_available_list', compact('users'));
    }
}
