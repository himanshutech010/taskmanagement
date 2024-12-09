<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModule extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'start_date',
        'end_date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }


    public function details()
    {
        return $this->hasMany(ProjectModuleDetail::class, 'module_id');
    }

  

}
