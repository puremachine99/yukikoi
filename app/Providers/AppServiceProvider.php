<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);

        // pake ngrok nyala
        // if (app()->environment('local', 'staging')) {
        //     URL::forceScheme('https');
        // }
        \Xendit\Configuration::setXenditKey(env('XENDIT_API_KEY'));
        // Hak akses untuk guest
        Gate::define('view-auction', function (User $user = null) {
            return $user === null || $user->isRole(User::ROLE_GUEST);
        });

        // Hak akses untuk bidder
        Gate::define('bid-on-auction', function (User $user) {
            return $user->isRole(User::ROLE_BIDDER) || $user->isRole(User::ROLE_SELLER) || $user->isRole(User::ROLE_PRIORITY_SELLER);
        });

        // Hak akses untuk seller
        Gate::define('create-auction', function (User $user) {
            return $user->isRole(User::ROLE_SELLER) && $user->is_verified;
        });

        // Hak akses untuk seller prioritas
        Gate::define('featured-auction', function (User $user) {
            return $user->isRole(User::ROLE_PRIORITY_SELLER);
        });

        // Hak akses untuk admin
        Gate::define('access-admin-panel', function (User $user) {
            return $user->isRole(User::ROLE_ADMIN);
        });
    }
}
