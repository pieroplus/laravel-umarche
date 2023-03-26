@props([
  'title' => 'titleの初期値',
  'content' => 'contentの初期値です。',
  'message' => 'messageの初期値です。',
])
<head>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div {{ $attributes->merge([
  'class' => 'border-2 shadow-md w-1/4 p-2'
  ]) }} >
  <div>{{ $title }}</div>
  <div>画像</div>
  <div>{{ $content }}</div>
  <div>{{ $message }}</div>
</div>