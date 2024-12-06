<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Activity;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountViews
{
    public function handle(Request $request, Closure $next)
    {
        // Get koi_id from route parameter
        $koiId = $request->route('id');

        // Check if the user is logged in
        if (Auth::check()) {
            $userId = Auth::id();

            // Check if a view record already exists for the user and koi
            $activityExists = UserActivity::where('user_id', $userId)
                ->where('koi_id', $koiId)
                ->where('activity_type', 'view')
                ->exists();

            if (!$activityExists) {
                // Add a new "view" activity to the activities table
                UserActivity::create([
                    'user_id' => $userId,
                    'koi_id' => $koiId,
                    'activity_type' => 'view',
                ]);
            }
        }

        return $next($request); // Proceed to the next middleware or controller
    }
}
