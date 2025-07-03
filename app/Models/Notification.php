<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    public function notifiable()
    {
        return $this->morphTo();
    }

    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'receiver_id',
        'sender_id',
        'message',
        'status',
    ];
}
