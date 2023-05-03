<?php

namespace App\Http\Controllers\API\v1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistanceCalculation
{
    public function calculateDistanceByLocation($startLocationId,$endLocationId)
    {
        $distance = DB::select("SELECT a.location AS from_city, b.location AS to_city, 111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.Latitude)) * COS(RADIANS(b.latitude)) * COS(RADIANS(a.longitude - b.longitude)) + SIN(RADIANS(a.latitude)) * SIN(RADIANS(b.latitude))))) AS distance_in_km FROM locations AS a JOIN locations AS b ON a.id <> b.id WHERE a.id = '$startLocationId' AND b.id = '$endLocationId'");       
        return $distance;
    }
}