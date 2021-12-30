<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuaryAnthropomedicalData extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'weight',
        'height',
        'imc',
        'status',
    ];
}
