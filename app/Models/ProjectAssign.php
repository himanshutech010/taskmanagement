<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssign extends Model
{
    use HasFactory;
    protected $table = 'project_assign';
    protected $fillable = [
        'project_id',
        'dept_id',
        'user_id',
        'is_moderator'
    ];

    public function project()
    {
        // Many assignments belong to one project
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function department()
    {
        // Many assignments belong to one department
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function employee()
    {
        // Many assignments belong to one user
        return $this->belongsTo(User::class, 'user_id');
    }
}
