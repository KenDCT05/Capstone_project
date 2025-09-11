<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestionAnswer extends Model
{
    protected $fillable = ['question_id', 'answer_text', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class,'question_id');
    }

    // Scope for primary answers
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Scope for alternative answers
    public function scopeAlternatives($query)
    {
        return $query->where('is_primary', false);
    }
}