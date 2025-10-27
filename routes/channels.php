<?php

use App\Models\Koi;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('koi.{koiId}', function (User $user, $koiId) {
    $koi = Koi::find($koiId);

    // Periksa apakah user diizinkan untuk mengakses lelang ini
    if ($koi && $user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone_number' => substr($user->phone_number, 0, 4) . 'XX' . substr($user->phone_number, -2), // Masking phone number
            'dp' => $user->profile_photo,
            'farm' => $user->farm_name,
        ];
    }

    return false; // Jika tidak diizinkan
});

// Di routes/channels.php
Broadcast::channel('transactions', function ($user) {
    return $user; // Tentukan akses untuk user tertentu jika dibutuhkan
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId; // Hanya user yang sama yang bisa mengakses channel ini
});


Broadcast::channel('auction.{auctionCode}', function ($user, $auctionCode) {
    return true;
});
