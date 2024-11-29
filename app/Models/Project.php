<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 
        'date', 
        'status', 
        'url', 
        'description', 
        'client_id'
    ];

    // Relationship: A project belongs to a client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relationship: A project has many project assignments
    public function assignments()
    {
        return $this->hasMany(ProjectAssign::class, 'project_id');
    }
}
