@props([
  'filename' => null,
  'type' => null,
])
@php
  if ($type === 'shops') {
    $path = 'storage/shops/';
  }
  if ($type === 'products') {
    $path = 'storage/products/';
  }
@endphp
@if(empty($filename))
  <img src="{{ asset('images/no_image.jpg') }}">
@else
  <img src="{{ asset($path . $filename) }}">										
@endif