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
    return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id')
                ->where('role', 'student')
                ->withTimestamps(); // ✅ add this
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
        'user_id',
        'name',
        'first_name',
        'last_name',
        'middle_initial',
        'email',
        'password',
        'role',
        'is_active',
        'gender',
        'guardian_name',
        'guardian_first_name',
        'guardian_last_name',
        'guardian_middle_initial',
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
        'is_active' => 'boolean',
    ];
}
public function scores()
{
    return $this->hasMany(Score::class, 'student_id');
}
public function subjects()
{
    return $this->belongsToMany(Subject::class, 'subject_user', 'user_id', 'subject_id')
                ->withTimestamps(); // ✅ add this
}
    // Auto-generate user_id when creating user
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->user_id)) {
                $user->user_id = self::generateUserId($user->role);
            }
            
            // Auto-generate full name from parts
            if (empty($user->name) && !empty($user->first_name) && !empty($user->last_name)) {
                $user->name = $user->last_name . ', ' . $user->first_name . ' ' . ($user->middle_initial ?? '');
            }
            
            // Auto-generate guardian full name
            if (empty($user->guardian_name) && !empty($user->guardian_first_name) && !empty($user->guardian_last_name)) {
                $user->guardian_name = $user->guardian_last_name . ', ' . $user->guardian_first_name . ' ' . ($user->guardian_middle_initial ?? '');
            }
        });
    }

    // Generate unique user ID
    public static function generateUserId($role)
    {
        $prefix = ($role === 'student') ? 'SGSSM' : 'TGSSM';
        
        // Get the last user ID with this prefix
        $lastUser = self::where('user_id', 'LIKE', $prefix . '%')
            ->orderBy('user_id', 'desc')
            ->first();
        
        $nextNumber = 1;
        
        if ($lastUser) {
            // Extract the number part (after prefix)
            $lastNumber = intval(substr($lastUser->user_id, strlen($prefix)));
            $nextNumber = $lastNumber + 1;
        }
        
        // Format: SGSSM000001 or TGSSM000001
        return $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
