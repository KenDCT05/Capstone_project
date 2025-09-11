<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaxScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'label',
        'max_score',
    ];

    protected $casts = [
        'max_score' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the subject that owns the max score
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get all scores for this assessment
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class, 'label', 'label')
                    ->where('scores.subject_id', $this->subject_id);
    }

    /**
     * Get statistics for this assessment with transmuted grades
     */
    public function getStatsAttribute()
    {
        $scores = Score::where('subject_id', $this->subject_id)
            ->where('label', $this->label)
            ->get();
        
        if ($scores->isEmpty()) {
            return [
                'count' => 0,
                'average_score' => 0,
                'average_percentage' => 0,
                'average_transmuted' => 0,
                'highest_score' => 0,
                'lowest_score' => 0,
                'passing_count' => 0,
                'passing_rate' => 0,
                'performance_distribution' => [
                    'excellent' => 0,
                    'very_good' => 0,
                    'good' => 0,
                    'fair' => 0,
                    'passed' => 0,
                    'failed' => 0
                ]
            ];
        }

        // Calculate percentages and transmuted grades
        $scoresWithCalculations = $scores->map(function ($score) {
            $percentage = $this->max_score > 0 ? 
                round(($score->score / $this->max_score) * 100, 2) : 0;
            
            $score->calculated_percentage = $percentage;
            $transmutedData = $this->getTransmutedGrade($percentage);
            $score->calculated_transmuted = $transmutedData['transmuted'];
            $score->calculated_performance = $transmutedData['performance'];
            
            return $score;
        });

        $averageScore = $scoresWithCalculations->avg('score');
        $averagePercentage = $scoresWithCalculations->avg('calculated_percentage');
        $averageTransmuted = $scoresWithCalculations->avg('calculated_transmuted');
        
        $passingCount = $scoresWithCalculations->filter(function ($score) {
            return $score->calculated_transmuted >= 75; // 75 is passing threshold
        })->count();

        // Performance distribution
        $performanceDistribution = [
            'excellent' => $scoresWithCalculations->where('calculated_performance', 'Excellent')->count(),
            'very_good' => $scoresWithCalculations->where('calculated_performance', 'Very Good')->count(),
            'good' => $scoresWithCalculations->where('calculated_performance', 'Good')->count(),
            'fair' => $scoresWithCalculations->where('calculated_performance', 'Fair')->count(),
            'passed' => $scoresWithCalculations->where('calculated_performance', 'Passed')->count(),
            'failed' => $scoresWithCalculations->where('calculated_performance', 'Failed')->count(),
        ];

        return [
            'count' => $scores->count(),
            'average_score' => round($averageScore, 2),
            'average_percentage' => round($averagePercentage, 2),
            'average_transmuted' => round($averageTransmuted, 2),
            'highest_score' => $scoresWithCalculations->max('score'),
            'lowest_score' => $scoresWithCalculations->min('score'),
            'passing_count' => $passingCount,
            'passing_rate' => $scores->count() > 0 ? 
                round(($passingCount / $scores->count()) * 100, 2) : 0,
            'performance_distribution' => $performanceDistribution
        ];
    }

    /**
     * Get transmuted grade based on percentage (matches controller logic)
     */
    private function getTransmutedGrade($percentage)
    {
        $transmutationTable = [
            ['min' => 100.00, 'max' => 100.00, 'transmuted' => 100, 'letter' => 'A+', 'performance' => 'Excellent'],
            ['min' => 98.40, 'max' => 99.99, 'transmuted' => 99, 'letter' => 'A', 'performance' => 'Excellent'],
            ['min' => 96.80, 'max' => 98.39, 'transmuted' => 98, 'letter' => 'A', 'performance' => 'Excellent'],
            ['min' => 95.20, 'max' => 96.79, 'transmuted' => 97, 'letter' => 'A-', 'performance' => 'Excellent'],
            ['min' => 93.60, 'max' => 95.19, 'transmuted' => 96, 'letter' => 'A-', 'performance' => 'Excellent'],
            ['min' => 92.00, 'max' => 93.59, 'transmuted' => 95, 'letter' => 'B+', 'performance' => 'Very Good'],
            ['min' => 90.40, 'max' => 91.99, 'transmuted' => 94, 'letter' => 'B+', 'performance' => 'Very Good'],
            ['min' => 88.80, 'max' => 90.39, 'transmuted' => 93, 'letter' => 'B', 'performance' => 'Very Good'],
            ['min' => 87.20, 'max' => 88.79, 'transmuted' => 92, 'letter' => 'B', 'performance' => 'Very Good'],
            ['min' => 85.60, 'max' => 87.19, 'transmuted' => 91, 'letter' => 'B-', 'performance' => 'Good'],
            ['min' => 84.00, 'max' => 85.59, 'transmuted' => 90, 'letter' => 'B-', 'performance' => 'Good'],
            ['min' => 82.40, 'max' => 83.99, 'transmuted' => 89, 'letter' => 'C+', 'performance' => 'Good'],
            ['min' => 80.80, 'max' => 82.39, 'transmuted' => 88, 'letter' => 'C+', 'performance' => 'Good'],
            ['min' => 79.20, 'max' => 80.79, 'transmuted' => 87, 'letter' => 'C', 'performance' => 'Fair'],
            ['min' => 77.60, 'max' => 79.19, 'transmuted' => 86, 'letter' => 'C', 'performance' => 'Fair'],
            ['min' => 76.00, 'max' => 77.59, 'transmuted' => 85, 'letter' => 'C-', 'performance' => 'Fair'],
            ['min' => 74.40, 'max' => 75.99, 'transmuted' => 84, 'letter' => 'C-', 'performance' => 'Fair'],
            ['min' => 72.80, 'max' => 74.39, 'transmuted' => 83, 'letter' => 'D+', 'performance' => 'Passed'],
            ['min' => 71.20, 'max' => 72.79, 'transmuted' => 82, 'letter' => 'D+', 'performance' => 'Passed'],
            ['min' => 69.60, 'max' => 71.19, 'transmuted' => 81, 'letter' => 'D', 'performance' => 'Passed'],
            ['min' => 68.00, 'max' => 69.59, 'transmuted' => 80, 'letter' => 'D', 'performance' => 'Passed'],
            ['min' => 66.40, 'max' => 67.99, 'transmuted' => 79, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 64.80, 'max' => 66.39, 'transmuted' => 78, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 63.20, 'max' => 64.79, 'transmuted' => 77, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 61.60, 'max' => 63.19, 'transmuted' => 76, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 60.00, 'max' => 61.59, 'transmuted' => 75, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 56.00, 'max' => 59.99, 'transmuted' => 74, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 52.00, 'max' => 55.99, 'transmuted' => 73, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 48.00, 'max' => 51.99, 'transmuted' => 72, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 44.00, 'max' => 47.99, 'transmuted' => 71, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 40.00, 'max' => 43.99, 'transmuted' => 70, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 36.00, 'max' => 39.99, 'transmuted' => 69, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 32.00, 'max' => 35.99, 'transmuted' => 68, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 28.00, 'max' => 31.99, 'transmuted' => 67, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 24.00, 'max' => 27.99, 'transmuted' => 66, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 20.00, 'max' => 23.99, 'transmuted' => 65, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 16.00, 'max' => 19.99, 'transmuted' => 64, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 12.00, 'max' => 15.99, 'transmuted' => 63, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 8.00, 'max' => 11.99, 'transmuted' => 62, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 4.00, 'max' => 7.99, 'transmuted' => 61, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 0.00, 'max' => 3.99, 'transmuted' => 60, 'letter' => 'F', 'performance' => 'Failed'],
        ];

        foreach ($transmutationTable as $row) {
            if ($percentage >= $row['min'] && $percentage <= $row['max']) {
                return [
                    'transmuted' => $row['transmuted'],
                    'letter' => $row['letter'],
                    'performance' => $row['performance']
                ];
            }
        }
        
        return [
            'transmuted' => 60,
            'letter' => 'F',
            'performance' => 'Failed'
        ];
    }

    // Scopes
    public function scopeForSubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

    public function scopeExcludeAttendance($query)
    {
        return $query->where('label', 'NOT LIKE', '%attendance%')
                    ->where('label', 'NOT LIKE', '%Attendance%');
    }

    public function scopeOrderByLabel($query)
    {
        return $query->orderBy('label');
    }

    // Helper methods
    public function hasScores(): bool
    {
        return Score::where('subject_id', $this->subject_id)
            ->where('label', $this->label)
            ->exists();
    }

    public function isAttendance(): bool
    {
        $labelLower = strtolower($this->label);
        return str_contains($labelLower, 'attendance');
    }

    public function getDifficultyLevelAttribute(): string
    {
        $stats = $this->stats;
        
        if ($stats['average_transmuted'] >= 94) {
            return 'Easy';
        } elseif ($stats['average_transmuted'] >= 85) {
            return 'Moderate';
        } elseif ($stats['average_transmuted'] >= 75) {
            return 'Challenging';
        } else {
            return 'Difficult';
        }
    }

    // Static methods
    public static function getAssessmentCount($subjectId, $excludeAttendance = true)
    {
        $query = static::where('subject_id', $subjectId);
        
        if ($excludeAttendance) {
            $query->excludeAttendance();
        }
        
        return $query->count();
    }

    public static function getSubjectAssessments($subjectId, $excludeAttendance = false)
    {
        $query = static::where('subject_id', $subjectId);
        
        if ($excludeAttendance) {
            $query->excludeAttendance();
        }

        return $query->orderBy('label')
            ->get()
            ->map(function ($maxScore) {
                return [
                    'id' => $maxScore->id,
                    'label' => $maxScore->label,
                    'max_score' => $maxScore->max_score,
                    'stats' => $maxScore->stats,
                    'difficulty' => $maxScore->difficulty_level,
                    'is_attendance' => $maxScore->isAttendance()
                ];
            });
    }

    public static function createAssessment($subjectId, $label, $maxScore)
    {
        // Check if assessment already exists
        $existing = static::where('subject_id', $subjectId)
            ->where('label', $label)
            ->first();

        if ($existing) {
            throw new \Exception("Assessment '{$label}' already exists for this subject.");
        }

        if ($maxScore <= 0) {
            throw new \Exception("Max score must be greater than 0.");
        }

        return static::create([
            'subject_id' => $subjectId,
            'label' => $label,
            'max_score' => $maxScore
        ]);
    }

    public function updateMaxScore($newMaxScore)
    {
        if ($newMaxScore <= 0) {
            throw new \Exception("Max score must be greater than 0.");
        }

        // Check if any existing scores would exceed the new max score
        $highestExistingScore = Score::where('subject_id', $this->subject_id)
            ->where('label', $this->label)
            ->max('score');
        
        if ($highestExistingScore && $highestExistingScore > $newMaxScore) {
            throw new \Exception("Cannot set max score to {$newMaxScore}. Highest existing score is {$highestExistingScore}.");
        }

        $this->update(['max_score' => $newMaxScore]);
        
        // Update percentages for all existing scores with this assessment
        Score::where('subject_id', $this->subject_id)
            ->where('label', $this->label)
            ->each(function ($score) {
                $score->percentage = round(($score->score / $this->max_score) * 100, 2);
                $score->save();
            });

        return $this;
    }
}