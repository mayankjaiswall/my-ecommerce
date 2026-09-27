<?php

namespace App\Services\Auth;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function findOrCreate(string $provider, ProviderUser $providerUser): User
    {
        return DB::transaction(function () use ($provider, $providerUser) {
            $socialAccount = SocialAccount::with('user')
                ->where('provider', $provider)
                ->where('provider_user_id', $providerUser->getId())
                ->first();

            if ($socialAccount) {
                return $socialAccount->user;
            }

            $email = $providerUser->getEmail();
            if (! $email) {
                throw ValidationException::withMessages([
                    'social_login' => 'The selected provider did not return an email address.',
                ]);
            }

            if (User::where('email', $email)->exists()) {
                throw ValidationException::withMessages([
                    'social_login' => 'An account with this email already exists. Sign in with your password first.',
                ]);
            }

            $rawUser = method_exists($providerUser, 'getRaw') ? $providerUser->getRaw() : [];
            $verified = ($rawUser['email_verified'] ?? $rawUser['verified_email'] ?? false) === true;
            $user = User::create([
                'name' => $providerUser->getName() ?: Str::before($email, '@'),
                'email' => $email,
                'email_verified_at' => $verified ? now() : null,
                'role_id' => 2,
                'password' => Hash::make(Str::random(64)),
            ]);

            $user->socialAccounts()->create([
                'provider' => $provider,
                'provider_user_id' => $providerUser->getId(),
            ]);

            return $user;
        });
    }
}