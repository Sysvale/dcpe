<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class FollowUpChat extends Model
{
    protected $fillable = [
        'id_user',
        'id_chat',
        'message',
        'created_at',
        'updated_at',
    ];
}
