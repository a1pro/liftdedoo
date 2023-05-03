<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverPolicy extends Model
{
    use HasFactory;
    protected $table = "driver_privacy_policy";
    public $timestamps = false;
}
