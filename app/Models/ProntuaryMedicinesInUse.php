<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuaryMedicinesInUse extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'diuretic',
        'blocker',
        'angiotensin_inhibitor',
        'amiodarone',
        'usage_time_amidarone',
        'statins',
        'spironolactone',
        'usage_time_spironolactone',
        'hypoglycemics',
        'benzodiazepines',
        'aas',
        'hydralazine',
        'levothyroxine_sodium',
        'anlodipine',
        'status',
    ];
}
