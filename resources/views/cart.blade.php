@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
  <main>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="container text-center">
        <h2 class="section-title mb-3 pb-xl-2 mb-xl-4">Your Cart</h2>

        <svg width="60" height="60" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
          class="mb-4 text-secondary">
          <use href="#icon_cart" />
        </svg>

        <p class="text-secondary mb-4">Your cart is currently empty.</p>

        <a href="{{ route('shop') }}" class="btn-link btn-link_lg default-underline text-uppercase fw-medium">Continue
          Shopping</a>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </div>
  </main>
@endsection
