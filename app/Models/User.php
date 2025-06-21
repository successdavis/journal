<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public function publications() {
        return $this->hasMany(Publication::class, 'author_id');
    }

    public function manuscripts()
    {
        return $this->belongsToMany(Publication::class, 'manuscript_reviewer');
    }

    public function reviewedManuscripts()
    {
        return $this->belongsToMany(Publication::class, 'manuscript_reviewers', 'reviewer_id', 'manuscript_id')
            ->withPivot(['request_status', 'status', 'complete_reviewed_on'])
            ->withTimestamps();
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
