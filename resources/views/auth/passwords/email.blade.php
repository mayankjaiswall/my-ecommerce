@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('auth-image', 'assets/images/home/demo3/category_9.jpg')
@section('auth-eyebrow', 'Account Recovery')
@section('auth-heading', 'Forgot Your Password?')
@section('auth-subheading', "No worries. Enter the email you signed up with and we'll send you a link to reset it.")

@section('auth-content')
    <div class="mb-4">
        <h6 class="text-uppercase fs-base fw-medium text-secondary mb-2">Account Recovery</h6>
        <h2 class="mb-0">Reset Password</h2>
        <p class="text-secondary mt-3 mb-0">{{ __('Enter your email address and we will send you a link to reset your password.') }}</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="form-floating mb-4">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="name@example.com">
            <label for="email">{{ __('Email Address') }}</label>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-dark w-100 text-uppercase fw-medium py-3">
            {{ __('Send Password Reset Link') }}
        </button>

        @if (Route::has('login'))
            <p class="text-center text-secondary mt-4 mb-0">
                <a href="{{ route('login') }}" class="btn-link default-underline fw-medium">{{ __('Back to Sign In') }}</a>
            </p>
        @endif
    </form>
@endsection
