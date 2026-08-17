<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedAttempt extends Model
{
    protected $fillable = [
        'ip_address',
        'url',
        'method',
        'user_agent',
    ];
}