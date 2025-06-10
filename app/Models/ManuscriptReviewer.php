<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptReviewer extends Model
{
    /** @use HasFactory<\Database\Factories\ManuscriptReviewerFactory> */
    use HasFactory;


    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }


    protected $fillable = [
        'manuscript_id',
        'reviewer_id',
        'request_status',
        'complete_reviewed_on',
        'status',
    ];
}
