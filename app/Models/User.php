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

   

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    // 🔹 تشفير كلمة المرور تلقائيًا عند الحفظ
public function setPasswordAttribute($value)
{
    $this->attributes['password'] = bcrypt($value);
}
protected $casts = [
    'last_login' => 'datetime',
    'last_activity' => 'datetime',
];
public function investor()
{
    return $this->hasOne(Investor::class);
}


}
