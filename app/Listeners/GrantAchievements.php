<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Events\UserActivityUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
            if ($this->meetsCondition($user, $achievement->condition)) {
                // Grant the achievement
                UserAchievement::firstOrCreate([
                    'user_id' => $user->id,
                    'achievement_id' => $achievement->id,
                ]);
            }
        }
    }

    /**
     * Check if a user meets the condition for the achievement.
     */
    public function meetsCondition(User $user, string $condition): bool
{
    switch ($condition) {
        // Penghasilan / Omzet
        case 'seller_rookie_income': // ID 55
            return $user->total_income >= 20000000;
        case 'seller_pro_income': // ID 56
            return $user->total_income >= 100000000;
        case 'seller_veteran_income': // ID 57
            return $user->total_income >= 500000000;

        // Pengeluaran
        case 'small_spender': // ID 58
            return $user->total_spent >= 10000000;
        case 'big_spender': // ID 59
            return $user->total_spent >= 50000000;
        case 'elite_spender': // ID 60
            return $user->total_spent >= 100000000;

        // Jumlah Koi Dibeli
        case 'collector_rookie': // ID 61
            return $user->total_koi_bought >= 10;
        case 'collector_pro': // ID 62
            return $user->total_koi_bought >= 50;
        case 'collector_master': // ID 63
            return $user->total_koi_bought >= 100;

        // Jumlah Koi Terjual
        case 'seller_rookie_sold': // ID 64
            return $user->total_koi_sold >= 50;
        case 'seller_pro_sold': // ID 65
            return $user->total_koi_sold >= 250;
        case 'seller_master_sold': // ID 66
            return $user->total_koi_sold >= 1000;

        // Menang dengan Sniping
        case 'sniper_rookie': // ID 67
            return $user->sniper_wins >= 10;
        case 'sniper_pro': // ID 68
            return $user->sniper_wins >= 50;
        case 'sniper_master': // ID 69
            return $user->sniper_wins >= 1000;

        // Jumlah Buy It Now
        case 'bin_rookie': // ID 70
            return $user->bin_wins >= 10;
        case 'bin_pro': // ID 71
            return $user->bin_wins >= 50;
        case 'bin_master': // ID 72
            return $user->bin_wins >= 1000;

        // Loyal Customer
        case 'loyal_rookie': // ID 73
            return $user->distinct_auctions_bought >= 10;
        case 'loyal_pro': // ID 74
            return $user->distinct_auctions_bought >= 50;
        case 'loyal_master': // ID 75
            return $user->distinct_auctions_bought >= 1000;

        // Top Seller
        case 'top_seller_1': // ID 76
            return $user->rank === 1 && $user->role === 'seller';
        case 'top_seller_2': // ID 77
            return $user->rank === 2 && $user->role === 'seller';
        case 'top_seller_3': // ID 78
            return $user->rank === 3 && $user->role === 'seller';
        case 'top_seller_4_10': // ID 79
            return $user->rank >= 4 && $user->rank <= 10 && $user->role === 'seller';

        // Top Buyer
        case 'top_buyer_1': // ID 80
            return $user->rank === 1 && $user->role === 'buyer';
        case 'top_buyer_2': // ID 81
            return $user->rank === 2 && $user->role === 'buyer';
        case 'top_buyer_3': // ID 82
            return $user->rank === 3 && $user->role === 'buyer';
        case 'top_buyer_4_10': // ID 83
            return $user->rank >= 4 && $user->rank <= 10 && $user->role === 'buyer';

        // Premium User
        case 'premium_user': // ID 84
            return $user->is_premium;

        // Event Participation
        case 'azukari_rookie': // ID 85
            return $user->azukari_participation >= 10;
        case 'azukari_pro': // ID 86
            return $user->azukari_participation >= 30;
        case 'azukari_master': // ID 87
            return $user->azukari_participation >= 50;

        case 'keeping_contest_rookie': // ID 88
            return $user->keeping_contest_participation >= 10;
        case 'keeping_contest_pro': // ID 89
            return $user->keeping_contest_participation >= 30;
        case 'keeping_contest_master': // ID 90
            return $user->keeping_contest_participation >= 50;

        case 'grow_out_rookie': // ID 91
            return $user->grow_out_participation >= 10;
        case 'grow_out_pro': // ID 92
            return $user->grow_out_participation >= 30;
        case 'grow_out_master': // ID 93
            return $user->grow_out_participation >= 50;

        // Top Global
        case 'top_global_1': // ID 94
            return $user->rank === 1 && $user->role === 'buyer';
        case 'top_global_2': // ID 95
            return $user->rank === 2 && $user->role === 'buyer';
        case 'top_global_3': // ID 96
            return $user->rank === 3 && $user->role === 'buyer';

        // Top Local
        case 'top_local_1': // ID 97
            return $user->rank === 1 && $user->role === 'local_buyer';
        case 'top_local_2': // ID 98
            return $user->rank === 2 && $user->role === 'local_buyer';
        case 'top_local_3': // ID 99
            return $user->rank === 3 && $user->role === 'local_buyer';

        // Top Rival
        case 'top_rival_1': // ID 100
            return $user->rank === 1 && $user->role === 'event_buyer';
        case 'top_rival_2': // ID 101
            return $user->rank === 2 && $user->role === 'event_buyer';
        case 'top_rival_3': // ID 102
            return $user->rank === 3 && $user->role === 'event_buyer';

        default:
            return false;
    }
}

}
