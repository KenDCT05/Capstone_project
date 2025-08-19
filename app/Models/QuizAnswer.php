<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $fillable = ['attempt_id','question_id','option_id','is_correct','awarded_points'];

    public function attempt(){ return $this->belongsTo(QuizAttempt::class, 'attempt_id'); }
    public function question(){ return $this->belongsTo(QuizQuestion::class); }
    public function option(){ return $this->belongsTo(QuizOption::class); }
}
