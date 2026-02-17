<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FishSpecies extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'description'];
}
