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
            <ul class="account-nav">
              <li><a href="{{ route('account') }}" class="menu-link menu-link_active">Dashboard</a></li>
              <li><a href="#" class="menu-link">Profile</a></li>
              <li><a href="#" class="menu-link">My Orders</a></li>
              <li><a href="{{ route('wishlist') }}" class="menu-link">Wishlist</a></li>
              <li><a href="#" class="menu-link">Addresses</a></li>
              <li><a href="#" class="menu-link">Change Password</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="menu-link border-0 bg-transparent p-0 text-uppercase fw-medium">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>

          <div class="col-lg-9">
            <div class="page-content pt-4 pt-lg-5">
              <div class="my-account__dashboard">
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
            </div>
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </div>
  </main>
@endsection
