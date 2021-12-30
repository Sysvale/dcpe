<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;;

class DoubtAnswer extends Model
{
    protected $fillable = [
        'id_doubt',
        'type', // type = 1 (enviado), type = 2 (recebido)
        'answer',
        'answered_by',
        'read',
        'created_at',
        'updated_at',
    ];
}
