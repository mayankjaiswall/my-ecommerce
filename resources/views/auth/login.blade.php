@extends('layouts.auth')

@section('title', 'Sign In')

@section('auth-image', 'assets/images/home/demo3/category_9.jpg')
@section('auth-eyebrow', 'My Account')
@section('auth-heading', 'Welcome Back')
@section('auth-subheading', 'Sign in to track your orders, manage your wishlist and enjoy a faster checkout.')

@section('auth-content')
    <div class="mb-4">
        <h6 class="text-uppercase fs-base fw-medium text-secondary mb-2">Welcome Back</h6>
        <h2 class="mb-0">Sign In</h2>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @error('social_login')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="alert alert-danger d-none" data-auth-general-error role="alert"></div>

    <form method="POST" action="{{ route('login') }}" class="auth-form" data-auth-form="login">
        @csrf

        <div class="form-floating mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="name@example.com">
            <label for="email">{{ __('Email Address') }}</label>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback" data-field-error="email"></div>
        </div>

        <div class="form-floating mb-3 password-field">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password" placeholder="Password">
            <label for="password">{{ __('Password') }}</label>
            @include('auth.partials.password-toggle')

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback" data-field-error="password"></div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="btn-link default-underline fw-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-dark w-100 text-uppercase fw-medium py-3">
            {{ __('Sign In') }}
        </button>

        <div class="d-flex align-items-center gap-3 my-4" aria-hidden="true">
            <span class="flex-grow-1 border-top"></span>
            <span class="small text-secondary text-uppercase">{{ __('Or continue with') }}</span>
            <span class="flex-grow-1 border-top"></span>
        </div>

        <div class="row g-2">
            <div class="col-6">
                <a href="{{ route('social.redirect', 'google') }}" class="btn btn-outline-dark w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                    <span class="fw-bold" aria-hidden="true">G</span>
                    <span>{{ __('Google') }}</span>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('social.redirect', 'facebook') }}" class="btn btn-outline-dark w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                    <span class="fw-bold" aria-hidden="true">f</span>
                    <span>{{ __('Facebook') }}</span>
                </a>
            </div>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-secondary mt-4 mb-0">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="btn-link default-underline fw-medium">{{ __('Create one') }}</a>
            </p>
        @endif
    </form>
@endsection
