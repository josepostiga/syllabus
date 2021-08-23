<x-auth-layout>
  <x-alerts.validation class="mb-4" :errors="$errors"/>

  <x-forms.base :action="route('login')">
    <div>
      <x-forms.label for="email" :value="__('accounts::properties.email')"/>
      <x-forms.input
        name="email" type="email"
        class="block mt-1 w-full"
        required autofocus/>
    </div>

    <div class="mt-4">
      <x-forms.label for="password" :value="__('accounts::properties.password')"/>
      <x-forms.input
        name="password" type="password"
        class="block mt-1 w-full"
        required autocomplete="current-password"/>
    </div>

    <div class="block mt-4">
      <x-forms.checkbox :value="__('accounts::actions.remember_me')"
        name="remember" id="remember_me"
        class="inline-flex items-center"/>
    </div>

    <div class="flex items-center justify-end mt-4">
      <x-forms.link :href="route('password.request')" class="underline">
        {{ __('accounts::actions.recover_password') }}
      </x-forms.link>

      <x-forms.button class="ml-3">{{ __('accounts::actions.login') }}</x-forms.button>
    </div>
  </x-forms.base>
</x-auth-layout>
