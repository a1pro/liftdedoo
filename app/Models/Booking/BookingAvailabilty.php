<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAvailabilty extends Model
{
    use HasFactory;
    protected $table = 'booking_availabilties';

    public static function deleteBoking($id)
    {
        return BookingAvailabilty::where("id",$id)->delete();
    }
    public static function dateFormat($date)
    {
            $date=date_create($date);
            $format = date_format($date,"d F,l , H:i");
            return $format;

    }
}
