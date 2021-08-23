<x-auth-layout>
  <x-alerts.validation class="mb-4" :errors="$errors"/>

  <x-forms.base :action="route('password.update')">
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div>
      <x-forms.label for="email" :value="__('accounts::properties.email')"/>
      <x-forms.input
        name="email" type="email"
        class="block mt-1 w-full"
        :value="old('email', $request->email)"
        required autofocus/>
    </div>

    <div class="mt-4">
      <x-forms.label for="password" :value="__('accounts::properties.password')"/>
      <x-forms.input name="password" type="password" class="block mt-1 w-full" required/>
    </div>

    <div class="mt-4">
      <x-forms.label for="password_confirmation" :value="__('accounts::passwords.password_confirmation')"/>
      <x-forms.input name="password_confirmation" type="password" class="block mt-1 w-full" required/>
    </div>

    <div class="flex items-center justify-end mt-4">
      <x-forms.button>
        {{ __('accounts::actions.reset_password') }}
      </x-forms.button>
    </div>
  </x-forms.base>
</x-auth-layout>
