<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $fillable = [
        'attempt_id', 'question_id', 'option_id', 'text_answer', 
        'is_correct', 'awarded_points'
    ];

    public function attempt() { return $this->belongsTo(QuizAttempt::class, 'attempt_id'); }
    public function question() { return $this->belongsTo(QuizQuestion::class); }
    public function option() { return $this->belongsTo(QuizOption::class); }

    /**
     * Get the student's answer in a readable format
     */
    public function getAnswerText()
    {
        if ($this->question->isFillInBlank()) {
            return $this->text_answer ?? 'No answer';
        }
        
        return $this->option ? $this->option->option_text : 'No answer';
    }

    /**
     * Get the correct answer for this question
     */
    public function getCorrectAnswerText()
    {
        if ($this->question->isFillInBlank()) {
            return $this->question->correct_answer;
        }
        
        $correctOption = $this->question->getCorrectOption();
        return $correctOption ? $correctOption->option_text : 'No correct answer set';
    }
}