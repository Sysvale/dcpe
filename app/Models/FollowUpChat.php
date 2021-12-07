<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class FollowUpChat extends Model
{
    protected $fillable = [
        'id_user',
        'id_professional',
        'sent_by',
        'message',
        'read',
    ];
}
