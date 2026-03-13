<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'description',
        'student_id',
        'status',
        'date_submitted',
        'date_updated',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'student_id', 'student_id');
    }
}
