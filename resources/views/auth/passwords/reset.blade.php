@extends('layouts.auth')

@section('title', 'Reset Password')

@section('auth-image', 'assets/images/home/demo3/category_9.jpg')
@section('auth-eyebrow', 'Account Recovery')
@section('auth-heading', 'Choose a New Password')
@section('auth-subheading', 'Make it strong — a good mix of letters, numbers and symbols keeps your account safe.')

@section('auth-content')
    <div class="mb-4">
        <h6 class="text-uppercase fs-base fw-medium text-secondary mb-2">Account Recovery</h6>
        <h2 class="mb-0">Reset Password</h2>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-floating mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                placeholder="name@example.com">
            <label for="email">{{ __('Email Address') }}</label>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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
        </div>

        <div class="form-floating mb-4 password-field">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                required autocomplete="new-password" placeholder="Confirm password">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            @include('auth.partials.password-toggle')
        </div>

        <button type="submit" class="btn btn-dark w-100 text-uppercase fw-medium py-3">
            {{ __('Reset Password') }}
        </button>
    </form>
@endsection
