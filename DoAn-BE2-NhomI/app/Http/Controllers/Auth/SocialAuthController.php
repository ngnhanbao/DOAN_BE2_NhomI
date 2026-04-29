<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Tìm user theo email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Nếu user đã tồn tại, cập nhật provider_id
                $user->update([
                    'provider' => 'google',
                    'provider_id' => $googleUser->id,
                    'avatar_url' => $user->avatar_url ?? $googleUser->avatar,
                ]);
            } else {
                // Nếu chưa có thì tạo mới
                $user = User::create([
                    'full_name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'provider' => 'google',
                    'provider_id' => $googleUser->id,
                    'avatar_url' => $googleUser->avatar,
                    'role' => 'user',
                    'is_active' => 1,
                    'is_verified' => 1,
                ]);
            }

            Auth::login($user);
            return redirect('/');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Đăng nhập Google thất bại!');
        }
    }
}