<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuaryPersonalBackground extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'neoplasm',
        'syphilis_history_dsts',
        'others_dsts_explane',
        'viral_hepatitis',
        'arterial_hypertension',
        'diabetes_mellitus',
        'coronary_disease',
        'dyslipidemia',
        'neuropsychiatric_disorders',
        'neuropsychiatric_disorders_explane',
        'smoking',
        'alcoholism',
        'megaesophagus',
        'megacolon',
        'avc',
        'chronic_lung_disease',
        'cardiac_insufficiency',
        'status',
    ];
}
