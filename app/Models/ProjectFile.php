<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProjectFile extends Model
{
    protected $fillable = ['project_id','file_name','file_type','path','access_level'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

class Project extends Model
{
    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }
}
