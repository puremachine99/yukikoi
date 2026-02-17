<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Room extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function scope(): MorphTo
    {
        return $this->morphTo();
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
