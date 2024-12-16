<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssigne extends Model
{
    use HasFactory;

    protected $table = 'task_assignes'; // Correct table name

    protected $fillable = [
        'taskId',
        'userAssigneId',
        'created_by',
        'isactive',
        'isdelete',
        'modified_by',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'taskId');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'userAssigneId');
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
