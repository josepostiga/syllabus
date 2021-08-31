@props(['condition' => false])

@php
  $status = $condition === true ? 'bg-green-100' : 'bg-red-100';
@endphp

<span {{ $attributes->merge(['class' => 'px-2 inline-flex leading-5 font-semibold rounded-full text-green-800 '.$status]) }}>
  {{ __('properties.statuses.active') }}
</span>
