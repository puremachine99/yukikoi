<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call(AchievementsTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(AdsTableSeeder::class);
        $this->call(AuctionsTableSeeder::class);
        $this->call(BidsTableSeeder::class);
        $this->call(CacheTableSeeder::class);
        $this->call(CacheLocksTableSeeder::class);
        $this->call(CartsTableSeeder::class);
        $this->call(CertificatesTableSeeder::class);
        $this->call(ChatsTableSeeder::class);
        $this->call(ComplaintsTableSeeder::class);
        $this->call(EmbersTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
        $this->call(JobBatchesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(KoisTableSeeder::class);
        $this->call(LihatsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(OtpsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SellerBalancesTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(StatusHistoriesTableSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(TransactionItemsTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(UserAchievementsTableSeeder::class);
        $this->call(UserAddressesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WishlistsTableSeeder::class);
    }
}
