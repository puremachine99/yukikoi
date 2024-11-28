<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'koi_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function koi()
    {
        return $this->belongsTo(Koi::class, 'koi_id');
    }
}
