<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemShare extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['user_id', 'item_id', 'platform'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
