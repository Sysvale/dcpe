<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Professional extends Model
{
    protected $fillable = [
        'id_user',
        'id_patient',
        'created_at',
        'updated_at',
    ];
}
