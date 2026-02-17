<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditEvent extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['user_id', 'action', 'entity_type', 'entity_id', 'data', 'created_at'];
    protected $casts = ['data' => 'array', 'created_at' => 'datetime'];
}
