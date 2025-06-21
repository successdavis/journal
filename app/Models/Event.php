<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;


    public function getBannerImagePathAttribute($thumbnail)
    {
        if ($thumbnail) {
            return asset('storage/' . $thumbnail);
        }else {
            return asset('storage/covers/default-event.png');
        }
    }

}
