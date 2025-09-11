<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'title',
        'description',
        'file_path',
        'is_activity', 
        'due_date',   
         'max_score', 
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Add relationship to submissions
    public function submissions()
    {
        return $this->hasMany(StudentSubmission::class);
    }

    // Check if student has submitted
    public function hasSubmission($studentId)
    {
        return $this->submissions()->where('student_id', $studentId)->exists();
    }

    // Get student's submission
    public function getSubmission($studentId)
    {
        return $this->submissions()->where('student_id', $studentId)->first();
    }
}

