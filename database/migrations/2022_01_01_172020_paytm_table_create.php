<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaytmTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('paytm')) {
            Schema::create('paytm', function (Blueprint $table) {
                $table->id();
                $table->string('paytm_environment')->nullable();
                $table->string('paytm_merchant_id')->nullable();
                $table->string('paytm_merchant_key')->nullable();
                $table->string('paytm_merchant_website')->nullable();
                $table->string('paytm_channel')->nullable();
                $table->string('paytm_industry_type')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paytm');
    }
}
