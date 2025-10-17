<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()->route('login')->withErrors([
                'oauth' => __('Gagal menghubungkan akun Google. Silakan coba lagi.'),
            ]);
        }

        if (! $googleUser->getEmail()) {
            return redirect()->route('login')->withErrors([
                'oauth' => __('Akun Google Anda tidak memiliki email yang dapat digunakan.'),
            ]);
        }

        $user = User::query()
            ->where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            $this->syncGoogleDetails($user, $googleUser->getId(), $googleUser->token ?? null, $googleUser->refreshToken ?? null, $googleUser->getAvatar());

            if (! $user->email_verified_at) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }

            if (empty($user->phone_number)) {
                $request->session()->put('google_user', [
                    'user_id' => $user->id,
                    'google_id' => $googleUser->getId(),
                    'token' => $googleUser->token ?? null,
                    'refresh_token' => $googleUser->refreshToken ?? null,
                    'avatar' => $googleUser->getAvatar(),
                ]);

                return redirect()->route('oauth.google.phone');
            }

            Auth::login($user);

            return redirect()->intended(route('home', absolute: false));
        }

        $request->session()->put('google_user', [
            'google_id' => $googleUser->getId(),
            'email' => $googleUser->getEmail(),
            'name' => $googleUser->getName() ?? $googleUser->getNickname(),
            'avatar' => $googleUser->getAvatar(),
            'token' => $googleUser->token ?? null,
            'refresh_token' => $googleUser->refreshToken ?? null,
        ]);

        return redirect()->route('oauth.google.phone');
    }

    /**
     * Show the form to capture the user's phone number.
     */
    public function showPhoneForm(Request $request)
    {
        $googleData = $request->session()->get('google_user');

        if (! $googleData) {
            return redirect()->route('login');
        }

        $prefilled = [
            'name' => $googleData['name'] ?? optional(User::find($googleData['user_id'] ?? null))->name,
            'email' => $googleData['email'] ?? optional(User::find($googleData['user_id'] ?? null))->email,
        ];

        return view('auth.complete-phone', $prefilled);
    }

    /**
     * Persist the phone number and finish the login process.
     */
    public function storePhone(Request $request): RedirectResponse
    {
        $googleData = $request->session()->get('google_user');

        if (! $googleData) {
            return redirect()->route('login');
        }

        $uniqueRule = Rule::unique('users', 'phone_number');

        if (isset($googleData['user_id'])) {
            $uniqueRule = $uniqueRule->ignore($googleData['user_id']);
        }

        $rules = [
            'phone_number' => [
                'required',
                'string',
                'regex:/^[0-9]{10,15}$/',
                $uniqueRule,
            ],
        ];

        $validated = $request->validate($rules);

        if (isset($googleData['user_id'])) {
            $user = User::findOrFail($googleData['user_id']);

            $user->forceFill([
                'phone_number' => $validated['phone_number'],
            ])->save();

            $this->syncGoogleDetails(
                $user,
                $googleData['google_id'] ?? null,
                $googleData['token'] ?? null,
                $googleData['refresh_token'] ?? null,
                $googleData['avatar'] ?? null,
            );
        } else {
            $user = User::create([
                'name' => $googleData['name'] ?? 'Google User',
                'email' => $googleData['email'],
                'phone_number' => $validated['phone_number'],
                'password' => Hash::make(Str::random(40)),
                'profile_photo' => $googleData['avatar'] ?? null,
                'google_id' => $googleData['google_id'] ?? null,
                'google_avatar' => $googleData['avatar'] ?? null,
                'google_token' => $googleData['token'] ?? null,
                'google_refresh_token' => $googleData['refresh_token'] ?? null,
                'email_verified_at' => now(),
            ]);
        }

        $request->session()->forget('google_user');

        Auth::login($user);

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Persist Google tokens and avatar on the user model.
     */
    protected function syncGoogleDetails(User $user, ?string $googleId, ?string $token, ?string $refreshToken, ?string $avatar): void
    {
        $user->forceFill([
            'google_id' => $googleId ?? $user->google_id,
            'google_avatar' => $avatar ?? $user->google_avatar,
            'google_token' => $token ?? $user->google_token,
            'google_refresh_token' => $refreshToken ?? $user->google_refresh_token,
            'profile_photo' => $user->profile_photo ?: $avatar,
        ])->save();
    }
}
