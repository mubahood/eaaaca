<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ config('admin.title') }} &mdash; Verification</title>
    <link rel="shortcut icon" href="{{ url('public/assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/font-awesome/css/font-awesome.min.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #1D55C4;
            --primary-dark: #1644a0;
            --text:         #0f172a;
            --muted:        #64748b;
            --border:       #cbd5e1;
            --bg:           #f1f5f9;
            --white:        #ffffff;
            --success:      #16a34a;
            --danger:       #dc2626;
            --warning:      #d97706;
            --font:         'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        html, body {
            height: 100%;
            font-family: var(--font);
            font-size: 14px;
            color: var(--text);
            background-color: var(--bg);
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Left panel (same as login) */
        .side-panel {
            width: 420px;
            min-width: 420px;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 40px;
        }

        .side-panel-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .side-panel-brand img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .side-panel-brand-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .side-panel-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 0;
        }

        .side-panel-logo {
            width: 120px;
            height: 120px;
            border: 2px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            overflow: hidden;
        }

        .side-panel-logo img { width: 100%; height: 100%; object-fit: contain; }

        .side-panel-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .side-panel-divider {
            width: 40px;
            height: 2px;
            background: rgba(255,255,255,0.35);
            margin: 24px 0;
        }

        .side-panel-sub {
            font-size: 14px;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            max-width: 300px;
        }

        .side-panel-footer {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
        }

        /* Right content area */
        .content-area {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .card {
            width: 100%;
            max-width: 420px;
        }

        .card-header {
            margin-bottom: 28px;
        }

        .card-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.3px;
        }

        .card-header p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 6px;
            line-height: 1.5;
        }

        .card-header p strong {
            color: var(--text);
        }

        /* Alert messages */
        .alert {
            border-radius: 0;
            font-size: 13px;
            padding: 10px 14px;
            border-width: 0;
            border-left: 3px solid transparent;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .alert-danger  { background: #fef2f2; border-left-color: var(--danger);  color: #991b1b; }
        .alert-success { background: #f0fdf4; border-left-color: var(--success); color: #166534; }
        .alert-warning { background: #fffbeb; border-left-color: var(--warning); color: #92400e; }

        /* Code input */
        .code-field {
            margin-bottom: 20px;
        }

        .code-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.3px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .code-input {
            width: 100%;
            height: 52px;
            padding: 0 16px;
            font-family: var(--font);
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 10px;
            text-align: center;
            color: var(--text);
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 0;
            outline: none;
            transition: border-color 0.15s;
            appearance: none;
            -webkit-appearance: none;
        }

        .code-input:focus {
            border-color: var(--primary);
        }

        .code-input::placeholder {
            color: #cbd5e1;
            letter-spacing: 4px;
            font-size: 16px;
            font-weight: 400;
        }

        /* Timer */
        .timer-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .timer-text {
            font-size: 12px;
            color: var(--muted);
        }

        .timer-text span {
            font-weight: 600;
            color: var(--text);
        }

        .timer-text.expired {
            color: var(--danger);
        }

        /* Attempt counter */
        .attempts-indicator {
            display: flex;
            gap: 6px;
        }

        .attempt-dot {
            width: 8px;
            height: 8px;
            background: var(--border);
        }

        .attempt-dot.used {
            background: var(--danger);
        }

        /* Submit button */
        .btn-verify {
            display: block;
            width: 100%;
            height: 44px;
            background: var(--primary);
            color: var(--white);
            font-family: var(--font);
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 0;
            cursor: pointer;
            transition: background-color 0.15s;
            letter-spacing: 0.2px;
        }

        .btn-verify:hover { background: var(--primary-dark); }
        .btn-verify:disabled {
            background: var(--border);
            color: var(--muted);
            cursor: not-allowed;
        }

        /* Footer actions */
        .card-footer-links {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border);
            padding-top: 16px;
        }

        .card-footer-links a {
            font-size: 12px;
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
        }

        .card-footer-links a:hover { text-decoration: underline; }

        .card-footer-links a.logout-link {
            color: var(--muted);
        }

        .card-footer-links a.logout-link:hover {
            color: var(--danger);
        }

        /* Info box */
        .info-box {
            background: #eff6ff;
            border-left: 3px solid var(--primary);
            padding: 10px 14px;
            font-size: 12px;
            color: #1e40af;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .side-panel { display: none; }
            .content-area { padding: 32px 20px; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Left branding panel --}}
    <div class="side-panel">
        <div class="side-panel-brand">
            <img src="{{ url('public/assets/images/logo.png') }}" alt="Logo">
            <span class="side-panel-brand-name">{{ config('admin.name') }}</span>
        </div>

        <div class="side-panel-body">
            <div class="side-panel-logo">
                <img src="{{ url('public/assets/images/arinea.jpeg') }}" alt="ARINEA">
            </div>
            <div class="side-panel-title">Two-Factor Authentication</div>
            <div class="side-panel-divider"></div>
            <div class="side-panel-sub">
                An extra layer of security protects your account from unauthorised access.
                Enter the one-time code sent to your email address to continue.
            </div>
        </div>

        <div class="side-panel-footer">
            &copy; {{ date('Y') }} ARIN-EA. All rights reserved.
        </div>
    </div>

    {{-- Right form area --}}
    <div class="content-area">
        <div class="card">

            <div class="card-header">
                <h1>Verify your identity</h1>
                <p>
                    A 6-digit code was sent to
                    <strong>{{ $user->email }}</strong>.<br>
                    Enter it below to access your account.
                </p>
            </div>

            {{-- Error message --}}
            @if(session('tfa_error'))
                <div class="alert alert-danger">
                    <span class="fa fa-exclamation-circle" style="margin-top:1px;"></span>
                    {{ session('tfa_error') }}
                </div>
            @endif

            {{-- Success message (e.g. resend confirmation) --}}
            @if(session('tfa_success'))
                <div class="alert alert-success">
                    <span class="fa fa-check-circle" style="margin-top:1px;"></span>
                    {{ session('tfa_success') }}
                </div>
            @endif

            {{-- Info: code expiry --}}
            @if($remaining > 0)
                <div class="info-box">
                    <span class="fa fa-clock-o"></span>
                    Your code is valid for <strong id="countdown">{{ $remaining }}</strong> second(s).
                    If not received, check your spam folder or request a new code below.
                </div>
            @else
                <div class="alert alert-warning">
                    <span class="fa fa-clock-o" style="margin-top:1px;"></span>
                    Your code has expired. Please <a href="{{ route('2fa.resend') }}">request a new code</a>.
                </div>
            @endif

            <form action="{{ route('2fa.verify') }}" method="POST" id="tfa-form">
                @csrf

                <div class="code-field">
                    <label for="code">Verification Code</label>
                    <input
                        type="number"
                        id="code"
                        name="code"
                        class="code-input"
                        placeholder="000000"
                        maxlength="6"
                        minlength="6"
                        autocomplete="one-time-code"
                        autofocus
                        required
                        {{ $remaining <= 0 ? 'disabled' : '' }}
                    >
                </div>

                <div class="timer-row">
                    <div class="timer-text {{ $remaining <= 0 ? 'expired' : '' }}">
                        @if($remaining > 0)
                            Expires in <span id="timer-display">{{ gmdate('i:s', $remaining) }}</span>
                        @else
                            Code expired — request a new one
                        @endif
                    </div>
                    <div class="attempts-indicator" title="Verification attempts">
                        @for($i = 0; $i < 3; $i++)
                            <div class="attempt-dot {{ $i < $attempts ? 'used' : '' }}"></div>
                        @endfor
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn-verify"
                    id="submit-btn"
                    {{ ($remaining <= 0 || $attempts >= $maxAttempts) ? 'disabled' : '' }}
                >
                    Verify &amp; Sign In
                </button>

            </form>

            <div class="card-footer-links">
                <a href="{{ route('2fa.resend') }}" id="resend-link">
                    <span class="fa fa-refresh"></span> Resend code
                </a>
                <a href="{{ admin_url('auth/logout') }}" class="logout-link">
                    <span class="fa fa-sign-out"></span> Sign out
                </a>
            </div>

        </div>
    </div>

</div>

<script src="{{ admin_asset('vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script>
    // Countdown timer
    var remaining = {{ $remaining }};
    var timerDisplay = document.getElementById('timer-display');
    var submitBtn    = document.getElementById('submit-btn');
    var codeInput    = document.getElementById('code');

    function formatTime(s) {
        var m = Math.floor(s / 60);
        var sec = s % 60;
        return (m < 10 ? '0' + m : m) + ':' + (sec < 10 ? '0' + sec : sec);
    }

    if (remaining > 0 && timerDisplay) {
        var interval = setInterval(function () {
            remaining--;
            timerDisplay.textContent = formatTime(remaining);
            if (remaining <= 30) {
                timerDisplay.style.color = '#dc2626';
            }
            if (remaining <= 0) {
                clearInterval(interval);
                timerDisplay.textContent = '00:00';
                if (submitBtn)  submitBtn.disabled = true;
                if (codeInput)  codeInput.disabled = true;
                // Show expired warning
                var infoBox = document.querySelector('.info-box');
                if (infoBox) {
                    infoBox.className = 'alert alert-warning';
                    infoBox.innerHTML = '<span class="fa fa-clock-o" style="margin-top:1px;"></span> '
                        + 'Your code has expired. <a href="{{ route('2fa.resend') }}">Request a new code</a>.';
                }
            }
        }, 1000);
    }

    // Only allow numeric input in code field
    if (codeInput) {
        codeInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    }

    // Prevent double-submit
    document.getElementById('tfa-form').addEventListener('submit', function () {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Verifying…';
        }
    });
</script>
</body>
</html>
