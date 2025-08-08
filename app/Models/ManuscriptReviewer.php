<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptReviewer extends Model
{
    /** @use HasFactory<\Database\Factories\ManuscriptReviewerFactory> */
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function manuscript()
    {
        return $this->belongsTo(Manuscript::class, 'manuscript_id');
    }
    public function decision()
    {
        return $this->belongsTo(EditorDecision::class);
    }

    public function submittedReviews()
    {
        return $this->hasMany(SubmittedReview::class);
    }

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
