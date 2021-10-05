<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Teachers') }}
    </h2>
  </x-slot>

  <x-slot name="headerActions">
    @yield('pageActions')
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @yield('main')
    </div>
  </div>
</x-app-layout>
