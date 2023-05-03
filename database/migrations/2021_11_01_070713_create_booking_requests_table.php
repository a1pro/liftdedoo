<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_availability_id');
            $table->foreign('booking_availability_id')->references('id')->on('booking_availabilties')->onUpdate('restrict')->onDelete('restrict');
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile_number');
            $table->tinyInteger('customer_mobile_verified')->default(0);

            $table->unsignedBigInteger('booking_start_location_id');
            $table->foreign('booking_start_location_id')->references('id')->on('locations')->onUpdate('restrict')->onDelete('restrict');
            $table->unsignedBigInteger('booking_end_location_id');
            $table->foreign('booking_end_location_id')->references('id')->on('locations')->onUpdate('restrict')->onDelete('restrict');
            $table->tinyInteger('payment_option')->nullable();
            $table->decimal('payment_amount',8,2)->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->integer('distance_in_km')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_requests');
    }
}
