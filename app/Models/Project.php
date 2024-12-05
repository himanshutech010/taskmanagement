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
        'client_id',
        'isdeleted',
    ];


    protected $casts = [

 'isdeleted'=>'boolean',
 
    ];
    // Relationship: A project belongs to a client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }



    public function users()
{
    // Many-to-Many relationship via ProjectAssign
    return $this->belongsToMany(User::class, 'project_assign', 'project_id', 'user_id');
}

public function assignments()
{
    // One-to-Many relationship for project assignments
    return $this->hasMany(ProjectAssign::class, 'project_id');
}
}
