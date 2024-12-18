<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;


// [ObservedBy([UserObserver::class])];
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_name',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'image',
        'role',
        'description',
        'status',
        'is_online',
        'isdeleted',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_online' => 'boolean', // Cast the is_online attribute to a boolean
        'isdeleted' => 'boolean',
        'date_of_birth' => 'datetime',
    ];


    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_dept', 'user_id', 'dept_id');
    }

    public function projectAssignments()
    {
        return $this->hasMany(ProjectAssign::class, 'user_id');
    }
}
