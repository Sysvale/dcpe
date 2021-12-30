<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuaryEpidemicData extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'has_dc',
        'has_serology',
        'dc_in_family',
        'dc_in_family_who',
        'dc_in_family_vf',
        'know_the_vector',
        'lived_in_a_mud_house',
        'time_in_a_mud_house',
        'dwelling_area',
        'has_breeding',
        'donated_blood',
        'received_blood',
        'status',
    ];
}
