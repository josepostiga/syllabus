@props(['message'])

@if ($message)
  <div class="bg-gray-600 py-1 px-1 mb-4">
    <p class="ml-3 font-medium text-white">
      {{ $message }}
    </p>
  </div>
@endif
