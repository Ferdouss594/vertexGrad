<?php
// app/Models/ChatLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    protected $table = 'chat_logs';
    
    protected $fillable = [
        'user_id',
        'user_name',
        'message',
        'response',
        'rating',
        'session_id',
        'ip_address',
        'user_agent'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}