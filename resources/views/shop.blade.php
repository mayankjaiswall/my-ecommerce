@extends('layouts.app')

@section('title', 'Shop')

@section('content')
  <main>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="products-grid container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Shop All</h2>

        <div class="row">
          @foreach ([
            ['img' => 'product-4.jpg', 'name' => 'Cropped Faux Leather Jacket', 'price' => '$29'],
            ['img' => 'product-5.jpg', 'name' => 'Calvin Shorts', 'price' => '$62'],
            ['img' => 'product-6.jpg', 'name' => 'Kirby T-Shirt', 'price' => '$17'],
            ['img' => 'product-7.jpg', 'name' => 'Cableknit Shawl', 'price' => '$99', 'oldPrice' => '$129'],
            ['img' => 'product-8.jpg', 'name' => 'Cropped Faux Leather Jacket', 'price' => '$29'],
            ['img' => 'product-9.jpg', 'name' => 'Calvin Shorts', 'price' => '$62'],
            ['img' => 'product-10.jpg', 'name' => 'Kirby T-Shirt', 'price' => '$17'],
            ['img' => 'product-11.jpg', 'name' => 'Cableknit Shawl', 'price' => '$99', 'oldPrice' => '$129'],
          ] as $product)
            <div class="col-6 col-md-4 col-lg-3">
              <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                <div class="pc__img-wrapper">
                  <img loading="lazy" src="{{ asset('assets/images/home/demo3/' . $product['img']) }}" width="330"
                    height="400" alt="{{ $product['name'] }}" class="pc__img">
                </div>

                <div class="pc__info position-relative">
                  <h6 class="pc__title">{{ $product['name'] }}</h6>
                  <div class="product-card__price d-flex align-items-center">
                    @isset($product['oldPrice'])
                      <span class="money price-old">{{ $product['oldPrice'] }}</span>
                    @endisset
                    <span class="money price text-secondary">{{ $product['price'] }}</span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </div>
  </main>
@endsection
