<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVehiclesTableField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_type_id')->nullable()->after('user_id');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onUpdate('restrict')->onDelete('restrict');
            $table->string('vehicle_registration_number',100)->after('vehicle_type_id');
            $table->decimal('rate_per_km',5,2)->after('vehicle_registration_number');

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
