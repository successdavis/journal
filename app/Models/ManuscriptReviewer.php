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

    public function manuscript()
    {
        return $this->belongsTo(Author::class, 'manuscript_id');
    }


    public function reviewedManuscripts()
    {
        return $this->belongsToMany(Author::class, 'manuscript_reviewers', 'reviewer_id', 'manuscript_id')
            ->withPivot(['request_status', 'status', 'complete_reviewed_on'])
            ->withTimestamps();
    }

    protected $fillable = [
        'manuscript_id',
        'reviewer_id',
        'request_status',
        'complete_reviewed_on',
        'status',
    ];
}
