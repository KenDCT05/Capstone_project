<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\TransmutationTrait;

class Score extends Model
{
    use TransmutationTrait;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'subject_id',
        'type',
        'label',
        'quiz_id',      
        'score',
        'max_score',    
        'percentage',  
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function student(): BelongsTo { return $this->belongsTo(User::class, 'student_id'); }
    public function teacher(): BelongsTo { return $this->belongsTo(User::class, 'teacher_id'); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function maxScoreRecord(): BelongsTo { return $this->belongsTo(MaxScore::class, ['subject_id', 'label'], ['subject_id', 'label']); }

    // Percentage calculation
    public function getCalculatedPercentageAttribute()
    {
        if ($this->percentage && $this->percentage >= 0 && $this->percentage <= 100) {
            return $this->percentage;
        }

        $effectiveMaxScore = $this->getEffectiveMaxScore();
        return $effectiveMaxScore > 0 ? round(($this->score / $effectiveMaxScore) * 100, 2) : null;
    }

    public function getEffectiveMaxScore()
    {
        if ($this->max_score && $this->max_score > 0) return (float) $this->max_score;

        $maxScore = MaxScore::where('subject_id', $this->subject_id)
            ->where('label', $this->label)
            ->first();
        if ($maxScore && $maxScore->max_score > 0) return (float) $maxScore->max_score;

        $labelLower = strtolower($this->label ?? '');
        $typeLower = strtolower($this->type ?? '');

        if ($typeLower === 'attendance' || str_contains($labelLower, 'attendance')) return 10.0;
        if ($typeLower === 'quiz') return 20.0;
        if ($typeLower === 'exam' || str_contains($labelLower, 'exam') || str_contains($labelLower, 'test')) return 50.0;
        if ($typeLower === 'activity' || str_contains($labelLower, 'activity')) return 100.0;

        return 100.0;
    }

    // ✅ Transmutation using trait
    public function getLetterGradeAttribute()
    {
        return $this->percentage !== null
            ? self::getTransmutedGrade($this->percentage)['letter']
            : null;
    }

    public function getTransmutedGradeAttribute()
    {
        return $this->percentage !== null
            ? self::getTransmutedGrade($this->percentage)['grade']
            : null;
    }

    public function getPerformanceLevelAttribute()
    {
        return $this->percentage !== null
            ? self::getTransmutedGrade($this->percentage)['performance']
            : null;
    }

    // Scopes
    public function scopeForStudent($query, $studentId) { return $query->where('student_id', $studentId); }
    public function scopeForSubject($query, $subjectId) { return $query->where('subject_id', $subjectId); }
    public function scopeForTeacher($query, $teacherId) { return $query->where('teacher_id', $teacherId); }
    public function scopeByType($query, $type) { return $query->where('type', $type); }
    public function scopeExcludeAttendance($query)
    {
        return $query->where('type', '!=', 'attendance')
                    ->where('label', 'NOT LIKE', '%attendance%')
                    ->where('label', 'NOT LIKE', '%Attendance%');
    }
    public function scopeRecent($query, $days = 30) { return $query->where('created_at', '>=', now()->subDays($days)); }

    public function scopeWithTransmutedGrade($query, $operator = '>=', $value = 75)
    {
        return $query->whereRaw("
            CASE 
                WHEN percentage >= 100.00 THEN 100
                WHEN percentage >= 98.40 THEN 99
                WHEN percentage >= 96.80 THEN 98
                WHEN percentage >= 95.20 THEN 97
                WHEN percentage >= 93.60 THEN 96
                WHEN percentage >= 92.00 THEN 95
                WHEN percentage >= 90.40 THEN 94
                WHEN percentage >= 88.80 THEN 93
                WHEN percentage >= 87.20 THEN 92
                WHEN percentage >= 85.60 THEN 91
                WHEN percentage >= 84.00 THEN 90
                WHEN percentage >= 82.40 THEN 89
                WHEN percentage >= 80.80 THEN 88
                WHEN percentage >= 79.20 THEN 87
                WHEN percentage >= 77.60 THEN 86
                WHEN percentage >= 76.00 THEN 85
                WHEN percentage >= 74.40 THEN 84
                WHEN percentage >= 72.80 THEN 83
                WHEN percentage >= 71.20 THEN 82
                WHEN percentage >= 69.60 THEN 81
                WHEN percentage >= 68.00 THEN 80
                WHEN percentage >= 66.40 THEN 79
                WHEN percentage >= 64.80 THEN 78
                WHEN percentage >= 63.20 THEN 77
                WHEN percentage >= 61.60 THEN 76
                WHEN percentage >= 60.00 THEN 75
                ELSE 60
            END {$operator} ?
        ", [$value]);
    }

    // Auto-calc percentage before saving
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($score) {
            if (!$score->percentage && $score->score !== null) {
                $maxScore = $score->getEffectiveMaxScore();
                if ($maxScore > 0) $score->percentage = round(($score->score / $maxScore) * 100, 2);
            }
        });
    }

    // Analytics
    public static function getSubjectAnalytics($subjectId, $studentId = null)
    {
        $query = static::where('subject_id', $subjectId);
        if ($studentId) $query->where('student_id', $studentId);
        $scores = $query->get();
        
        return [
            'total_scores' => $scores->count(),
            'average_percentage' => $scores->avg('calculated_percentage'),
            'average_transmuted' => $scores->avg('transmuted_grade'),
            'performance_distribution' => [
                'excellent' => $scores->where('performance_level', 'Excellent')->count(),
                'very_good' => $scores->where('performance_level', 'Very Good')->count(),
                'good' => $scores->where('performance_level', 'Good')->count(),
                'fair' => $scores->where('performance_level', 'Fair')->count(),
                'passed' => $scores->where('performance_level', 'Passed')->count(),
                'failed' => $scores->where('performance_level', 'Failed')->count(),
            ],
            'unique_students' => $scores->pluck('student_id')->unique()->count(),
            'unique_assessments' => $scores->pluck('label')->unique()->count()
        ];
    }
}
