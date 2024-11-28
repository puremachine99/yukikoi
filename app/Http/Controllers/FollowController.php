<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    // Follow a user
    public function follow($userId)
    {
        $user = User::findOrFail($userId);
        $currentUser = Auth::user();

        // Cek apakah user mencoba follow dirinya sendiri
        if ($currentUser->id == $user->id) {
            return redirect()->back()->with('error', 'You cannot follow yourself.');
        }

        // Cek apakah user sudah di-follow
        if ($currentUser->isFollowing($user->id)) {
            return redirect()->back()->with('error', 'You are already following this user.');
        }

        // Tambahkan ke followings
        $currentUser->followings()->attach($user->id);

        return redirect()->back()->with('success', 'You are now following ' . $user->name);
    }

    // Unfollow a user
    public function unfollow($userId)
    {
        $user = User::findOrFail($userId);
        $currentUser = Auth::user();

        // Cek apakah user di-follow sebelumnya
        if (!$currentUser->isFollowing($user->id)) {
            return redirect()->back()->with('error', 'You are not following this user.');
        }

        // Hapus dari followings
        $currentUser->followings()->detach($user->id);

        return redirect()->back()->with('success', 'You have unfollowed ' . $user->name);
    }
}
