<?php
namespace App;
use App\Models\booking_request;
use Illuminate\Support\Facades\DB;
 
class Helper {
    /**
     *
     * @return Integer
     */
    public static function getNewRequestCount() {
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
                'booking_availabilties.driver_id as driverId'
            ])->where('booking_requests.paytm_payment_status','!=',"")->where('booking_requests.status',"0")->orderBy('booking_requests.id','DESC')->count();
            return $booking;
    }
}