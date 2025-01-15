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
use App\Models\Chat;
use App\Events\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller
{
    // Menyimpan chat ke database
    public function store(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
            'message' => 'required|string|max:255',
        ]);

        // Simpan data chat ke database
        $chat = new Chat();
        $chat->koi_id = $request->input('koi_id');
        $chat->user_id = Auth::id();
        $chat->message = $request->input('message');

        if ($chat->save()) {
            // Reload chat dengan relasi user untuk memastikan data lengkap
            $chat = Chat::with('user')->find($chat->id);

            // Broadcast event ChatMessage
            broadcast(new ChatMessage($chat))->toOthers();

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
