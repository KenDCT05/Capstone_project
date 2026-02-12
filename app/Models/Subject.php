<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'teacher_id',
        'join_code',
    ];

    // Subject belongs to a teacher
public function teacher()
{
    return $this->belongsTo(User::class, 'teacher_id'); // or whatever the foreign key is
}

    // Subject has many students
public function students()
{
    return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id')
                ->where('role', 'student');
}
public function materials() {
    return $this->hasMany(Material::class);
}
public function section()
{
    return $this->belongsTo(Section::class);
}

public function subjectList()
{
    return $this->belongsTo(SubjectList::class);
}
}