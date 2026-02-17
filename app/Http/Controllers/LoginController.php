<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'phone'    => ['required','string','regex:/^(?:\+?62|0|8)[0-9\s\-.]{6,}$/'],
            'password' => ['required','string','min:6','max:100'],
        ]);

        // Normalisasi nomor di sini jika tidak pakai FormRequest:
        $data['phone'] = $this->normalizeIndoPhone($data['phone']);

        $user = User::where('phone_e164', $data['phone'])->first();

        if (
            ! $user ||
            ! Auth::attempt(['email' => $user->email, 'password' => $data['password']], true)
        ) {
            throw ValidationException::withMessages([
                'phone' => 'Kredensial tidak cocok.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/app');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah keluar.');
    }

    private function normalizeIndoPhone(?string $input): ?string
    {
        if (!$input) return null;
        $digits = preg_replace('/\D+/', '', $input);

        if (str_starts_with($digits, '62')) {
            $e164 = $digits;
        } elseif (str_starts_with($digits, '0')) {
            $e164 = '62'.substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $e164 = '62'.$digits;
        } else {
            $e164 = '62'.$digits;
        }
        return $e164;
    }
}
