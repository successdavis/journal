<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{

    protected $guarded = [];

    protected $casts = [
        'figures' => 'array',
        'supplementary' => 'array',
        'consent' => 'boolean',
        'originality' => 'boolean',
    ];

    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function review()
    {
        return $this->belongsTo(ManuscriptReviewer::class, 'review_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'publication_id');
    }


    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailPathAttribute($thumbnail)
    {
        if ($thumbnail) {
            return asset('storage/' . $thumbnail);
        }else {
            return asset('storage/thumbnails/default.png');
        }
    }

}
