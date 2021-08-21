@extends('accounts.teachers.base')

@section('pageActions')
    <span class="hidden sm:block">
        <x-page-action-save form="createNewTeacher"></x-page-action-save>
        <x-page-action-cancel :href="route('accounts.teachers.index')"></x-page-action-cancel>
    </span>
@endsection

@section('body')
    <x-page-section-white class="max-w-3xl">
        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors"/>

        <form method=POST action="{{ route('accounts.teachers.store') }}" id="createNewTeacher">
            @csrf

            <div>
                <x-label for="role">{{ __('accounts::auth.role') }}</x-label>
                <x-select id="role" class="block mt-1 w-full" name="role" :selected="old('role')" :options="$roles" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="name">{{ __('accounts::auth.name') }}</x-label>
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus/>
            </div>

            <div class="mt-4">
                <x-label for="email">{{ __('accounts::auth.email') }}</x-label>
                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus/>
            </div>
        </form>
    </x-page-section-white>
@endsection
