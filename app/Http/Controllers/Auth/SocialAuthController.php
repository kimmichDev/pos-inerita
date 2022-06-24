<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleAuth($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $user = User::firstOrCreate(
            [
                "provider_id" => $socialUser->id,
            ],
            [
                "name" => $socialUser->name,
                "provider" => $provider,
                "email" => $socialUser->email,
            ]
        );
        Auth::login($user, true);
        return redirect()->route('pos');
    }
}
