@extends('accounts.teachers.base')

@section('pageActions')
  <span class="hidden sm:block">
        <x-page-actions.create :href="route('accounts.teachers.create')"></x-page-actions.create>
    </span>
@endsection

@section('main')
  <x-page-sections.base>
    <x-tables.base
      :headers="[__('accounts::properties.name'), __('accounts::properties.role'), __('properties.status'), __('properties.created_at'), __('properties.updated_at')]"
    >
      @foreach($teachers as $teacher)
        <x-tables.row>
          <x-tables.td>
            <div class="text-sm font-medium text-gray-900">
              {{ $teacher->name }}
            </div>
            <div class="text-sm text-gray-500">
              {{ $teacher->email }}
            </div>
          </x-tables.td>
          <x-tables.td>
            {{ __("accounts::properties.roles.{$teacher->role}") }}
          </x-tables.td>
          <x-tables.td>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                {{ __('properties.statuses.active') }}
              </span>
          </x-tables.td>
          <x-tables.td>
            {{ $teacher->created_at }}
          </x-tables.td>
          <x-tables.td>
            {{ $teacher->updated_at }}
          </x-tables.td>
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
