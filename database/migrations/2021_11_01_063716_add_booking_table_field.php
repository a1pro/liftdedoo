<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingTableField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_availabilties', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->after('user_id');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('restrict')->onDelete('restrict');

            $table->unsignedBigInteger('driver_id')->after('vehicle_id');
            $table->foreign('driver_id')->references('id')->on('drivers')->onUpdate('restrict')->onDelete('restrict');

            $table->unsignedBigInteger('start_location_id')->after('driver_id');
            $table->foreign('start_location_id')->references('id')->on('locations')->onUpdate('restrict')->onDelete('restrict');

            $table->unsignedBigInteger('end_location_id')->after('start_location_id');
            $table->foreign('end_location_id')->references('id')->on('locations')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
