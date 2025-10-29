<?php

namespace App\Support;

use App\Models\User;

class AchievementConditionEvaluator
{
    public static function meets(User $user, string $condition): bool
    {
        return match ($condition) {
            // Penghasilan / Omzet
            'seller_rookie_income' => $user->total_income >= 20_000_000,
            'seller_pro_income' => $user->total_income >= 100_000_000,
            'seller_veteran_income' => $user->total_income >= 500_000_000,

            // Pengeluaran
            'small_spender' => $user->total_spent >= 10_000_000,
            'big_spender' => $user->total_spent >= 50_000_000,
            'elite_spender' => $user->total_spent >= 100_000_000,

            // Jumlah Koi Dibeli
            'collector_rookie' => $user->total_koi_bought >= 10,
            'collector_pro' => $user->total_koi_bought >= 50,
            'collector_master' => $user->total_koi_bought >= 100,

            // Jumlah Koi Terjual
            'seller_rookie_sold' => $user->total_koi_sold >= 50,
            'seller_pro_sold' => $user->total_koi_sold >= 250,
            'seller_master_sold' => $user->total_koi_sold >= 1_000,

            // Menang dengan Sniping
            'sniper_rookie' => $user->sniper_wins >= 10,
            'sniper_pro' => $user->sniper_wins >= 50,
            'sniper_master' => $user->sniper_wins >= 1_000,

            // Jumlah Buy It Now
            'bin_rookie' => $user->bin_wins >= 10,
            'bin_pro' => $user->bin_wins >= 50,
            'bin_master' => $user->bin_wins >= 1_000,

            // Loyal Customer
            'loyal_rookie' => $user->distinct_auctions_bought >= 10,
            'loyal_pro' => $user->distinct_auctions_bought >= 50,
            'loyal_master' => $user->distinct_auctions_bought >= 1_000,

            // Top Seller
            'top_seller_1' => $user->rank === 1 && $user->role === 'seller',
            'top_seller_2' => $user->rank === 2 && $user->role === 'seller',
            'top_seller_3' => $user->rank === 3 && $user->role === 'seller',
            'top_seller_4_10' => $user->rank >= 4 && $user->rank <= 10 && $user->role === 'seller',

            // Top Buyer
            'top_buyer_1' => $user->rank === 1 && $user->role === 'buyer',
            'top_buyer_2' => $user->rank === 2 && $user->role === 'buyer',
            'top_buyer_3' => $user->rank === 3 && $user->role === 'buyer',
            'top_buyer_4_10' => $user->rank >= 4 && $user->rank <= 10 && $user->role === 'buyer',

            // Premium User
            'premium_user' => (bool) $user->is_premium,

            // Event Participation
            'azukari_rookie' => $user->azukari_participation >= 10,
            'azukari_pro' => $user->azukari_participation >= 30,
            'azukari_master' => $user->azukari_participation >= 50,

            'keeping_contest_rookie' => $user->keeping_contest_participation >= 10,
            'keeping_contest_pro' => $user->keeping_contest_participation >= 30,
            'keeping_contest_master' => $user->keeping_contest_participation >= 50,

            'grow_out_rookie' => $user->grow_out_participation >= 10,
            'grow_out_pro' => $user->grow_out_participation >= 30,
            'grow_out_master' => $user->grow_out_participation >= 50,

            // Top Global
            'top_global_1' => $user->rank === 1 && $user->role === 'buyer',
            'top_global_2' => $user->rank === 2 && $user->role === 'buyer',
            'top_global_3' => $user->rank === 3 && $user->role === 'buyer',

            // Top Local
            'top_local_1' => $user->rank === 1 && $user->role === 'local_buyer',
            'top_local_2' => $user->rank === 2 && $user->role === 'local_buyer',
            'top_local_3' => $user->rank === 3 && $user->role === 'local_buyer',

            // Top Rival
            'top_rival_1' => $user->rank === 1 && $user->role === 'event_buyer',
            'top_rival_2' => $user->rank === 2 && $user->role === 'event_buyer',
            'top_rival_3' => $user->rank === 3 && $user->role === 'event_buyer',

            default => false,
        };
    }
}
