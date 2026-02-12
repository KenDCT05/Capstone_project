<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentSubmission extends Model
{
    protected $fillable = [
        'material_id',
        'student_id',
        'file_name',
        'file_path',
        'original_name',
        'file_size',
        'mime_type',
        'status',
        'is_late', 
        'teacher_feedback',
        'grade',
    ];
 protected $guarded = ['submitted_at'];
    protected $casts = [
        'submitted_at' => 'datetime',
        'is_late' => 'boolean',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // ✅ Helper methods for compound status checking
    public function isLateSubmission(): bool
    {
        return $this->is_late;
    }

    public function isReviewed(): bool
    {
        return in_array($this->status, ['reviewed', 'late_reviewed']);
    }

    public function isGraded(): bool
    {
        return !is_null($this->grade);
    }

    public function getTimingStatus(): string
    {
        return $this->is_late ? 'late' : 'on_time';
    }

    public function getReviewStatus(): string
    {
        return $this->isReviewed() ? 'reviewed' : 'pending';
    }

    // ✅ Get display status for UI
    public function getDisplayStatus(): array
    {
        $statuses = [];
        
        // Add timing status
        if ($this->is_late) {
            $statuses[] = [
                'label' => 'Late',
                'type' => 'warning',
                'icon' => 'warning'
            ];
        } else {
            $statuses[] = [
                'label' => 'On Time',
                'type' => 'success',
                'icon' => 'check'
            ];
        }
        
        // Add review status
        if ($this->isReviewed()) {
            $statuses[] = [
                'label' => 'Reviewed',
                'type' => 'info',
                'icon' => 'star'
            ];
        } else {
            $statuses[] = [
                'label' => 'Pending Review',
                'type' => 'secondary',
                'icon' => 'clock'
            ];
        }
        
        return $statuses;
    }

    // ✅ Scope for filtering by timing
    public function scopeLateSubmissions($query)
    {
        return $query->where('is_late', true);
    }

    public function scopeOnTimeSubmissions($query)
    {
        return $query->where('is_late', false);
    }

    public function scopeReviewedSubmissions($query)
    {
        return $query->whereIn('status', ['reviewed', 'late_reviewed']);
    }

    public function scopePendingReview($query)
    {
        return $query->whereNotIn('status', ['reviewed', 'late_reviewed']);
    }
}