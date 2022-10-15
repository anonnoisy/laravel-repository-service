<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'birth_date',
        'education_id',
        'applied_position_id',
        'last_position_id',
        'experience',
        'resume_url',
    ];

    /**
     * Get the education that owns the candidate.
     */
    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    /**
     * Get the last position that owns the candidate.
     */
    public function last_position()
    {
        return $this->belongsTo(Position::class, 'last_position_id');
    }

    /**
     * Get the applied position that owns the candidate.
     */
    public function applied_position()
    {
        return $this->belongsTo(Position::class, 'applied_position_id');
    }

    /**
     * Get all of the skills for the candidate.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    /**
     * Get all of the resume files for the candidate.
     */
    public function resume_files()
    {
        return $this->belongsToMany(CandidateFile::class);
    }
}
