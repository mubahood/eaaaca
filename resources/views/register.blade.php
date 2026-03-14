<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ config('admin.title') }} &mdash; Request Access</title>
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
            --primary-light:#e8effe;
            --text:         #0f172a;
            --muted:        #64748b;
            --border:       #cbd5e1;
            --bg:           #f1f5f9;
            --white:        #ffffff;
            --error:        #dc2626;
            --success:      #16a34a;
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

        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── Left panel ── */
        .login-panel {
            width: 420px;
            min-width: 420px;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 40px;
        }

        .login-panel-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .login-panel-brand img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .login-panel-brand-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .login-panel-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 0;
        }

        .login-panel-logo {
            width: 120px;
            height: 120px;
            border: 2px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            overflow: hidden;
        }

        .login-panel-logo img { width: 100%; height: 100%; object-fit: contain; }

        .login-panel-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .login-panel-divider {
            width: 40px;
            height: 2px;
            background: rgba(255,255,255,0.35);
            margin: 24px 0;
        }

        .login-panel-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            max-width: 300px;
        }

        .login-panel-footer {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
        }

        /* ── Right form area ── */
        .login-form-area {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            overflow-y: auto;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            padding: 8px 0;
        }

        .login-card-header {
            margin-bottom: 28px;
        }

        .login-card-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.3px;
        }

        .login-card-header p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 6px;
            line-height: 1.5;
        }

        /* Section divider */
        .form-section {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--muted);
            margin: 20px 0 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--border);
        }

        /* Fields */
        .form-field {
            margin-bottom: 14px;
        }

        .form-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.3px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .form-field .input-wrap {
            position: relative;
        }

        .form-field .input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 13px;
            pointer-events: none;
        }

        .form-field input {
            width: 100%;
            height: 40px;
            padding: 0 12px 0 36px;
            font-family: var(--font);
            font-size: 14px;
            color: var(--text);
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 0;
            outline: none;
            transition: border-color 0.15s;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-field input:focus {
            border-color: var(--primary);
        }

        .form-field input.has-error {
            border-color: var(--error);
        }

        /* Password fields need right padding for toggle */
        .form-field input[type="password"],
        .form-field input.pw-field {
            padding-right: 38px;
        }

        .toggle-pw {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 13px;
            padding: 0;
            line-height: 1;
        }

        .toggle-pw:hover { color: var(--text); }

        .field-error {
            font-size: 12px;
            color: var(--error);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Two-column layout for paired fields */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* Password strength */
        .pw-strength {
            margin-top: 6px;
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .pw-bar {
            height: 3px;
            flex: 1;
            background: var(--border);
            transition: background 0.2s;
        }

        .pw-bar.weak   { background: var(--error); }
        .pw-bar.medium { background: var(--primary-light); }
        .pw-bar.strong { background: var(--success); }

        .pw-label {
            font-size: 11px;
            color: var(--muted);
            min-width: 48px;
            text-align: right;
        }

        /* Submit button */
        .btn-register {
            display: block;
            width: 100%;
            height: 42px;
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
            margin-top: 24px;
        }

        .btn-register:hover { background: var(--primary-dark); }

        /* Footer */
        .divider-line {
            border: none;
            border-top: 1px solid var(--border);
            margin: 24px 0 20px;
        }

        .login-footer-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-footer-links a {
            font-size: 12px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer-links a:hover { text-decoration: underline; }

        .login-copyright {
            font-size: 11px;
            color: var(--muted);
            text-align: center;
            margin-top: 24px;
        }

        /* Note box */
        .info-note {
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
            .login-panel { display: none; }
            .login-form-area { padding: 32px 20px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="login-wrapper">

    {{-- Left branding panel --}}
    <div class="login-panel">
        <div class="login-panel-brand">
            <img src="{{ url('public/assets/images/logo.png') }}" alt="Logo">
            <span class="login-panel-brand-name">{{ config('admin.name') }}</span>
        </div>

        <div class="login-panel-body">
            <div class="login-panel-logo">
                <img src="{{ url('public/assets/images/arinea.jpeg') }}" alt="ARINEA">
            </div>
            <div class="login-panel-title">Welcome to the ARINEA Information Exchange Platform</div>
            <div class="login-panel-divider"></div>
            <div class="login-panel-subtitle">
                Submit your details to request access. Your account will be reviewed and activated by an administrator.
            </div>
        </div>

        <div class="login-panel-footer">
            &copy; {{ date('Y') }} ARIN-EA. All rights reserved.
        </div>
    </div>

    {{-- Right form area --}}
    <div class="login-form-area">
        <div class="login-card">

            <div class="login-card-header">
                <h1>Request Access</h1>
                <p>Fill in the form below. Your account will be activated once verified by an administrator.</p>
            </div>

            <div class="info-note">
                <span class="fa fa-info-circle"></span>
                After submitting, you will receive a confirmation email once your account is approved.
            </div>

            <form action="{{ admin_url('auth/login') }}" method="post" id="register-form" autocomplete="off" novalidate>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="remember" value="1">

                {{-- Personal --}}
                <div class="form-section">Personal Information</div>

                <div class="form-field">
                    <label for="name">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon fa fa-user"></span>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            class="{{ $errors->has('name') ? 'has-error' : '' }}"
                            autocomplete="name"
                            autofocus
                        >
                    </div>
                    @if($errors->has('name'))
                        <div class="field-error">
                            <span class="fa fa-exclamation-circle"></span>
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                {{-- Organisation --}}
                <div class="form-section">Organisation</div>

                <div class="form-field">
                    <label for="bank_name">Organisation Name</label>
                    <div class="input-wrap">
                        <span class="input-icon fa fa-building"></span>
                        <input
                            type="text"
                            id="bank_name"
                            name="bank_name"
                            value="{{ old('bank_name') }}"
                            placeholder="Name of your organisation or agency"
                        >
                    </div>
                </div>

                <div class="form-field">
                    <label for="email">Organisation Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon fa fa-envelope"></span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="official@organisation.com"
                            class="{{ $errors->has('email') ? 'has-error' : '' }}"
                            autocomplete="email"
                        >
                    </div>
                    @if($errors->has('email'))
                        <div class="field-error">
                            <span class="fa fa-exclamation-circle"></span>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                {{-- Account --}}
                <div class="form-section">Set Password</div>

                <div class="form-row">
                    <div class="form-field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon fa fa-lock"></span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Min. 6 characters"
                                class="pw-field {{ $errors->has('password') ? 'has-error' : '' }}"
                                autocomplete="new-password"
                            >
                            <button type="button" class="toggle-pw" onclick="togglePw('password','icon-pw1')" tabindex="-1">
                                <span class="fa fa-eye" id="icon-pw1"></span>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <div class="field-error">
                                <span class="fa fa-exclamation-circle"></span>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <div class="pw-strength" id="pw-strength">
                            <div class="pw-bar" id="bar1"></div>
                            <div class="pw-bar" id="bar2"></div>
                            <div class="pw-bar" id="bar3"></div>
                            <span class="pw-label" id="pw-label"></span>
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="password_1">Confirm Password</label>
                        <div class="input-wrap">
                            <span class="input-icon fa fa-lock"></span>
                            <input
                                type="password"
                                id="password_1"
                                name="password_1"
                                placeholder="Re-enter password"
                                class="pw-field {{ $errors->has('password_1') ? 'has-error' : '' }}"
                                autocomplete="new-password"
                            >
                            <button type="button" class="toggle-pw" onclick="togglePw('password_1','icon-pw2')" tabindex="-1">
                                <span class="fa fa-eye" id="icon-pw2"></span>
                            </button>
                        </div>
                        @if($errors->has('password_1'))
                            <div class="field-error">
                                <span class="fa fa-exclamation-circle"></span>
                                {{ $errors->first('password_1') }}
                            </div>
                        @endif
                        <div id="pw-match" style="font-size:12px;margin-top:4px;"></div>
                    </div>
                </div>

                <button type="submit" class="btn-register" id="submit-btn">
                    Submit Registration Request
                </button>

            </form>

            <hr class="divider-line">

            <div class="login-footer-links">
                <a href="{{ url('policy') }}">Privacy Policy</a>
                <a href="{{ admin_url('auth/login') }}">Already have an account? Sign in</a>
            </div>

            <div class="login-copyright">
                &copy; {{ date('Y') }} ARIN-EA &mdash; East Africa Regional Information Network
            </div>

        </div>
    </div>

</div>

<script src="{{ admin_asset('vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script>
    // Password show / hide toggle
    function togglePw(inputId, iconId) {
        var input = document.getElementById(inputId);
        var icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fa fa-eye';
        }
    }

    // Password strength meter
    document.getElementById('password').addEventListener('input', function () {
        var val    = this.value;
        var bar1   = document.getElementById('bar1');
        var bar2   = document.getElementById('bar2');
        var bar3   = document.getElementById('bar3');
        var label  = document.getElementById('pw-label');
        var score  = 0;

        if (val.length >= 6)                             score++;
        if (val.length >= 10)                            score++;
        if (/[A-Z]/.test(val) && /[0-9!@#$%^&*]/.test(val)) score++;

        bar1.className = 'pw-bar';
        bar2.className = 'pw-bar';
        bar3.className = 'pw-bar';
        label.textContent = '';

        if (val.length === 0) return;

        if (score === 1) {
            bar1.className = 'pw-bar weak';
            label.textContent = 'Weak';
            label.style.color = '#dc2626';
        } else if (score === 2) {
            bar1.className = 'pw-bar medium';
            bar2.className = 'pw-bar medium';
            label.textContent = 'Fair';
            label.style.color = '#1D55C4';
        } else {
            bar1.className = 'pw-bar strong';
            bar2.className = 'pw-bar strong';
            bar3.className = 'pw-bar strong';
            label.textContent = 'Strong';
            label.style.color = '#16a34a';
        }
    });

    // Password match indicator
    document.getElementById('password_1').addEventListener('input', function () {
        var p1     = document.getElementById('password').value;
        var p2     = this.value;
        var match  = document.getElementById('pw-match');
        var input2 = document.getElementById('password_1');

        if (p2.length === 0) {
            match.textContent = '';
            input2.style.borderColor = '';
            return;
        }

        if (p1 === p2) {
            match.innerHTML = '<span style="color:#16a34a"><i class="fa fa-check"></i> Passwords match</span>';
            input2.style.borderColor = '#16a34a';
        } else {
            match.innerHTML = '<span style="color:#dc2626"><i class="fa fa-times"></i> Passwords do not match</span>';
            input2.style.borderColor = '#dc2626';
        }
    });

    // Client-side validation before submit
    document.getElementById('register-form').addEventListener('submit', function (e) {
        var name  = document.getElementById('name').value.trim();
        var email = document.getElementById('email').value.trim();
        var pw    = document.getElementById('password').value;
        var pw2   = document.getElementById('password_1').value;
        var errors = [];

        if (name.length < 3)  errors.push('Please enter your full name.');
        if (email.length < 5) errors.push('Please enter a valid email address.');
        if (pw.length < 6)    errors.push('Password must be at least 6 characters.');
        if (pw !== pw2)       errors.push('Passwords do not match.');

        if (errors.length > 0) {
            e.preventDefault();
            var existing = document.getElementById('client-error');
            if (existing) existing.remove();
            var box = document.createElement('div');
            box.id = 'client-error';
            box.style.cssText = 'background:#fef2f2;border-left:3px solid #dc2626;padding:10px 14px;font-size:13px;color:#991b1b;margin-bottom:16px;';
            box.innerHTML = errors.map(function(e){ return '<div><i class="fa fa-exclamation-circle"></i> ' + e + '</div>'; }).join('');
            document.getElementById('register-form').insertBefore(box, document.getElementById('register-form').firstChild);
            window.scrollTo(0, box.getBoundingClientRect().top + window.scrollY - 20);
            return;
        }

        var btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.textContent = 'Submitting…';
    });
</script>
</body>
</html>
