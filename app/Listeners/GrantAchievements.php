<?php

namespace App\Listeners;

use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Events\UserActivityUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Support\AchievementConditionEvaluator;

class GrantAchievements
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserActivityUpdated $event)
    {
        $user = $event->user;

        // Achievement checks
        $achievements = Achievement::all();

        foreach ($achievements as $achievement) {
            if (!AchievementConditionEvaluator::meets($user, $achievement->condition)) {
                continue;
            }

            UserAchievement::firstOrCreate([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ]);
        }
    }
}
