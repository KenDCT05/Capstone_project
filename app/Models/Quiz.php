<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'teacher_id','subject_id','title','type',
        'time_limit_seconds','randomize_questions','randomize_options',
        'is_published','total_points'
    ];

    public function teacher(){ return $this->belongsTo(User::class, 'teacher_id'); }
    public function subject(){ return $this->belongsTo(Subject::class); }
    public function questions(){ return $this->hasMany(QuizQuestion::class)->orderBy('display_order'); }
    public function attempts(){ return $this->hasMany(QuizAttempt::class); }
}
