<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Prontuary extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'id',
        'id_user',
        'status',   // waiting, completed
        'created_at',
        'updated_at',
    ];
}
