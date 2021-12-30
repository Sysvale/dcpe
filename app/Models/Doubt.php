<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Doubt extends Model
{
    protected $fillable = [
        'id_user',
        'type', // type = 1 (enviado), type = 2 (recebido)
        'message',
        'status',
        'created_at',
        'updated_at',
    ];
}
