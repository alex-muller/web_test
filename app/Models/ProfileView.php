<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{
    public $timestamps = false;

    protected $fillable = ['profile_id', 'city_id', 'count'];
}
