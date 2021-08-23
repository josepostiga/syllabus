<x-auth-layout>
  <div class="mb-4 text-sm text-gray-600">
    {{ __('accounts::messages.info.confirm_password_to_access') }}
  </div>

  <x-alerts.validation class="mb-4" :errors="$errors"/>

  <x-forms.base :action="route('password.confirm')">
    <div>
      <x-forms.label for="password" :value="__('accounts::properties.password')"/>
      <x-forms.input
        name="password"
        class="block mt-1 w-full"
        type="password"
        required autocomplete="current-password"/>
    </div>

    <div class="flex justify-end mt-4">
      <x-forms.button>{{ __('accounts::actions.confirm') }}</x-forms.button>
    </div>
  </x-forms.base>
</x-auth-layout>
