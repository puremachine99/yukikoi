<?php

// namespace App\Http\Controllers;

// use App\Models\Koi;
// use App\Models\Chat;
// use App\Events\ChatMessage;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Broadcast;

// class ChatController extends Controller
// {
//     // Menyimpan chat ke database
//     public function store(Request $request)
//     {
//         $request->validate([
//             'koi_id' => 'required|exists:kois,id',
//             'message' => 'required|string|max:255',
//         ]);

//         // Simpan data chat ke database
//         $chat = new Chat();
//         $chat->koi_id = $request->input('koi_id');
//         $chat->user_id = Auth::id();
//         $chat->message = $request->input('message');

//         if ($chat->save()) {
//             // Broadcast event ChatMessage
//             broadcast(new ChatMessage($chat))->toOthers();

//             return response()->json([
//                 'success' => true,
//                 'chat' => $chat
//             ]);
//         } else {
//             return response()->json(['success' => false], 500);
//         }
//     }



//     // Mengambil chat dan bid untuk ditampilkan di halaman
//     public function getHistory($koiId)
//     {
//         // Mengambil semua chat dan bid berdasarkan koi_id
//         $chats = Chat::where('koi_id', $koiId)->with('user')->get();
//         $bids = Koi::find($koiId)->bids()->with('user')->get();

//         // Gabungkan chat dan bid
//         $history = $chats->merge($bids)->sortBy('created_at');

//         return response()->json($history);
//     }
// } 


namespace App\Http\Controllers;

use App\Models\Koi;
use Illuminate\Support\Facades\RateLimiter;

use App\Events\ChatMessage;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // Menyimpan chat ke database
    public function store(Request $request)
{
    $key = 'chat-action:' . Auth::id();

    // Rate limiter untuk chat
    if (RateLimiter::tooManyAttempts($key, 10)) {
        $seconds = RateLimiter::availableIn($key);
        return response()->json([
            'success' => false,
            'message' => "Anda telah mencapai batas pengiriman chat. Coba lagi dalam $seconds detik.",
        ], 429);
    }

    $request->validate([
        'koi_id' => 'required|exists:kois,id',
        'message' => 'required|string|max:255',
    ]);

    $chat = new Chat();
    $chat->koi_id = $request->input('koi_id');
    $chat->user_id = Auth::id();
    $chat->message = $request->input('message');

    if ($chat->save()) {
        // Broadcast pesan chat
        $chat = Chat::with('user')->find($chat->id);

        try {
            broadcast(new ChatMessage($chat))->toOthers();
        } catch (BroadcastException $exception) {
            Log::warning('Broadcast chat failed', [
                'koi_id' => $chat->koi_id,
                'chat_id' => $chat->id,
                'error' => $exception->getMessage(),
            ]);
        }

        // Hit rate limiter untuk mencatat percobaan
        RateLimiter::hit($key, 60); // Batas reset setelah 60 detik

        return response()->json([
            'success' => true,
            'chat' => $chat
        ]);
    } else {
        return response()->json(['success' => false], 500);
    }
}

    // Mengambil chat dan bid untuk ditampilkan di halaman
    public function getHistory($koiId)
    {
        // Mengambil semua chat dan bid berdasarkan koi_id
        $chats = Chat::where('koi_id', $koiId)->with('user')->get();
        $bids = Koi::find($koiId)->bids()->with('user')->get();

        // Gabungkan chat dan bid
        $history = $chats->merge($bids)->sortBy('created_at');

        return response()->json($history);
    }
}
