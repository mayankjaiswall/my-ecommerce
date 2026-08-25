@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('auth-image', 'assets/images/home/demo3/category_9.jpg')
@section('auth-eyebrow', 'Security Check')
@section('auth-heading', 'Confirm Your Password')
@section('auth-subheading', "This is a secure area of the site. Please confirm your password before continuing.")

@section('auth-content')
    <div class="mb-4">
        <h6 class="text-uppercase fs-base fw-medium text-secondary mb-2">Security Check</h6>
        <h2 class="mb-0">Confirm Password</h2>
        <p class="text-secondary mt-3 mb-0">{{ __('Please confirm your password before continuing.') }}</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <div class="form-floating mb-4 password-field">
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

        <button type="submit" class="btn btn-dark w-100 text-uppercase fw-medium py-3">
            {{ __('Confirm Password') }}
        </button>

        @if (Route::has('password.request'))
            <p class="text-center text-secondary mt-4 mb-0">
                <a href="{{ route('password.request') }}" class="btn-link default-underline fw-medium">{{ __('Forgot Your Password?') }}</a>
            </p>
        @endif
    </form>
@endsection
