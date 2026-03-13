<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondProject extends Model
{
    protected $connection = 'mysql_second'; // الاتصال بالقاعدة الثانية
    protected $table = 'projects';         // جدول المشاريع في المنصة الثانية
    protected $fillable = ['name', 'user_id', 'status']; // الأعمدة التي تريدها
}