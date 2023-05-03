<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SearchUser extends Model
{
    use HasFactory;

    public function setSearchDateAttribute($value)
    {
        $this->attributes['search_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getSearchDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
