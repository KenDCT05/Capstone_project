<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['quiz_id','question_type','question_text','points','time_limit_seconds','display_order'];

    public function quiz(){ return $this->belongsTo(Quiz::class); }
    public function options(){ return $this->hasMany(QuizOption::class,'question_id')->orderBy('display_order'); }
}
