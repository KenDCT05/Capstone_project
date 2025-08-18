<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaxScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'label',
        'max_score',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
