<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuarySocioeconomicData extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'education_level',
        'per_capita_income',
        'number_of_inhabitants',
        'work_status',
        'profission',
        'status',
    ];
}
