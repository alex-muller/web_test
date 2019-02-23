<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'url',
        'campaign_id',
        'profile_id',
        'date',
    ];
}
