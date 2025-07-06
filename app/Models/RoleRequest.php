<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleRequest extends Model
{
    /** @use HasFactory<\Database\Factories\RoleRequestFactory> */
    use HasFactory;


    protected $fillable = [
        'user_id',
        'role_id',
        'status'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function role(){
        return  $this->belongsTo(Role::class);
    }





}
