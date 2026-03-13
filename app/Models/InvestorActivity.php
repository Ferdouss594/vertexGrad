<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestorActivity extends Model
{
    protected $fillable = ['investor_id','user_id','action','meta'];

    protected $casts = ['meta' => 'array'];

    public function investor() { return $this->belongsTo(Investor::class); }
    public function user() { return $this->belongsTo(\App\Models\User::class); }
}
