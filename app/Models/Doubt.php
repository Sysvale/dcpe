<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Doubt extends Model
{
    // protected $connection = 'mongodb';

    protected $fillable = [
        'id_user',
        'message',
        'status',
        'answered',
        'read',
        'answered_by',
    ];
}
