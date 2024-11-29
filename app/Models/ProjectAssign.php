<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssign extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'project_id', 
        'dept_id', 
        'user_id', 
        'is_moderator'
    ];

    // Relationship: A project assign belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Relationship: A project assign belongs to a department
    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    // Relationship: A project assign belongs to a user (employee)
    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
