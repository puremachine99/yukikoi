<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Pivot;

class Ember extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'koi_id'];


    public function koi()
    {
        return $this->hasMany(Koi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
