<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'message',
        'response',
        'intent',
        'language',
        'confidence',
        'metadata',
        'was_helpful'
    ];

    protected $casts = [
        'metadata' => 'array',
        'confidence' => 'float',
        'was_helpful' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(ChatbotFeedback::class);
    }
}