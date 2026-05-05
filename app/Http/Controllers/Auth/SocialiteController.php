<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Supported OAuth providers.
     */
    private const SUPPORTED_PROVIDERS = ['google', 'github'];

    /**
     * Redirect the user to the provider's OAuth page.
     */
    public function redirect(string $provider)
    {
        $this->abortIfUnsupported($provider);
        $this->abortIfNotConfigured($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from the OAuth provider.
     */
    public function callback(string $provider)
    {
        $this->abortIfUnsupported($provider);
        $this->abortIfNotConfigured($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {
            Log::error("Socialite [{$provider}] callback error: " . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('login')
                ->withErrors(['email' => __('Unable to authenticate with :provider. Please try again.', [
                    'provider' => ucfirst($provider),
                ])]);
        }

        try {
            $user = $this->findOrCreateUser($provider, $socialUser);
        } catch (\Throwable $e) {
            Log::error("Socialite [{$provider}] user create/update error: " . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('login')
                ->withErrors(['email' => __('Could not create your account. Please try again.')]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended('/');
    }

    /**
     * Find existing user or create a new one from the social provider data.
     */
    private function findOrCreateUser(string $provider, $socialUser): User
    {
        // 1. Try to find by provider + provider_id (returning user via same provider)
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($user) {
            // Update avatar in case it changed
            $user->update([
                'avatar' => $socialUser->getAvatar(),
                'name'   => $socialUser->getName() ?? $socialUser->getNickname() ?? $user->name,
            ]);

            return $user;
        }

        // 2. Try to find by email (user may have registered via email before)
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Link the social provider to the existing account
            $user->update([
                'provider'    => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $socialUser->getAvatar(),
            ]);

            return $user;
        }

        // 3. Create a brand new user
        return User::create([
            'name'              => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
            'email'             => $socialUser->getEmail(),
            'provider'          => $provider,
            'provider_id'       => $socialUser->getId(),
            'avatar'            => $socialUser->getAvatar(),
            'email_verified_at' => now(),
            'password'          => null,
        ]);
    }

    /**
     * Abort if the provider is not in the supported list.
     */
    private function abortIfUnsupported(string $provider): void
    {
        abort_unless(in_array($provider, self::SUPPORTED_PROVIDERS), 404);
    }

    /**
     * Abort if the provider credentials are not configured.
     */
    private function abortIfNotConfigured(string $provider): void
    {
        $clientId = config("services.{$provider}.client_id");
        abort_if(empty($clientId), 404);
    }
}
