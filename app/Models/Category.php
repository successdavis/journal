<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriesFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'user_id',
        'parent_id',
    ];


    public function publicationTypes()
    {
        return $this->belongsToMany(PublicationType::class);
    }
}
