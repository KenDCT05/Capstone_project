<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'context',
        'subject_id',
        'value',
    ];

    protected $casts = [
        'value' => 'integer',
    ];

    /**
     * EngagementLog belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted action name
     */
    public function getActionNameAttribute()
    {
        return match($this->action) {
            'login' => 'Login',
            'quiz_attempt' => 'Quiz Attempt',
            'activity_upload' => 'Activity Upload',
            'course_enrollment' => 'Course Enrollment',
            'time_spent' => 'Time Spent',
            'resource_download' => 'Resource Download',
            default => ucfirst(str_replace('', ' ', $this->action))
        };
    }

    /**
     * Get formatted time spent
     */
    public function getFormattedTimeAttribute()
    {
        if ($this->action === 'time_spent' && $this->value) {
            $minutes = round($this->value / 60, 1);
            return $minutes . ' min';
        }
        return $this->value ?? 0;
    }
}

