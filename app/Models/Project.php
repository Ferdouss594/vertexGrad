<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\User;
use App\Models\ProjectTask;
use App\Models\ProjectFile;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $primaryKey = 'project_id';

    protected $fillable = [
        'name',
        'description',
        'category',
        'status',

        // Scanner fields
        'upload_token',
        'scanner_status',
        'scanner_project_id',
        'scan_score',
        'scan_report',
        'scanned_at',

        // Relations
        'student_id',
        'supervisor_id',
        'manager_id',
        'investor_id',

        // Project info
        'budget',
        'start_date',
        'end_date',
        'priority',
        'progress',
        'tags',
        'is_featured',
        'status_history',
    ];

    protected $casts = [
        'tags' => 'array',
        'status_history' => 'array',
        'is_featured' => 'boolean',
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'scanned_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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
        return $this->hasMany(ProjectTask::class, 'project_id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class, 'project_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    public function getRouteKeyName()
    {
        return 'project_id';
    }
}