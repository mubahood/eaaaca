<?php

namespace App\Http\Middleware;

use Closure;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TwoFactorMiddleware
{
    /**
     * Paths that bypass 2FA entirely (admin-relative paths).
     */
    protected array $excepts = [
        'auth/login',
        'auth/logout',
    ];

    /**
     * Web paths that bypass 2FA (non-admin).
     */
    protected array $webExcepts = [
        '2fa',
        'resend-code',
        'auth/login',
        'auth/logout',
        'auth/register',
        'policy',
    ];

    public function handle(Request $request, Closure $next)
    {
        // If user is not authenticated, let the admin.auth middleware handle it
        $user = Admin::guard()->user();
        if ($user === null) {
            return $next($request);
        }

        // Always pass through 2FA and logout routes
        foreach ($this->excepts as $except) {
            if ($request->is(trim($except, '/'))) {
                return $next($request);
            }
        }

        // Already verified in this session
        if (session('2fa_verified') === true) {
            return $next($request);
        }

        // AJAX / JSON requests: return 403 instead of redirect
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message'  => 'Two-factor authentication required.',
                'redirect' => url('2fa'),
            ], 403);
        }

        // Code exists and not expired → just redirect to verify page
        $code      = session('2fa_code');
        $expiresAt = session('2fa_expires_at');

        if ($code !== null && $expiresAt !== null && now()->timestamp <= $expiresAt) {
            return redirect(url('2fa'));
        }

        // No valid code in session → send a new one then redirect
        $this->sendCode($user);
        return redirect(url('2fa'));
    }

    /**
     * Generate a 6-digit code, store in session and send via email.
     */
    public static function sendCode($user): void
    {
        $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        session([
            '2fa_code'         => $code,
            '2fa_expires_at'   => now()->addMinutes(5)->timestamp,
            '2fa_attempts'     => 0,
            '2fa_last_sent_at' => now()->timestamp,
            '2fa_verified'     => false,
        ]);

        $email = $user->email ?? '';
        if (strlen($email) < 5) {
            Log::error('2FA: user has no valid email address. User ID: ' . $user->id);
            return;
        }

        try {
            \App\Models\Utils::mail_sender([
                'email'   => $email,
                'name'    => $user->name ?? 'User',
                'subject' => 'ARIN-EA — Your Verification Code',
                'body'    => 'Dear ' . ($user->name ?? 'User') . ',<br><br>'
                    . 'Your one-time verification code is:<br><br>'
                    . '<h2 style="letter-spacing:6px;font-size:32px;font-weight:700;">' . $code . '</h2><br>'
                    . 'This code expires in <strong>5 minutes</strong>. Do not share it with anyone.<br><br>'
                    . 'If you did not attempt to sign in, please ignore this email or contact your administrator immediately.<br><br>'
                    . 'Regards,<br>ARIN-EA Platform',
                'view'    => 'mail',
                'data'    => "Your ARIN-EA verification code is: {$code}. It expires in 5 minutes.",
            ]);
        } catch (\Throwable $e) {
            Log::error('2FA email send failed: ' . $e->getMessage());
        }
    }

    /**
     * Clear all 2FA session state (call on logout).
     */
    public static function clearSession(): void
    {
        session()->forget([
            '2fa_code',
            '2fa_expires_at',
            '2fa_attempts',
            '2fa_last_sent_at',
            '2fa_verified',
        ]);
    }
}
