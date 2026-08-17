@extends('layouts.app')

@section('title', 'About Us')

@section('content')
  <main>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="container">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">About Surfside Media</h2>

        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <p class="text-secondary mb-4">
              Surfside Media is a fashion label built around effortless, everyday style. We design pieces that move
              with you &mdash; considered fabrics, clean silhouettes, and details that last well beyond a season.
            </p>
            <p class="text-secondary mb-0">
              From our studio on the coast to your doorstep, every collection is put together with care, so you can
              build a wardrobe that feels like it was made for you.
            </p>
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="container">
        <div class="row text-center">
          <div class="col-md-4 mb-4 mb-md-0">
            <h3 class="fw-bold">Quality First</h3>
            <p class="text-secondary">Every piece is checked for fit, fabric, and finish before it ships.</p>
          </div>
          <div class="col-md-4 mb-4 mb-md-0">
            <h3 class="fw-bold">Fast Shipping</h3>
            <p class="text-secondary">Orders are packed and on their way within one business day.</p>
          </div>
          <div class="col-md-4">
            <h3 class="fw-bold">Easy Returns</h3>
            <p class="text-secondary">Not the right fit? Send it back within 30 days, no questions asked.</p>
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="container text-center">
        <a href="{{ route('contact') }}" class="btn-link btn-link_lg default-underline text-uppercase fw-medium">Get
          In Touch</a>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </div>
  </main>
@endsection
