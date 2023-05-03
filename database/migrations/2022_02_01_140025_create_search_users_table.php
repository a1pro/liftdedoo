<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_users', function (Blueprint $table) {
            $table->id();
            $table->string('search_start_location')->nullable();
            $table->string('search_end_location')->nullable();
            $table->date('search_date')->nullable();
            $table->string('search_user_phone')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE'])->nullable()->default('ACTIVE');
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
        Schema::dropIfExists('search_users');
    }
}
