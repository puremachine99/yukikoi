<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Cart;
use App\Models\User;
use App\Models\Auction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Observers\TransactionItemObserver;
use App\Observers\AuctionObserver;
use App\Observers\AdObserver;

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
        TransactionItem::observe(TransactionItemObserver::class);
        Auction::observe(AuctionObserver::class);
        Ad::observe(AdObserver::class);

        // Jika menggunakan Xendit
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

        View::composer('*', function ($view) {
            $cartCount = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;

            $orderCount = Auth::check() ? TransactionItem::whereHas('koi.auction.user', function ($query) {
                $query->where('id', Auth::id());
            })->where('status', 'menunggu konfirmasi')->count() : 0;

            $view->with(compact('cartCount', 'orderCount'));
        });

    }

}
