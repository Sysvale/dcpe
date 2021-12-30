<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuaryBenznidazol extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'benznidazol',
        'year_benznidazol',
        'form_of_presentation',
        'daily_dosage',
        'usage_time_benznidazol',
        'status',
    ];
}
