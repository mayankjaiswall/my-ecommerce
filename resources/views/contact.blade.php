@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
  <main>
    <div class="container mw-1620 bg-white border-radius-10">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="container">
        <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Contact Us</h2>
        <p class="text-center text-secondary mx-auto" style="max-width: 640px;">
          Have a question about an order, a product, or anything else? Send us a message and our team will get back
          to you as soon as possible.
        </p>

        <div class="row justify-content-center mt-5">
          <div class="col-lg-5 mb-5 mb-lg-0">
            <h6 class="text-uppercase fw-medium mb-3">Get In Touch</h6>
            <p class="mb-2"><strong class="fw-medium">Address:</strong><br>123 Beach Avenue, Surfside City, CA 00000</p>
            <p class="mb-2"><strong class="fw-medium">Email:</strong><br>contact@surfsidemedia.in</p>
            <p class="mb-2"><strong class="fw-medium">Phone:</strong><br>+1 000-000-0000</p>
          </div>

          <div class="col-lg-7">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-4">
                  <label for="name" class="form-label text-uppercase fs-xs fw-medium">Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}" required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6 mb-4">
                  <label for="email" class="form-label text-uppercase fs-xs fw-medium">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email') }}" required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12 mb-4">
                  <label for="subject" class="form-label text-uppercase fs-xs fw-medium">Subject</label>
                  <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                    name="subject" value="{{ old('subject') }}">
                  @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12 mb-4">
                  <label for="message" class="form-label text-uppercase fs-xs fw-medium">Message</label>
                  <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                    rows="5" required>{{ old('message') }}</textarea>
                  @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-dark text-uppercase fw-medium px-5 py-3">
                    Send Message
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </div>
  </main>
@endsection
