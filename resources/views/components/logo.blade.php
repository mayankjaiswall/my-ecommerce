@props(['light' => false])

@php
  $badge = $light ? '#ffffff' : '#17171a';
  $wave = $light ? '#17171a' : '#ffffff';
  $word = $light ? '#ffffff' : '#17171a';
  $sub = $light ? '#d8d8db' : '#8a8a8f';
@endphp

<svg {{ $attributes }} width="272" height="64" viewBox="0 0 272 64" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Surfside Media">
  <rect x="0" y="4" width="56" height="56" rx="14" fill="{{ $badge }}" />
  <path d="M14 39c4-6 9-9 14-9s10 3 14 9M14 30c4-6 9-9 14-9s10 3 14 9"
    fill="none" stroke="{{ $wave }}" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round" />

  <text x="72" y="31" font-family="'Jost', sans-serif" font-size="25" font-weight="600" letter-spacing="1.5"
    fill="{{ $word }}">SURFSIDE</text>
  <text x="72" y="49" font-family="'Jost', sans-serif" font-size="11" font-weight="500" letter-spacing="5.5"
    fill="{{ $sub }}">MEDIA</text>
  <rect x="72" y="55" width="27" height="2" fill="{{ $word }}" />
</svg>
