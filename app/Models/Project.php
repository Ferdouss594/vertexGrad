<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// Models
use App\Models\User;
use App\Models\ProjectTask;
use App\Models\ProjectFile;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'projects';
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'name',
        'description',
        'category',
        'status',
        'upload_token',

        // Scanner sync fields
        'scanner_status',
        'scanner_project_id',
        'scan_score',
        'scan_report',
        'scanned_at',

        // Ownership / relations
        'student_id',
        'supervisor_id',
        'manager_id',
        'investor_id',

        // Project business fields
        'budget',
        'start_date',
        'end_date',
        'priority',
        'progress',
        'is_featured',
        'tags',
        'status_history',
    ];

    protected $casts = [
        'tags' => 'array',
        'status_history' => 'array',
        'is_featured' => 'boolean',
        'scan_score' => 'decimal:2',
        'scanned_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'project_id';
    }

    // =========================
    // Relationships
    // =========================

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class, 'project_id', 'project_id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class, 'project_id', 'project_id');
    }

    public function investors()
    {
        return $this->belongsToMany(
            User::class,
            'project_investments',
            'project_id',
            'investor_id',
            'project_id',
            'id'
        )->withPivot('status', 'amount')->withTimestamps();
    }

    public function approvedInvestments()
    {
        return $this->investors()
            ->wherePivot('status', 'approved');
    }
}
