<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TwoFactorMiddleware;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    /**
     * Show the 2FA verification form.
     */
    public function show(Request $request)
    {
        // Must be logged in to see 2FA page
        if (!Admin::guard()->check()) {
            return redirect(admin_url('auth/login'));
        }

        // Already verified → send to dashboard
        if (session('2fa_verified') === true) {
            return redirect(admin_url('/'));
        }

        // No code in session → go back to admin, middleware will send one
        if (session('2fa_code') === null) {
            return redirect(admin_url('/'));
        }

        $user      = Admin::guard()->user();
        $expiresAt = session('2fa_expires_at', 0);
        $remaining = max(0, $expiresAt - now()->timestamp);
        $attempts  = session('2fa_attempts', 0);

        return view('two_fa', [
            'user'      => $user,
            'remaining' => $remaining,
            'attempts'  => $attempts,
            'maxAttempts' => 3,
        ]);
    }

    /**
     * Verify the submitted code.
     */
    public function verify(Request $request)
    {
        if (!Admin::guard()->check()) {
            return redirect(admin_url('auth/login'));
        }

        $storedCode = session('2fa_code');
        $expiresAt  = session('2fa_expires_at');
        $attempts   = session('2fa_attempts', 0);

        // Lockout after 3 failed attempts
        if ($attempts >= 3) {
            TwoFactorMiddleware::clearSession();
            Admin::guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(admin_url('auth/login'))
                ->withErrors(['username' => 'Too many failed attempts. Please sign in again.']);
        }

        // Code expired
        if ($storedCode === null || $expiresAt === null || now()->timestamp > $expiresAt) {
            return redirect(url('2fa'))
                ->with('tfa_error', 'Your code has expired. Please request a new one.');
        }

        // Wrong code
        $entered = trim($request->input('code', ''));
        if ($entered !== (string) $storedCode) {
            $newAttempts = $attempts + 1;
            session(['2fa_attempts' => $newAttempts]);

            $remaining = 3 - $newAttempts;
            $message = $remaining > 0
                ? "Invalid code. You have {$remaining} attempt(s) remaining."
                : 'Invalid code. You have no more attempts.';

            return redirect(url('2fa'))->with('tfa_error', $message);
        }

        // ✅ Success — mark as verified, clean up code
        session(['2fa_verified' => true]);
        session()->forget(['2fa_code', '2fa_expires_at', '2fa_attempts', '2fa_last_sent_at']);

        return redirect(admin_url('/'));
    }

    /**
     * Resend a fresh code (rate-limited to once per 60 seconds).
     */
    public function resend(Request $request)
    {
        if (!Admin::guard()->check()) {
            return redirect(admin_url('auth/login'));
        }

        $lastSent = session('2fa_last_sent_at', 0);
        $cooldown = 60; // seconds

        $elapsed = now()->timestamp - $lastSent;
        if ($elapsed < $cooldown) {
            $wait = $cooldown - $elapsed;
            return redirect(url('2fa'))
                ->with('tfa_error', "Please wait {$wait} second(s) before requesting a new code.");
        }

        $user = Admin::guard()->user();

        // Send new code (also resets attempts and expiry)
        TwoFactorMiddleware::sendCode($user);

        return redirect(url('2fa'))
            ->with('tfa_success', 'A new verification code has been sent to your email address.');
    }
}
