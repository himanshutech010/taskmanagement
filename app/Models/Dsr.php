<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dsr extends Model
{
    use HasFactory;

    protected $fillable = ['today_work', 'comment', 'status', 'time_taken', 'created_by'];



    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
