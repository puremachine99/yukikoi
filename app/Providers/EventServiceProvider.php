<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use App\Events\UserActivityUpdated;
use App\Listeners\GrantAchievements;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserActivityUpdated::class => [
            GrantAchievements::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       
    }
}
