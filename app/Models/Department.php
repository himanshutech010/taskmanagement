<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
    return $this->belongsToMany(User::class, 'user_dept', 'dept_id', 'user_id');
    }

    public function projectAssignments()
    {
        return $this->hasMany(ProjectAssign::class, 'dept_id');
    }

}

