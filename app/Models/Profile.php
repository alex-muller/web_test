<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    protected $fillable = ['profile_id', 'email'];

    protected $primaryKey = 'profile_id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function subscriptions() : BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, null, 'profile_id')->withPivot('subscribed_at');
    }
}
