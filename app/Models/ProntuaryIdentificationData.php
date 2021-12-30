<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProntuaryIdentificationData extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'full_name',
        'birth_date',
        'city_of_birth',
        'city_of_origin',
        'phone',
        'marital_status',
        'breed',
        'sex',
        'status',
    ];
}
