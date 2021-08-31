@extends('accounts.teachers.base')

@section('pageActions')
  <span class="hidden sm:block">
        <x-page-actions.create :href="route('accounts.teachers.create')"></x-page-actions.create>
    </span>
@endsection

@section('main')
  <x-page-sections.base>
    <x-tables.base
      :headers="[
        __('accounts::properties.name'),
        __('accounts::properties.role'),
        __('properties.status'),
        __('properties.created_at'),
        __('properties.updated_at'),
      ]"
    >
      @foreach($teachers as $teacher)
        <x-tables.row>
          <x-tables.td>
            {{ $teacher->name }}
            <div class="text-sm text-gray-500">
              {{ $teacher->email }}
            </div>
          </x-tables.td>
          <x-tables.td>{{ __("accounts::properties.roles.{$teacher->role}") }}</x-tables.td>
          <x-tables.td>
            <x-tables.badge :condition="!$teacher->trashed()"/>
          </x-tables.td>
          <x-tables.td>{{ $teacher->created_at }}</x-tables.td>
          <x-tables.td>{{ $teacher->updated_at }}</x-tables.td>
          <x-tables.td>
            @can('updateTeacherAccounts', $teacher)
              <x-forms.link href="#" class="border hover:bg-gray-900 hover:text-white">Edit</x-forms.link>
            @endcan
          </x-tables.td>
        </x-tables.row>
      @endforeach
    </x-tables.base>
  </x-page-sections.base>
@endsection
