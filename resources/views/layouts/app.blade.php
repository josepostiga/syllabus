@extends('layouts.base')

@section('body')
  <div class="min-h-screen bg-gray-100">
    <x-navigation.nav :authenticatedUser="$authenticatedUser"/>

    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
          <div class="flex-1 min-w-0">
            {{ $header }}
          </div>
          <div class="mt-5 flex lg:mt-0 lg:ml-4">
            {{ $headerActions ?? ''}}
          </div>
        </div>
      </div>
    </header>

    <main>
      <x-alerts.banner class="mb-4" :message="session('message')"/>

      {{ $slot }}
    </main>
  </div>
@endsection
