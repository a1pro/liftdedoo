<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;
    
    protected $table = 'vehicle_types';

    public function vehicles()
    {
        return $this->hasMany('App\Models\vehicle');
    }

    public static function getVehicleName($id)
    {
        $vehicleType = vehicle::find($id);
        //$vehicleTypeName = vehicle::find($vehicleType->vehicle_type_id);
        $vehicleTypeName = VehicleType::find($vehicleType->vehicle_type_id);
        return $vehicleTypeName->vehicle_name;
    }

    public static function vehicleName($id)
    {
        $vehicleTypeName = VehicleType::find($id);
        return $vehicleTypeName->vehicle_name;
    }
}
