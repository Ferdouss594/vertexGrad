<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;            
use Spatie\MediaLibrary\InteractsWithMedia; 

// Make sure these actually exist in your app/Models folder
use App\Models\User;
use App\Models\ProjectTask;
use App\Models\ProjectFile;

// If these two don't exist yet, comment them out to stop the errors:
// use App\Models\ProjectEvaluation; 
// use App\Models\ProjectReport;
class Project extends Model implements HasMedia // ADD "implements HasMedia"
{
    use HasFactory, InteractsWithMedia;        // ADD "InteractsWithMedia"

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
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function student() {
    // This links Project(student_id) -> User(id)
    return $this->belongsTo(User::class, 'student_id');
    }
    // UPDATED RELATIONS: Pointing directly to User model for Auth ease

    public function supervisor() {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function investor() {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function tasks() {
        return $this->hasMany(ProjectTask::class, 'project_id');
    }

    // public function evaluations() {
    //     return $this->hasMany(ProjectEvaluation::class, 'project_id');
    // }

    // public function reports() {
    //     return $this->hasMany(ProjectReport::class, 'project_id');
    // }

    // FIX: Changed from FileUpload to ProjectFile to match your Controller
    public function files() {
        return $this->hasMany(ProjectFile::class, 'project_id');
    }
    public function getRouteKeyName()
    {
        return 'project_id';
    }

}