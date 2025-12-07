<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'project_id';

    protected $fillable = [
        'name','description','category','status',
        'student_id','supervisor_id','manager_id','investor_id',
        'budget','start_date','end_date','priority','progress',
        'tags','is_featured','status_history'
    ];

    protected $casts = [
        'tags' => 'array',
        'status_history' => 'array',
        'is_featured' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    // علاقات
    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function supervisor() {
        return $this->belongsTo(Supervisor::class, 'supervisor_id');
    }

    public function manager() {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function investor() {
        return $this->belongsTo(Investor::class, 'investor_id');
    }

    public function tasks() {
        return $this->hasMany(ProjectTask::class, 'project_id');
    }

    public function evaluations() {
        return $this->hasMany(ProjectEvaluation::class, 'project_id');
    }

    public function reports() {
        return $this->hasMany(ProjectReport::class, 'project_id');
    }

    public function files() {
        return $this->hasMany(FileUpload::class, 'project_id');
    }
}
