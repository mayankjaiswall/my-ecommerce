@extends('layouts.app')

@section('content')
<section class="auth-page">
  <div class="auth-page__grid">
    <div class="auth-page__visual d-none d-lg-flex"
      style="background-image: url('{{ asset(trim($__env->yieldContent('auth-image', 'assets/images/home/demo3/category_9.jpg'))) }}')">
      <div class="auth-page__visual-overlay d-flex flex-column justify-content-between h-100">
        <a href="{{ url('/') }}" class="auth-page__logo d-inline-block">
          <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="auth-page__logo-img" />
        </a>

        <div class="auth-page__visual-text">
          <h6 class="text-uppercase fs-base fw-medium text-white-50 mb-3">@yield('auth-eyebrow', 'My Account')</h6>
          <h2 class="text-white fw-normal mb-3">@yield('auth-heading', 'Welcome')</h2>
          <p class="text-white-50 mb-0">@yield('auth-subheading', '')</p>
        </div>

        <div class="auth-page__badges d-flex align-items-center">
          <svg width="28" height="28" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-white flex-shrink-0">
            <use href="#icon_shield" />
          </svg>
          <span class="text-white-50 ms-3 auth-page__note">Your information is safe and encrypted with us.</span>
        </div>
      </div>
    </div>

    <div class="auth-page__form-wrap d-flex align-items-center justify-content-center">
      <div class="auth-page__form w-100">
        @yield('auth-content')
      </div>
    </div>
  </div>
</section>
@endsection
