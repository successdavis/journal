<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorDecision extends Model
{
    /** @use HasFactory<\Database\Factories\EditorDecisionFactory> */
    use HasFactory;


    public function editor(){
        return $this->belongsTo(User::class, 'editor_id');
    }
    public function manuscript(){
        $this->belongsTo(Publication::class, 'manuscript_id');
    }

    protected $fillable = [
        'manuscript_id',
        'submitted_review_id',
        'round',
        'decision',
        'comments_to_author',
        'comments_to_reviewer',
        'editor_id',
    ];
}
