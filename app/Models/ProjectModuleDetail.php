<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModuleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'assign_project_id',
    ];

    public function module()
    {
        return $this->belongsTo(ProjectModule::class, 'module_id');
    }

    public function assignProject()
    {
        return $this->belongsTo(ProjectAssign::class, 'assign_project_id');
    }
}
