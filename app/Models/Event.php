<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'description',
        'event_type',
        'reward_mode',
        'fixed_reward',
        'reward_percentage',
        'submission_time',
        'judging_time',
        'owner_type',
        'owner_id',
        'owner_name',
    ];

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
