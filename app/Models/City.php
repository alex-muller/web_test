<?php

namespace App\Models;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'state_id'];

    public function state() : BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
