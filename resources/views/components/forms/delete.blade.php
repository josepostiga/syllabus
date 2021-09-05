@props(['action' => ''])

<x-forms.base :action="$action" method="DELETE" {{ $attributes->merge(['class' => 'inline']) }}>
  <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 text-sm border rounded-md hover:bg-red-700 hover:text-white']) }}>
    {{ $slot }}
  </button>
</x-forms.base>
