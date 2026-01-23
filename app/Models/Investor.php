<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'phone', 'company', 'position', 'investment_type', 
        'budget', 'source', 'notes', 'status', 'deleted_at'
    ];

    // العلاقة مع المستخدم (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع الملاحظات (Notes)
    
// App\Models\Investor.php

public function notes()
{
    return $this->hasMany(InvestorNote::class, 'investor_id', 'id');
}

    // العلاقة مع الملفات (Files)
    public function files()
    {
        return $this->hasMany(InvestorFile::class);
    }

    // العلاقة مع الأنشطة (Activities)
    public function activities()
    {
        return $this->hasMany(InvestorActivity::class);
    }
}
