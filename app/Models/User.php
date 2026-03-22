<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
    'username',
    'name',
    'email',
    'password',
    'role',
    'status',
    'gender',
    'city',
    'state',

    // 🔥 tracking fields
    'last_login',
    'last_activity',
    'login_ip',
    'device',
    'browser',
    'os',
    
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔹 العلاقات حسب الدور
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function supervisor()
    {
        return $this->hasOne(Supervisor::class);
    }

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }

   

    // public function notifications()
    // {
    //     return $this->belongsToMany(Notification::class, 'notification_user')->withTimestamps();
    // }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    // 🔹 تشفير كلمة المرور تلقائيًا عند الحفظ
// protected function setPasswordAttribute($value)
// {
//     // If the value is already a valid hash, do NOT hash it again.
//     if (\Illuminate\Support\Facades\Hash::needsRehash($value)) {
//         $this->attributes['password'] = bcrypt($value);
//     } else {
//         $this->attributes['password'] = $value;
//     }
// }
// Inside User.php

protected $casts = [
    'last_login' => 'datetime',
    'last_activity' => 'datetime',
];
public function investor()
{
    return $this->hasOne(Investor::class);
}


public function projects()
    {
        return $this->hasMany(Project::class, 'student_id');
    }

protected static function booted()
{
    static::saved(function ($user) {
        if (! $user->wasRecentlyCreated && ! $user->wasChanged('role')) {
            return;
        }

        $role = $user->role;

        $roleModels = [
            'Manager'    => \App\Models\Manager::class,
            'Investor'   => \App\Models\Investor::class,
            'Student'    => \App\Models\Student::class,
            'Supervisor' => \App\Models\Supervisor::class,
        ];

        foreach ($roleModels as $roleName => $modelClass) {
            if ($role === $roleName) {
                $modelClass::firstOrCreate(['user_id' => $user->id]);
            } else {
                $modelClass::where('user_id', $user->id)->delete();
            }
        }
    });
}

public function investments()
{
    return $this->belongsToMany(
        Project::class,
        'project_investments',
        'investor_id',
        'project_id',
        'id',
        'project_id'
    )->withPivot('status', 'amount', 'message')->withTimestamps();
}
public function projectReviews()
{
    return $this->hasMany(\App\Models\ProjectReview::class, 'supervisor_id', 'id');
}

public function investedProjects()
{
    return $this->belongsToMany(Project::class, 'investor_project', 'investor_id', 'project_id');
}
}
