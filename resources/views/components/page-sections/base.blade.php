<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 mx-auto']) }}>
  <div class="p-6 bg-white border-b border-gray-200">
    {{ $slot }}
  </div>
</div>
