<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['name', 'icon', 'badge_color', 'description', 'condition'];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements');
    }
}
