@extends('layouts.app')

@section('title', 'Your Wishlist')

@section('content')
  <main>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="container">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Your Wishlist</h2>

        <div class="wishlist-empty text-center py-5" data-wishlist-empty>
          <svg width="60" height="60" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="mb-4">
            <use href="#icon_heart" />
          </svg>
          <p class="text-secondary mb-4">Your wishlist is empty. Save the items you love and they'll show up
            here.</p>
          <a href="{{ route('shop') }}"
            class="btn-link btn-link_lg default-underline text-uppercase fw-medium">Continue Shopping</a>
        </div>

        <div class="row d-none" data-wishlist-list></div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </div>
  </main>

  <template id="wishlist-item-template">
    <div class="col-6 col-md-4 col-lg-3">
      <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5 position-relative">
        <button type="button" class="wishlist-remove-btn" data-wishlist-remove title="Remove From Wishlist">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_close" />
          </svg>
        </button>

        <a class="pc__img-wrapper" data-wishlist-href href="#">
          <img loading="lazy" data-wishlist-image src="" alt="" class="pc__img">
        </a>

        <div class="pc__info position-relative">
          <h6 class="pc__title"><a data-wishlist-href href="#" data-wishlist-title></a></h6>
          <div class="product-card__price d-flex">
            <span class="money price text-secondary" data-wishlist-price></span>
          </div>
        </div>
      </div>
    </div>
  </template>
@endsection
