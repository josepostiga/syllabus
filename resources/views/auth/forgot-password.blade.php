<x-auth-layout>
  <div class="mb-4 text-sm text-gray-600">
    {{ __('accounts::messages.info.password_recover') }}
  </div>

  <x-alerts.simple class="mb-4" :message="session('status')"/>
  <x-alerts.validation class="mb-4" :errors="$errors"/>

  <x-forms.base :action="route('password.email')">
    <div>
      <x-forms.label for="email" :value="__('Email')"/>
      <x-forms.input
        name="email" type="email"
        class="block mt-1 w-full"
        required autofocus/>
    </div>

    <div class="flex items-center justify-end mt-4">
      <x-forms.button>
        {{ __('Email Password Reset Link') }}
      </x-forms.button>
    </div>
  </x-forms.base>
</x-auth-layout>
