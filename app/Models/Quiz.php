<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'teacher_id', 'subject_id', 'title', 'type',
        'time_limit_seconds', 'randomize_questions', 'randomize_options',
        'is_published', 'total_points',
        // NEW: Retake policy fields
        'max_attempts',
        'retake_scoring',
        'cooldown_minutes',
        'show_previous_answers',
        'require_pass_all'
    ];

    protected $casts = [
        'randomize_questions' => 'boolean',
        'randomize_options' => 'boolean',
        'is_published' => 'boolean',
        'show_previous_answers' => 'boolean',
        'require_pass_all' => 'boolean',
    ];

    // Relationships
    public function teacher() { return $this->belongsTo(User::class, 'teacher_id'); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function questions() { return $this->hasMany(QuizQuestion::class)->orderBy('display_order'); }
    public function attempts() { return $this->hasMany(QuizAttempt::class); }

    /**
     * Check if unlimited attempts are allowed
     */
    public function hasUnlimitedAttempts(): bool
    {
        return $this->max_attempts === 0;
    }

    /**
     * Get student's attempt count for this quiz
     */
    public function getAttemptCount(int $studentId): int
    {
        return $this->attempts()
            ->where('student_id', $studentId)
            ->whereNotNull('submitted_at')
            ->count();
    }

    /**
     * Check if student can start a new attempt
     */
    public function canStudentAttempt(int $studentId): array
    {
        // Get completed attempts
        $completedAttempts = $this->attempts()
            ->where('student_id', $studentId)
            ->whereNotNull('submitted_at')
            ->orderBy('submitted_at', 'desc')
            ->get();

        $attemptCount = $completedAttempts->count();

        // Check max attempts limit
        if (!$this->hasUnlimitedAttempts() && $attemptCount >= $this->max_attempts) {
            return [
                'allowed' => false,
                'reason' => "Maximum attempts ({$this->max_attempts}) reached",
                'attempts_used' => $attemptCount,
                'attempts_remaining' => 0
            ];
        }

        // Check cooldown period
        if ($this->cooldown_minutes && $attemptCount > 0) {
            $lastAttempt = $completedAttempts->first();
            $cooldownEnd = $lastAttempt->submitted_at->addMinutes($this->cooldown_minutes);
            
            if (now()->lt($cooldownEnd)) {
                return [
                    'allowed' => false,
                    'reason' => 'Cooldown period active',
                    'cooldown_end' => $cooldownEnd,
                    'minutes_remaining' => now()->diffInMinutes($cooldownEnd, false)
                ];
            }
        }

        // Check if student must pass before retaking (require_pass_all)
        if ($this->require_pass_all && $attemptCount > 0) {
            $hasPassed = $completedAttempts->contains(function ($attempt) {
                return $attempt->percentage >= 75; // 75% is passing
            });

            if ($hasPassed) {
                return [
                    'allowed' => false,
                    'reason' => 'You have already passed this quiz',
                    'best_score' => $completedAttempts->max('score')
                ];
            }
        }

        $attemptsRemaining = $this->hasUnlimitedAttempts() 
            ? 'unlimited' 
            : $this->max_attempts - $attemptCount;

        return [
            'allowed' => true,
            'attempts_used' => $attemptCount,
            'attempts_remaining' => $attemptsRemaining
        ];
    }

    /**
     * Get the final score for a student based on retake scoring policy
     */
    public function getFinalScore(int $studentId): ?array
    {
        $completedAttempts = $this->attempts()
            ->where('student_id', $studentId)
            ->whereNotNull('submitted_at')
            ->get();

        if ($completedAttempts->isEmpty()) {
            return null;
        }

        switch ($this->retake_scoring) {
            case 'highest':
                $finalAttempt = $completedAttempts->sortByDesc('score')->first();
                break;

            case 'latest':
                $finalAttempt = $completedAttempts->sortByDesc('submitted_at')->first();
                break;

            case 'first':
                $finalAttempt = $completedAttempts->sortBy('submitted_at')->first();
                break;

case 'average':
    $avgScore = $completedAttempts->avg('score');
    $maxScore = $completedAttempts->first()->max_score;
    $percentage = $maxScore > 0 ? round(($avgScore / $maxScore) * 100, 2) : 0;

    return [
        'attempt_id' => null,
        'score' => round($avgScore, 2),
        'max_score' => $maxScore,
        'percentage' => $percentage,
        'attempt_count' => $completedAttempts->count(),
        'scoring_method' => 'average'
    ];

            default:
                $finalAttempt = $completedAttempts->sortByDesc('score')->first();
        }

        return [
            'score' => $finalAttempt->score,
            'max_score' => $finalAttempt->max_score,
            'percentage' => $finalAttempt->percentage,
            'attempt_id' => $finalAttempt->id,
            'submitted_at' => $finalAttempt->submitted_at,
            'scoring_method' => $this->retake_scoring
        ];
    }

    /**
     * Get scoring method label
     */
    public function getScoringMethodLabel(): string
    {
        return match($this->retake_scoring) {
            'highest' => 'Highest Score',
            'latest' => 'Latest Attempt',
            'average' => 'Average of All Attempts',
            'first' => 'First Attempt Only',
            default => 'Highest Score'
        };
    }
}
