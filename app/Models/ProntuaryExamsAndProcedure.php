<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuaryExamsAndProcedure extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'rx_chest',
        'rx_esophagus',
        'electrocardiogram',
        'pacemaker',
        'heart_transplantation',
        'status',
    ];
}
