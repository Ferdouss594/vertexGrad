<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department',
        'last_login',
        'last_activity',
        'login_ip',
        'device',
        'browser',
        'os',
        'profile_image',
    ];

    // كل مدير مرتبط بحساب مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // صلاحيات المدير
    public function permissions()
    {
        return $this->hasMany(ManagerPermission::class);
    }
}
