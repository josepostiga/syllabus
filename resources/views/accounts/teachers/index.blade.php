@extends('accounts.teachers.base')

@section('pageActions')
  <span class="hidden sm:block">
        <x-page-actions.create :href="route('accounts.teachers.create')"></x-page-actions.create>
    </span>
@endsection

@section('main')
  <x-page-sections.base>
    <x-forms.search :action="route('accounts.teachers.index')"/>
  </x-page-sections.base>

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
            <div>{{ $teacher->name }}</div>
            <x-tables.td-context>{{ $teacher->email }}</x-tables.td-context>
          </x-tables.td>
          <x-tables.td>{{ __('accounts::properties.roles.'.strtolower($teacher->role)) }}</x-tables.td>
          <x-tables.td>
            <x-tables.badge :condition="!$teacher->trashed()"/>
          </x-tables.td>
          <x-tables.td>{{ $teacher->created_at }}</x-tables.td>
          <x-tables.td>{{ $teacher->updated_at }}</x-tables.td>
          <x-tables.td class="space-x-2">
            @can('showTeacherAccounts', $teacher)
              <x-forms.link :href="route('accounts.teachers.show', $teacher)" class="border rounded-md hover:bg-gray-700 hover:text-white">
                {{ __('actions.edit') }}
              </x-forms.link>
            @endcan
            @can('deleteTeacherAccounts', $teacher)
              <x-forms.delete :action="route('accounts.teachers.delete', $teacher)">
                {{ __('actions.delete') }}
              </x-forms.delete>
            @endcan
          </x-tables.td>
        </x-tables.row>
      @endforeach
    </x-tables.base>
  </x-page-sections.base>

  {{ $teachers->links() }}
@endsection
