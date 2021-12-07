<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class FollowUp extends Model
{
    protected $fillable = [
        'id_user',
        'requested',
        'accepted_by',
    ];
}
