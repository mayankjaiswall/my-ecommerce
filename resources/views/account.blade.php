@extends('layouts.app')

@section('title', 'My Account')

@section('content')
  <main>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="container my-account">
        <h2 class="page-title text-center mb-3 pb-xl-2 mb-xl-4">My Account</h2>

        <div class="row">
          <div class="col-lg-3">
            <ul class="account-nav account-sidebar" aria-label="Account menu">
              <li>
                <a href="#account-dashboard" class="menu-link menu-link_active" data-account-tab="dashboard">
                  Dashboard
                </a>
              </li>
              <li>
                <a href="#account-profile" class="menu-link" data-account-tab="profile">
                  Profile
                </a>
              </li>
              <li>
                <a href="#account-orders" class="menu-link" data-account-tab="orders">
                  My Orders
                </a>
              </li>
              <li><a href="{{ route('wishlist') }}" class="menu-link">Wishlist</a></li>
              <li>
                <a href="#account-addresses" class="menu-link" data-account-tab="addresses">
                  Addresses
                </a>
              </li>
              <li>
                <a href="#account-password" class="menu-link" data-account-tab="password">
                  Change Password
                </a>
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="menu-link account-sidebar__logout border-0 bg-transparent text-uppercase fw-medium">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>

          <div class="col-lg-9">
            <div class="page-content pt-4 pt-lg-5">
              <div id="account-dashboard" class="my-account__dashboard account-panel is-active" data-account-panel="dashboard">
                <h5 class="text-uppercase fw-medium mb-3">Welcome, {{ $user->name }}</h5>
                <p class="text-secondary mb-4">
                  Welcome back to your Surfside Media account. You can review your account details here and use the
                  account menu as more customer features are added.
                </p>

                <div class="border p-4 p-md-5">
                  <h6 class="text-uppercase fw-medium mb-4">Account Overview</h6>

                  <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                      <span class="d-block text-uppercase fs-xs fw-medium text-secondary mb-2">Name</span>
                      <span class="d-block fw-medium">{{ $user->name }}</span>
                    </div>

                    <div class="col-md-6">
                      <span class="d-block text-uppercase fs-xs fw-medium text-secondary mb-2">Email</span>
                      <span class="d-block fw-medium">{{ $user->email }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <div id="account-profile" class="account-panel" data-account-panel="profile" hidden>
                <h5 class="text-uppercase fw-medium mb-3">Profile</h5>
                <div class="account-info-card">
                  <div>
                    <span class="account-info-card__label">Full Name</span>
                    <span class="account-info-card__value">{{ $user->name }}</span>
                  </div>
                  <div>
                    <span class="account-info-card__label">Email Address</span>
                    <span class="account-info-card__value">{{ $user->email }}</span>
                  </div>
                </div>
              </div>

              <div id="account-orders" class="account-panel" data-account-panel="orders" hidden>
                <h5 class="text-uppercase fw-medium mb-3">My Orders</h5>
                <div class="account-empty-state">
                  <h6 class="text-uppercase fw-medium mb-2">No orders yet</h6>
                  <p class="text-secondary mb-0">Your recent orders will appear here after checkout.</p>
                </div>
              </div>

              <div id="account-addresses" class="account-panel" data-account-panel="addresses" hidden>
                <h5 class="text-uppercase fw-medium mb-3">Addresses</h5>
                <div class="account-empty-state">
                  <h6 class="text-uppercase fw-medium mb-2">No saved addresses</h6>
                  <p class="text-secondary mb-0">Billing and shipping addresses will show here when they are added.</p>
                </div>
              </div>

              <div id="account-password" class="account-panel" data-account-panel="password" hidden>
                <h5 class="text-uppercase fw-medium mb-3">Change Password</h5>
                <div class="account-empty-state">
                  <h6 class="text-uppercase fw-medium mb-2">Password settings</h6>
                  <p class="text-secondary mb-0">Password update controls can be connected here when the backend form is ready.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var tabLinks = document.querySelectorAll('[data-account-tab]');
      var panels = document.querySelectorAll('[data-account-panel]');

      tabLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
          var target = link.getAttribute('data-account-tab');

          event.preventDefault();

          tabLinks.forEach(function (item) {
            item.classList.remove('menu-link_active');
            item.removeAttribute('aria-current');
          });

          panels.forEach(function (panel) {
            var isTarget = panel.getAttribute('data-account-panel') === target;

            panel.hidden = !isTarget;
            panel.classList.toggle('is-active', isTarget);
          });

          link.classList.add('menu-link_active');
          link.setAttribute('aria-current', 'page');
        });
      });
    });
  </script>
@endsection
