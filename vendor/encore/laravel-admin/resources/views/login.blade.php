<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ config('admin.title') }} &mdash; Sign In</title>
    <link rel="shortcut icon" href="{{ url('public/assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('vendor/laravel-admin/font-awesome/css/font-awesome.min.css') }}">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #1D55C4;
            --primary-dark: #1644a0;
            --text: #0f172a;
            --muted: #64748b;
            --border: #cbd5e1;
            --bg: #f1f5f9;
            --white: #ffffff;
            --error: #dc2626;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
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

        /* Left panel */
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

        .login-panel-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-panel-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .login-panel-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            max-width: 300px;
        }

        .login-panel-divider {
            width: 40px;
            height: 2px;
            background: rgba(255,255,255,0.35);
            margin: 24px 0;
        }

        .login-panel-footer {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
        }

        /* Right panel (form area) */
        .login-form-area {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .login-card-header {
            margin-bottom: 32px;
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
        }

        .form-field {
            margin-bottom: 16px;
        }

        .form-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.3px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .form-field .input-wrap {
            position: relative;
        }

        .form-field .input-wrap .input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 14px;
            pointer-events: none;
        }

        .form-field input {
            width: 100%;
            height: 42px;
            padding: 0 12px 0 38px;
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

        .field-error {
            font-size: 12px;
            color: var(--error);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .alert-error {
            background: #fef2f2;
            border-left: 3px solid var(--error);
            padding: 10px 14px;
            font-size: 13px;
            color: var(--error);
            margin-bottom: 20px;
        }

        .btn-login {
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

        .btn-login:hover {
            background: var(--primary-dark);
        }

        .btn-login:active {
            background: #1236882;
        }

        .login-footer-links {
            margin-top: 20px;
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

        .login-footer-links a:hover {
            text-decoration: underline;
        }

        .divider-line {
            border: none;
            border-top: 1px solid var(--border);
            margin: 28px 0;
        }

        .login-copyright {
            font-size: 11px;
            color: var(--muted);
            text-align: center;
            margin-top: 32px;
        }

        /* Password toggle */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 14px;
            padding: 0;
            line-height: 1;
        }

        .toggle-password:hover {
            color: var(--text);
        }

        .form-field .input-wrap input[type="password"],
        .form-field .input-wrap input[type="text"].password-field {
            padding-right: 38px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-panel {
                display: none;
            }

            .login-form-area {
                padding: 32px 20px;
            }
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
                <div class="login-panel-subtitle">A centralised platform for managing cases, projects, and inter-agency information exchange across member states.</div>
            </div>

            <div class="login-panel-footer">
                &copy; {{ date('Y') }} ARIN-EA. All rights reserved.
            </div>
        </div>

        {{-- Right form panel --}}
        <div class="login-form-area">
            <div class="login-card">

                <div class="login-card-header">
                    <h1>Welcome to the ARINEA Information Exchange Platform</h1>
                    <p>Enter your credentials to access the platform.</p>
                </div>

                @if(session('error'))
                    <div class="alert-error">{{ session('error') }}</div>
                @endif

                <form action="{{ admin_url('auth/login') }}" method="post" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="remember" value="1">

                    {{-- Username --}}
                    <div class="form-field">
                        <label for="username">Username or Email</label>
                        <div class="input-wrap">
                            <span class="input-icon fa fa-user"></span>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Enter your username"
                                class="{{ $errors->has('username') ? 'has-error' : '' }}"
                                autocomplete="username"
                                autofocus
                            >
                        </div>
                        @if($errors->has('username'))
                            <div class="field-error">
                                <span class="fa fa-exclamation-circle"></span>
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="form-field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon fa fa-lock"></span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                class="{{ $errors->has('password') ? 'has-error' : '' }}"
                                autocomplete="current-password"
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword()" title="Show/hide password">
                                <span class="fa fa-eye" id="toggleIcon"></span>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <div class="field-error">
                                <span class="fa fa-exclamation-circle"></span>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">Sign In</button>

                </form>

                <hr class="divider-line">

                <div class="login-footer-links">
                    <a href="{{ url('policy') }}">Privacy Policy</a>
                    <a href="{{ url('auth/register') }}">Request Access</a>
                </div>

                <div class="login-copyright">
                    &copy; {{ date('Y') }} ARIN-EA &mdash; East Africa Regional Information Network
                </div>

            </div>
        </div>

    </div>

    <script src="{{ admin_asset('vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        function togglePassword() {
            var input = document.getElementById('password');
            var icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fa fa-eye';
            }
        }
    </script>
</body>
</html>
