@props(['method' => 'GET', 'action'])

<x-forms.base :action="$action" :method="$method">
  <x-forms.input name="search" type="text" class="block w-full" :placeholder="__('actions.search')" :value="request('search')"/>
</x-forms.base>
