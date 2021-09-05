@props([
  'action' => '',
  'method' => 'POST'
])

@php
  $realMethod = null;
  if (strtoupper($method) !== 'POST') {
    $realMethod = $method;
    $method = 'POST';
  }
@endphp

<form action="{{ $action }}" method="{{ $method }}" {{ $attributes }}>
  @csrf
  @if ($realMethod) @method($realMethod) @endif

  {{ $slot }}
</form>
