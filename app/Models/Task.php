<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks'; // Table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_date',
        'created_by',
        'highPriority',
        'Deadline',
        'Module_id',
        'project_id',
        'isactive',
        'isdelete',
        'modified_by',
   
    ];



    /**
     * Relationships.
     */



     public function taskCheckLists()
     {
         return $this->belongsTo(TaskCheckList::class, 'taskCheckListId');
     }

    //  public function assignees(){
    //     return $this->belongsTo()
    //  }

    //  public function assignees()
    //  {
    //      return $this->belongsTo(TaskAssigne::class, 'userAssigneId');
    //  }
 

    public function assignees()
{
    return $this->belongsToMany(User::class, 'task_assignes', 'taskId', 'userAssigneId')
                ->withPivot('created_by', 'isactive', 'isdelete');
}

     /////
    public function module()
    {
        return $this->belongsTo(ProjectModule::class, 'Module_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    

    public function assignedUsers()
{
    return $this->belongsToMany(User::class, 'task_assignes', 'taskId', 'userAssigneId')
    ->withPivot('created_by', 'isactive', 'isdelete');
}   




}

