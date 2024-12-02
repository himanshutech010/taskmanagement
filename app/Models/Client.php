<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'client_name',
        'mobile',
        'email',
        'linkedin',
        'skype',
        'other',
        'location',
        'is_test',
        'isdeleted',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'is_test' => 'boolean',
        'isdeleted'=>'boolean',
    ];
}

