<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestorFile extends Model
{
    protected $fillable = ['investor_id','filename','path','mime','size','uploaded_by'];

    public function investor() { return $this->belongsTo(Investor::class); }
    public function uploader() { return $this->belongsTo(\App\Models\User::class, 'uploaded_by'); }
}
