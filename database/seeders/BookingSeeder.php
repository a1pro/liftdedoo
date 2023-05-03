<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Booking\BookingAvailabilty;
use Illuminate\Database\Seeder;
class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $book = BookingAvailabilty::find(1);
        if (!$book) {
            $book = new BookingAvailabilty();
            $book->id = "1";
        }
        $book->user_id="2";
        $book->start_location_id = "1";
        $book->start_time = "6";
        $book->end_time = "6";
        $book->end_location_id = "2";
        $book->date_of_booking = "2021-10-31";
        $book->price="123";
        $book->save();

        $book = BookingAvailabilty::find(2);
        if (!$book) {
            $book = new BookingAvailabilty();
            $book->id = "2";
        }
        $book->user_id="2";
        $book->start_location_id = "2";
        $book->start_time = "7";
        $book->end_time = "7";
        $book->end_location_id = "1";
        $book->date_of_booking = "2021-10-29";
        $book->price="123";
        $book->save();
    }
}
