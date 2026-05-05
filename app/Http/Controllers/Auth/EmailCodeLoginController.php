<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginVerificationCode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailCodeLoginController extends Controller
{
    private const OTP_LENGTH = 4;
    private const SESSION_EMAIL_KEY = 'login_otp.email';
    private const SESSION_HASH_KEY = 'login_otp.code_hash';
    private const SESSION_EXPIRES_AT_KEY = 'login_otp.expires_at';
    private const SESSION_REDIRECT_TO_KEY = 'login_otp.redirect_to';

    public function requestCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $validated['email'];
        $redirectTo = (string) $request->input('redirect_to', '');

        $max = (10 ** self::OTP_LENGTH) - 1;
        $code = str_pad((string) random_int(0, $max), self::OTP_LENGTH, '0', STR_PAD_LEFT);
        $request->session()->put(self::SESSION_EMAIL_KEY, $email);
        $request->session()->put(self::SESSION_HASH_KEY, Hash::make($code));
        $request->session()->put(self::SESSION_EXPIRES_AT_KEY, now()->addMinutes(10)->timestamp);

        if ($redirectTo !== '') {
            $allowedRedirect = route('download', absolute: false);

            if (hash_equals($allowedRedirect, $redirectTo)) {
                redirect()->setIntendedUrl($redirectTo);
            }
        }

        try {
            Mail::to($email)->send(new LoginVerificationCode($code));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('login.code.show');
    }

    public function showVerify(Request $request)
    {
        if (! $request->session()->has(self::SESSION_EMAIL_KEY)) {
            return redirect()->route('login');
        }

        return view('pages::auth.verify-code', [
            'email' => $request->session()->get(self::SESSION_EMAIL_KEY),
        ]);
    }

    public function verifyCode(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:'.self::OTP_LENGTH],
        ]);

        $email = $request->session()->get(self::SESSION_EMAIL_KEY);
        $hash = $request->session()->get(self::SESSION_HASH_KEY);
        $expiresAt = (int) $request->session()->get(self::SESSION_EXPIRES_AT_KEY, 0);

        if (! $email || ! $hash || $expiresAt < now()->timestamp) {
            return redirect()->route('login')->withErrors([
                'email' => __('Your verification code has expired. Please request a new one.'),
            ]);
        }

        if (! Hash::check((string) $request->input('code'), $hash)) {
            return back()->withErrors([
                'code' => __('The verification code is invalid.'),
            ]);
        }

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => __('No account found for that email.'),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $redirectTo = (string) $request->session()->get('url.intended', (string) config('fortify.home'));
        $request->session()->put(self::SESSION_REDIRECT_TO_KEY, $this->sanitizeRedirectTo($redirectTo));
        $request->session()->forget('url.intended');
        $request->session()->forget([
            self::SESSION_EMAIL_KEY,
            self::SESSION_HASH_KEY,
            self::SESSION_EXPIRES_AT_KEY,
        ]);

        return redirect()->route('login.connected');
    }

    public function connected(Request $request): View
    {
        $redirectTo = (string) $request->session()->pull(self::SESSION_REDIRECT_TO_KEY, (string) config('fortify.home'));

        return view('pages::auth.connected', [
            'redirectTo' => $this->sanitizeRedirectTo($redirectTo),
        ]);
    }

    private function sanitizeRedirectTo(string $target): string
    {
        $fallback = (string) config('fortify.home');

        if ($target === '') {
            return $fallback;
        }

        // Only allow internal redirects to a path (prevents open redirects).
        if (str_starts_with($target, '/')) {
            return $target;
        }

        // If something stored an absolute URL, keep only its path/query/fragment.
        $parts = parse_url($target);
        if (! is_array($parts)) {
            return $fallback;
        }

        $path = (string) ($parts['path'] ?? '');
        if ($path === '' || ! str_starts_with($path, '/')) {
            return $fallback;
        }

        $out = $path;
        if (isset($parts['query']) && $parts['query'] !== '') {
            $out .= '?'.$parts['query'];
        }
        if (isset($parts['fragment']) && $parts['fragment'] !== '') {
            $out .= '#'.$parts['fragment'];
        }

        return $out;
    }
}
