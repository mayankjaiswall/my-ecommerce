<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@hasSection('title')@yield('title') - @endif{{ config('app.name', 'Laravel') }}</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="surfside media" />
  <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg+xml">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.gstatic.com/">
  <link
    href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.min.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css" />
  @vite(['resources/js/app.js'])
</head>
<body class="auth-body">
  <main class="auth-page">
    <div class="auth-page__grid">
      @php $authVariant = trim($__env->yieldContent('auth-variant', 'default')); @endphp
      <section class="auth-page__visual d-none d-lg-flex @if($authVariant === 'restricted') auth-page__visual--restricted @endif"
        @if($authVariant !== 'restricted')
        style="background-image: url('{{ asset(trim($__env->yieldContent('auth-image', 'assets/images/home/demo3/category_9.jpg'))) }}')"
        @endif>
        @if($authVariant === 'restricted')
          <svg class="auth-page__visual-watermark" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 2 4 5v6c0 5 3.4 8.7 8 10 4.6-1.3 8-5 8-10V5l-8-3Z" stroke="currentColor" stroke-width="1" stroke-linejoin="round"/>
            <path d="M9.25 12.25 11 14l3.75-4.25" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        @endif
        <div class="auth-page__visual-overlay">
          <a href="{{ url('/') }}" class="auth-page__logo" aria-label="{{ config('app.name', 'Laravel') }} home">
            <x-logo light class="auth-page__logo-img" />
          </a>

          <div class="auth-page__visual-text">
            @if($authVariant === 'restricted')
              <span class="auth-page__restricted-tag">@yield('auth-eyebrow', 'Restricted Access')</span>
            @else
              <h6 class="text-uppercase fs-base fw-medium text-white-50 mb-3">@yield('auth-eyebrow', 'My Account')</h6>
            @endif
            <h2 class="text-white fw-normal mb-3">@yield('auth-heading', 'Welcome')</h2>
            <p class="text-white-50 mb-0">@yield('auth-subheading', '')</p>
          </div>

          <div class="auth-page__badges">
            <span class="auth-page__badge-icon" aria-hidden="true">
              @if($authVariant === 'restricted')
                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect x="4.5" y="9" width="11" height="8" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M6.667 9V6.25a3.333 3.333 0 1 1 6.666 0V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
              @else
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10 1.667 3.75 4.167v4.958c0 3.158 2.667 6.117 6.25 7.208 3.583-1.091 6.25-4.05 6.25-7.208V4.167L10 1.667Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                  <path d="m7.417 9.833 1.75 1.75 3.583-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              @endif
            </span>
            <span class="text-white-50 auth-page__note">@yield('auth-badge-text', 'Secure checkout-ready account access.')</span>
          </div>
        </div>
      </section>

      <section class="auth-page__form-wrap">
        <div class="auth-page__mobile-brand d-lg-none">
          <a href="{{ url('/') }}" aria-label="{{ config('app.name', 'Laravel') }} home">
            <x-logo class="auth-page__mobile-brand-logo" />
          </a>
        </div>

        <div class="auth-page__form">
          @yield('auth-content')
        </div>
      </section>
    </div>
  </main>

  <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
