<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCheckList extends Model
{
    use HasFactory;

    protected $table = 'task_check_lists'; // Table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'taskId',
        'taskValue',
        'created_by',
        'isactive',
        'isdelete',
        'modified_by',
    ];

    /**
     * Relationships.
     */

     public function comments(){
        return $this->belongsTo(TaskCheckListComment::class, 'taskCheckListId');
    }



    public function task()
    {
        return $this->belongsTo(Task::class, 'taskId');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
