<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the timestamps for the model.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}