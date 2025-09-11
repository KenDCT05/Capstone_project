<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'student_id',
        'file_name',
        'file_path',
        'original_name',
        'file_size',
        'mime_type',
        'status',
        'teacher_feedback',
        'grade',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Helper to check if submission is late
    public function isLate()
    {
        return $this->material->due_date && $this->submitted_at > $this->material->due_date;
    }
}
