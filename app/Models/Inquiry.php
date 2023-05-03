<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inquiry extends Model
{
    use HasFactory;

    public function setInquiryStartTimeAttribute($value)
    {
        $this->attributes['inquiry_start_time'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getInquiryStartTimeAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    public function setInquiryEndTimeAttribute($value)
    {
        $this->attributes['inquiry_end_time'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getInquiryEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
