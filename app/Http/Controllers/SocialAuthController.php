<?php

namespace App\Http\Controllers;

use App\Services\Auth\SocialAccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider, SocialAccountService $accounts): RedirectResponse
    {
        try {
            $providerUser = Socialite::driver($provider)->user();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('login')->withErrors([
                'social_login' => 'We could not verify your social sign-in. Please try again.',
            ]);
        }

        try {
            $user = $accounts->findOrCreate($provider, $providerUser);
        } catch (ValidationException $exception) {
            return redirect()->route('login')->withErrors($exception->errors());
        }

        if (! $user->is_active || $user->isAdmin()) {
            return redirect()->route('login')->withErrors([
                'social_login' => 'This account is not permitted to access the app.',
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended(route('account'));
    }
}