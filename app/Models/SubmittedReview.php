<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedReview extends Model
{
    /** @use HasFactory<\Database\Factories\SubmittedReviewFactory> */
    use HasFactory;

    public function reviewManuscript()
    {
        return $this->belongsTo(ManuscriptReviewer::class, 'review_manuscript_id');
    }

    protected $fillable = [
        'review_manuscript_id',
        'round',
        'review_title',
        'opinion',
        'general_comment',
        'specific_comment',
        'comment_to_editor',
        'originality',
        'clarity_of_writing',
        'methodology_soundness',
        'relevance_of_manuscript',
        'quality_of_data',
        'annotated_manuscript',
        'supplementary_feedback',
        'conflict_of_interest',
        'review_is_honest',
        'agreed_review_policy',
        'submit_option',
    ];


}
