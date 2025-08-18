<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public function students()
    {
    return $this->belongsToMany(User::class, 'student_teacher', 'teacher_id', 'student_id');
    }

    public function teachers()
    {
    return $this->belongsToMany(User::class, 'student_teacher', 'student_id', 'teacher_id');
    }

    public function materials()
    {
    return $this->hasMany(Material::class, 'teacher_id');
    }

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'birthday',
    'gender',
    'grade_level',
    'section',
    'guardian_name',
    'guardian_email',
    'guardian_contact',
    'contact_number',
     'first_login',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'first_login' => 'boolean'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password_changed_at' => 'datetime',
        'password' => 'hashed',
    ];
}
public function scores()
{
    return $this->hasMany(Score::class, 'student_id');
}
public function subjects()
{
    return $this->belongsToMany(Subject::class, 'subject_user', 'user_id', 'subject_id');
}
}
