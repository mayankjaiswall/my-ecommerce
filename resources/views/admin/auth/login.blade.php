<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="admin-body">
    <main class="admin-login-page">
        <span class="admin-login-orb admin-login-orb--one" aria-hidden="true"></span>
        <span class="admin-login-orb admin-login-orb--two" aria-hidden="true"></span>

        <div>
            <div class="admin-login-card">
                <div class="admin-login-badge">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2 4 5.5v6.03c0 5.24 3.4 9.9 8 11.47 4.6-1.57 8-6.23 8-11.47V5.5L12 2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                        <path d="m8.5 12.3 2.4 2.4 4.6-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <p class="admin-login-eyebrow">{{ config('app.name', 'Laravel') }}</p>
                <h1 class="admin-login-title">Admin Portal</h1>
                <p class="admin-login-subtitle">Sign in with your administrator credentials to continue.</p>

                @if ($errors->any())
                    <div class="admin-login-alert" role="alert">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;margin-top:1px">
                            <path d="M10 6.667v3.75M10 13.75h.008M17.5 10a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" novalidate>
                    @csrf

                    <div class="admin-field">
                        <label for="email">Email address</label>
                        <div class="admin-input-wrap">
                            <span class="admin-input-icon">
                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 5.833A1.667 1.667 0 0 1 4.167 4.167h11.666A1.667 1.667 0 0 1 17.5 5.833v8.334a1.667 1.667 0 0 1-1.667 1.666H4.167A1.667 1.667 0 0 1 2.5 14.167V5.833Z" stroke="currentColor" stroke-width="1.4"/>
                                    <path d="m3.333 5.833 6.667 5 6.667-5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" class="admin-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="you@company.com" required autofocus autocomplete="email">
                        </div>
                    </div>

                    <div class="admin-field">
                        <label for="password">Password</label>
                        <div class="admin-input-wrap">
                            <span class="admin-input-icon">
                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 9.167V6.25a5 5 0 0 1 10 0v2.917M4.167 9.167h11.666c.92 0 1.667.746 1.667 1.666v5a1.667 1.667 0 0 1-1.667 1.667H4.167A1.667 1.667 0 0 1 2.5 15.833v-5c0-.92.746-1.666 1.667-1.666Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" class="admin-input @error('password') is-invalid @enderror"
                                placeholder="Enter your password" required autocomplete="current-password">
                            <button type="button" class="admin-password-toggle" data-admin-password-toggle aria-label="Show password" aria-pressed="false">
                                <svg class="admin-icon-eye" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.667 10S4.583 4.167 10 4.167 18.333 10 18.333 10 15.417 15.833 10 15.833 1.667 10 1.667 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <svg class="admin-icon-eye-off d-none" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none">
                                    <path d="M8.111 4.24A8.913 8.913 0 0 1 10 4.167c5.417 0 8.333 5.833 8.333 5.833a15.29 15.29 0 0 1-1.822 2.61m-2.36 2.088A8.567 8.567 0 0 1 10 15.833c-5.417 0-8.333-5.833-8.333-5.833a15.234 15.234 0 0 1 3.14-4.163m2.294-1.507L2.5 1.667m10.9 10.9L17.5 18.333M8.821 8.821a2.5 2.5 0 0 0 3.536 3.536" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="admin-login-row">
                        <label class="admin-checkbox">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="admin-btn-primary">
                        Sign In
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666M10.833 5l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>

                <p class="admin-login-footer">
                    <a href="{{ url('/') }}">&larr; Back to store</a>
                </p>
            </div>

            <p class="admin-login-note">
                <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 1.667 3.75 4.167v4.958c0 3.158 2.667 6.117 6.25 7.208 3.583-1.091 6.25-4.05 6.25-7.208V4.167L10 1.667Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                </svg>
                Restricted area &mdash; authorized administrators only
            </p>
        </div>
    </main>

    <script>
        document.querySelectorAll('[data-admin-password-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var wrap = btn.closest('.admin-input-wrap');
                var input = wrap.querySelector('input');
                var showing = input.type === 'password';
                input.type = showing ? 'text' : 'password';
                btn.querySelector('.admin-icon-eye').style.display = showing ? 'none' : '';
                btn.querySelector('.admin-icon-eye-off').style.display = showing ? '' : 'none';
                btn.setAttribute('aria-pressed', String(showing));
            });
        });
    </script>
</body>
</html>
