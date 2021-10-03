@props(['action' => '', 'method' => 'POST'])

@php
  $realMethod = null;
  if (!in_array(strtoupper($method), ['POST', 'GET'])) {
    $realMethod = $method;
    $method = 'POST';
  }
@endphp

<form action="{{ $action }}" method="{{ $method }}" {{ $attributes }}>
  @csrf
  @if ($realMethod) @method($realMethod) @endif

  {{ $slot }}
</form>
