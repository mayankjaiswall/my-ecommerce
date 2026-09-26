<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Auth\SocialAccountService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    public function login(Request $request, string $provider, SocialAccountService $accounts)
    {
        $validated = $request->validate([
            'access_token' => ['required', 'string', 'max:8192'],
        ]);

        try {
            /** @var \Laravel\Socialite\Two\AbstractProvider $providerDriver */
            $providerDriver = Socialite::driver($provider);
            $providerUser = $providerDriver->userFromToken($validated['access_token']);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'The social provider could not verify this sign-in. Please try again.',
            ], 401);
        }

        $user = $accounts->findOrCreate($provider, $providerUser);

        if (! $user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated.',
            ], 403);
        }

        if ($user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'This account is not permitted to access the app.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $user->createToken('app_user')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
}