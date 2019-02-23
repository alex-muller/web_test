<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscription extends Model
{
    public $timestamps = false;

    protected $fillable = ['id', 'name'];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profile_subscription', null, 'profile_id');
    }
}
