@extends('layouts.auth')

@section('title', 'Create Account')

@section('auth-image', 'assets/images/home/demo3/category_10.jpg')
@section('auth-eyebrow', 'Join Us')
@section('auth-heading', 'Create Your Account')
@section('auth-subheading', 'Sign up to save your favorites, speed through checkout and get first access to new arrivals.')

@section('auth-content')
    <div class="mb-4">
        <h6 class="text-uppercase fs-base fw-medium text-secondary mb-2">Join Us</h6>
        <h2 class="mb-0">Create Account</h2>
    </div>

    <div class="alert alert-danger d-none" data-auth-general-error role="alert"></div>

    <form method="POST" action="{{ route('register') }}" class="auth-form" data-auth-form="register">
        @csrf

        <div class="form-floating mb-3">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                placeholder="Your name">
            <label for="name">{{ __('Full Name') }}</label>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback" data-field-error="name"></div>
        </div>

        <div class="form-floating mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email"
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
                name="password" required autocomplete="new-password" placeholder="Password">
            <label for="password">{{ __('Password') }}</label>
            @include('auth.partials.password-toggle')

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="invalid-feedback" data-field-error="password"></div>
        </div>

        <div class="form-floating mb-4 password-field">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                required autocomplete="new-password" placeholder="Confirm password">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            @include('auth.partials.password-toggle')
            <div class="invalid-feedback" data-field-error="password_confirmation"></div>
        </div>

        <button type="submit" class="btn btn-dark w-100 text-uppercase fw-medium py-3">
            {{ __('Create Account') }}
        </button>

        @if (Route::has('login'))
            <p class="text-center text-secondary mt-4 mb-0">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="btn-link default-underline fw-medium">{{ __('Sign in') }}</a>
            </p>
        @endif
    </form>
@endsection
