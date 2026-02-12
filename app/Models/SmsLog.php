<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'student_id',
        'guardian_contact',
        'message',
        'risk_severity',
        'failed_count',
        'trend',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'failed_count' => 'integer',
    ];

    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Scopes for filtering
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}