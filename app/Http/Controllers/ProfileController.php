<?php

namespace App\Http\Controllers;

use App\Models\Koi;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function becomeSeller(Request $request)
    {
        $user = $request->user();
        $user->is_seller = true;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Anda sekarang menjadi seller!');
    }
    public function index(): RedirectResponse
    {

        $user = Auth::user();
        return Redirect::route('profile.show', $user->id);
    }

    public function show($id)
    {
        // Ambil user beserta lelang dan koi yang dimiliki
        $user = User::with([
            'auctions.koi.media' // Ambil auctions, koi dalam auction, dan media koi
        ])->findOrFail($id);
    
        // Ambil lelang-lelang dari user beserta total keuntungannya
        $auctions = $user->auctions;
    
        // Ambil koi-koi dari lelang yang dimiliki oleh user
        $kois = Koi::whereHas('auction', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['media' => function ($query) {
            $query->where('media_type', 'photo'); // Hanya ambil media yang berupa foto
        }])->get();
        
        
    
        // Kembalikan data ke view
        return view('profile.show', compact('user', 'kois', 'auctions'));
    }
    

    /**
     * Display the user's profile form.
     */

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle KTP Photo upload jika ada
        if ($request->hasFile('ktp_photo')) {
            if ($user->ktp_photo) {
                Storage::disk('public')->delete($user->ktp_photo);
            }
            $ktpFile = $request->ktp_photo->store('ktp_photos', 'public');
        } else {
            $ktpFile = $user->ktp_photo;
        }

        // Handle Profile Photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $profileFile = $request->profile_photo->store('profile_photos', 'public');
        } else {
            $profileFile = $user->profile_photo;
        }

        // Update user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'farm_name' => $request->farm_name,
            'address' => $request->address,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'nik' => $request->nik,
            'ktp_photo' => $ktpFile,
            'profile_photo' => $profileFile,
        ]);

        // Reset email_verified_at jika email diubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
