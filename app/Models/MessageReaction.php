<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageReaction extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['message_id', 'user_id', 'emoji'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
