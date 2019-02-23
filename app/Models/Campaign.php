<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public $timestamps = false;

    protected $fillable = ['id', 'url'];

    public function clicks()
    {
        return $this->belongsToMany(Profile::class, 'campaign_profile_clicks', null, 'profile_id');
    }
}
