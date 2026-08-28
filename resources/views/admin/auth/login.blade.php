@extends('layouts.auth')

@section('title', 'Admin Sign In')

@section('auth-image', 'assets/images/home/demo3/category_9.jpg')
@section('auth-eyebrow', 'Admin Portal')
@section('auth-heading', 'Welcome Back, Admin')
@section('auth-subheading', 'Sign in with your administrator credentials to manage the store.')

@section('auth-content')
    <div class="mb-4">
        <h6 class="text-uppercase fs-base fw-medium text-secondary mb-2">Restricted Area</h6>
        <h2 class="mb-0">Admin Sign In</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="auth-form">
        @csrf

        <div class="form-floating mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="you@company.com">
            <label for="email">{{ __('Email Address') }}</label>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember me') }}
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-dark w-100 text-uppercase fw-medium py-3">
            {{ __('Sign In') }}
        </button>
    </form>

    <p class="text-center text-secondary mt-4 mb-0">
        <a href="{{ url('/') }}" class="btn-link default-underline fw-medium">&larr; Back to store</a>
    </p>
@endsection
