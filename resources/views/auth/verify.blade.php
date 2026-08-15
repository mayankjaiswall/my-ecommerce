@extends('layouts.auth')

@section('title', 'Verify Email')

@section('auth-image', 'assets/images/home/demo3/category_10.jpg')
@section('auth-eyebrow', 'One Last Step')
@section('auth-heading', 'Verify Your Email')
@section('auth-subheading', "We've sent a verification link to your inbox. Confirm your address to unlock your account.")

@section('auth-content')
    <div class="mb-4">
        <h6 class="text-uppercase fs-base fw-medium text-secondary mb-2">One Last Step</h6>
        <h2 class="mb-0">Verify Your Email</h2>
    </div>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <p class="text-secondary">
        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
    </p>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-dark w-100 text-uppercase fw-medium py-3">
            {{ __('Resend Verification Email') }}
        </button>
    </form>
@endsection
