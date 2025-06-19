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



    protected $fillable = [
        'author_id', 'title', 'abstract', 'keywords', 'article_type', 'author_name', 'email',
        'affiliation', 'journal', 'subject_area', 'main_document', 'figures',
        'supplementary', 'cover_letter', 'ethical_approval', 'conflict_of_interest',
        'funding_statement', 'consent', 'originality', 'status', 'accepted_on',
    ];

    protected $casts = [
        'figures' => 'array',
        'supplementary' => 'array',
        'consent' => 'boolean',
        'originality' => 'boolean',
    ];

}
