@extends('accounts.teachers.base')

@section('pageActions')
  <span class="hidden sm:block">
        <x-page-actions.save form="updateTeacher"/>
        <x-page-actions.cancel :href="route('accounts.teachers.index')"/>
    </span>
@endsection

@section('main')
  <x-page-sections.base class="max-w-3xl">
    <x-alerts.validation class="mb-4" :errors="$errors"/>

    <x-forms.base method="PATCH" :action="route('accounts.teachers.update', $teacher)" id="updateTeacher">
      <div>
        <x-forms.label for="role" :value="__('accounts::properties.role')"/>
        <x-forms.select name="role" class="block mt-1 w-full" :selected="old('role', $teacher->role)" :options="$roles" required autofocus/>
      </div>

      <div class="mt-4">
        <x-forms.label for="name" :value="__('accounts::properties.name')"/>
        <x-forms.input name="name" type="text" class="block mt-1 w-full" required :value="$teacher->name"/>
      </div>

      <div class="mt-4">
        <x-forms.label for="email" :value="__('accounts::properties.email')"/>
        <x-forms.input name="email" type="text" class="block mt-1 w-full" required :value="$teacher->email"/>
      </div>
    </x-forms.base>
  </x-page-sections.base>
@endsection
