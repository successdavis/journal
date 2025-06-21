<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'users');
    }

    protected $guarded = [];

    protected $casts = [
        'figures' => 'array',
        'supplementary' => 'array',
        'consent' => 'boolean',
        'originality' => 'boolean',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailPathAttribute($thumbnail)
    {
        if ($thumbnail) {
            return asset('storage/' . $thumbnail);
        }else {
            return asset('storage/covers/default.png');
        }
    }

}
