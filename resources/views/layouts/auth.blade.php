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
</head>
<body class="auth-body">
  <main class="auth-page">
    <div class="auth-page__grid">
      <section class="auth-page__visual d-none d-lg-flex"
        style="background-image: url('{{ asset(trim($__env->yieldContent('auth-image', 'assets/images/home/demo3/category_9.jpg'))) }}')">
        <div class="auth-page__visual-overlay">
          <a href="{{ url('/') }}" class="auth-page__logo" aria-label="{{ config('app.name', 'Laravel') }} home">
            <x-logo light class="auth-page__logo-img" />
          </a>

          <div class="auth-page__visual-text">
            <h6 class="text-uppercase fs-base fw-medium text-white-50 mb-3">@yield('auth-eyebrow', 'My Account')</h6>
            <h2 class="text-white fw-normal mb-3">@yield('auth-heading', 'Welcome')</h2>
            <p class="text-white-50 mb-0">@yield('auth-subheading', '')</p>
          </div>

          <div class="auth-page__badges">
            <span class="auth-page__badge-icon" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 1.667 3.75 4.167v4.958c0 3.158 2.667 6.117 6.25 7.208 3.583-1.091 6.25-4.05 6.25-7.208V4.167L10 1.667Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                <path d="m7.417 9.833 1.75 1.75 3.583-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span class="text-white-50 auth-page__note">Secure checkout-ready account access.</span>
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
