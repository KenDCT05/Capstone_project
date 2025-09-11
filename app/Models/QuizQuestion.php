<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_id', 'question_type', 'question_text', 'correct_answer', 
        'case_sensitive', 'allow_partial_match', 'points', 
        'time_limit_seconds', 'display_order'
    ];

    protected $casts = [
        'case_sensitive' => 'boolean',
        'allow_partial_match' => 'boolean',
    ];

    public function quiz() { return $this->belongsTo(Quiz::class); }
    public function options() { return $this->hasMany(QuizOption::class,'question_id')->orderBy('display_order'); }
    public function acceptableAnswers() { return $this->hasMany(QuizQuestionAnswer::class,'question_id'); }

    // Helper methods for different question types
    public function isMCQ() { return $this->question_type === 'mcq'; }
    public function isTrueFalse() { return $this->question_type === 'tf'; }
    public function isFillInBlank() { return $this->question_type === 'fib'; }

    /**
     * Check if a text answer is correct for fill-in-the-blank questions
     */
    public function checkTextAnswer($studentAnswer)
    {
        if (!$this->isFillInBlank()) {
            return false;
        }

        $studentAnswer = trim($studentAnswer);
        
        // Get all acceptable answers (primary + alternatives)
        $correctAnswers = [$this->correct_answer];
        if ($this->acceptableAnswers()->exists()) {
            $correctAnswers = array_merge($correctAnswers, 
                $this->acceptableAnswers()->pluck('answer_text')->toArray()
            );
        }

        foreach ($correctAnswers as $correctAnswer) {
            $correctAnswer = trim($correctAnswer);
            
            if ($this->case_sensitive) {
                if ($this->allow_partial_match) {
                    // Case sensitive partial match
                    if (stripos($correctAnswer, $studentAnswer) !== false || 
                        stripos($studentAnswer, $correctAnswer) !== false ||
                        $this->calculateSimilarity($studentAnswer, $correctAnswer) >= 0.8) {
                        return true;
                    }
                } else {
                    // Exact case sensitive match
                    if ($studentAnswer === $correctAnswer) {
                        return true;
                    }
                }
            } else {
                if ($this->allow_partial_match) {
                    // Case insensitive partial match
                    if (stripos($correctAnswer, $studentAnswer) !== false || 
                        stripos($studentAnswer, $correctAnswer) !== false ||
                        $this->calculateSimilarity(strtolower($studentAnswer), strtolower($correctAnswer)) >= 0.8) {
                        return true;
                    }
                } else {
                    // Case insensitive exact match
                    if (strtolower($studentAnswer) === strtolower($correctAnswer)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Calculate similarity between two strings using Levenshtein distance
     */
    private function calculateSimilarity($str1, $str2)
    {
        $maxLen = max(strlen($str1), strlen($str2));
        if ($maxLen == 0) return 1;
        
        $distance = levenshtein($str1, $str2);
        return 1 - ($distance / $maxLen);
    }

    /**
     * Get the correct option for MCQ/TF questions
     */
    public function getCorrectOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }

    /**
     * Get question type label
     */
    public function getQuestionTypeLabel()
    {
        return match($this->question_type) {
            'mcq' => 'Multiple Choice',
            'tf' => 'True/False',
            'fib' => 'Fill in the Blank',
            default => 'Unknown'
        };
    }
}