<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'student_id',
        'score',
        'max_score',
        'started_at',
        'submitted_at',
        'question_order'
    ];

    protected $casts = [
        'question_order' => 'array',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'score' => 'integer',
        'max_score' => 'integer'
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'attempt_id');
    }

    // Accessors
    public function getActualScoreAttribute()
    {
        return $this->score ?? $this->answers()->sum('awarded_points');
    }

    public function getPercentageAttribute()
    {
        if ($this->max_score > 0) {
            return round(($this->actual_score / $this->max_score) * 100, 2);
        }
        return 0;
    }

    public function getIsCompletedAttribute()
    {
        return !is_null($this->submitted_at);
    }

    public function getDurationAttribute()
    {
        if ($this->submitted_at && $this->started_at) {
            return $this->started_at->diffInMinutes($this->submitted_at);
        }
        return null;
    }

    // Helper Methods
    public function getAnsweredQuestionsCount()
    {
        return $this->answers()->count();
    }

    public function getTotalQuestionsCount()
    {
        return count($this->question_order ?? []);
    }

    public function getCorrectAnswersCount()
    {
        return $this->answers()->where('is_correct', true)->count();
    }

    public function getIncorrectAnswersCount()
    {
        return $this->answers()->where('is_correct', false)->count();
    }

    public function getGrade()
    {
        $percentage = $this->max_score > 0 ? ($this->actual_score / $this->max_score) * 100 : 0;

        if ($percentage >= 90) return 'A';
        if ($percentage >= 75) return 'B';
        if ($percentage >= 60) return 'C';
        return 'F';
    }

    public function isPassed()
    {
        return $this->max_score > 0 && ($this->actual_score / $this->max_score * 100) >= 75;
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('submitted_at');
    }

    public function scopeInProgress($query)
    {
        return $query->whereNull('submitted_at');
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeByQuiz($query, $quizId)
    {
        return $query->where('quiz_id', $quizId);
    }
}
