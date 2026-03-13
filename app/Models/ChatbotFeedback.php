<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotFeedback extends Model
{
    protected $fillable = [
        'conversation_id',
        'rating',
        'comment',
        'corrected_intent'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}