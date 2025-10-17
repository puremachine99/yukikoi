<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();

        if ($driver === 'mysql') {
            $connection->statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RoleHasPermissionsTableSeeder::class,
            UsersTableSeeder::class,
            UserAddressesTableSeeder::class,
            ModelHasRolesTableSeeder::class,
            ModelHasPermissionsTableSeeder::class,
            AchievementsTableSeeder::class,
            UserAchievementsTableSeeder::class,
            EventsTableSeeder::class,
            AuctionsTableSeeder::class,
            KoisTableSeeder::class,
            MediaTableSeeder::class,
            CertificatesTableSeeder::class,
            WishlistsTableSeeder::class,
            FollowsTableSeeder::class,
            ChatsTableSeeder::class,
            EmbersTableSeeder::class,
            BidsTableSeeder::class,
            ActivitiesTableSeeder::class,
            CartsTableSeeder::class,
            TransactionsTableSeeder::class,
            TransactionItemsTableSeeder::class,
            RatingsTableSeeder::class,
            StatusHistoriesTableSeeder::class,
            AdsTableSeeder::class,
            CacheTableSeeder::class,
            CacheLocksTableSeeder::class,
            ComplaintsTableSeeder::class,
            FailedJobsTableSeeder::class,
            JobBatchesTableSeeder::class,
            JobsTableSeeder::class,
            LihatsTableSeeder::class,
            LikesTableSeeder::class,
            OtpsTableSeeder::class,
            SellerBalancesTableSeeder::class,
            SessionsTableSeeder::class,
            SubscriptionsTableSeeder::class,
        ]);

        if ($driver === 'mysql') {
            $connection->statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
