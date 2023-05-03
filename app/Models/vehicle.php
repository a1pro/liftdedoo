<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    use HasFactory;
    
    protected $table = 'vehicles';
    
     public function drivers()
    {
        return $this->belongsToMany(driver::class,'user_id');
    }
    
     public function userid()
    {
      return $this->belongsTo(User::class,'user_id','id');
    }

    public function vehicleTypeName()
    {
       return $this->belongsTo('App\Models\VehicleType', 'vehicle_name'); 
          // return $this->belongsTo('App\Models\VehicleType', 'vehicle_type');
    }
    public function vehicleTypeCapacity()
    {
         return $this->belongsTo('App\Models\VehicleType', 'seat_capacity');
         
            // return $this->belongsTo('App\Models\VehicleType', 'capacity');
    }

}
