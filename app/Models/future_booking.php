<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use model;
class future_booking extends Model
{
    use HasFactory;
    protected $table = 'future_booking';
    public static function addFiveDigitNo($id)
    {
        $idLength = strlen($id);
        if($idLength == "1")
        {
            return "0000".$id;
        }
        elseif($idLength == "2")
        {
            return "000".$id;
        }
        elseif($idLength == "3")
        {
            return "00".$id;
        }
        elseif($idLength == "4")
        {
            return "0".$id;
        }
        else
        {
            return $id;
        }
    }
    public static function FetchOrignalDigitNo($id)
    {
        $originalId = ltrim($id, '0');
        return $originalId;
    }
}
