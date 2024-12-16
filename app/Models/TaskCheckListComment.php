<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCheckListComment extends Model
{
    use HasFactory;

    protected $table = 'task_check_list_comments'; // Table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'taskCheckListId',
        'commentValue',
        'created_by',
        'isactive',
        'isdelete',
        'modified_by',
    ];

    /**
     * Relationships.
     */
    public function taskCheckList()
    {
        return $this->belongsTo(TaskCheckList::class, 'taskCheckListId');
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
