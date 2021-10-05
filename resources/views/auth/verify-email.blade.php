<x-auth-layout>
  <div class="mb-4 text-sm text-gray-600">
    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
  </div>

  @if (session('status') === 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600">
      {{ __('accounts::messages.info.verification_link_sent') }}
    </div>
  @endif

  <div class="mt-4 flex items-center justify-between">
    <x-forms.base :action="route('verification.send')">
      <div>
        <x-forms.button>
          {{ __('accounts::actions.resend_validation_link') }}
        </x-forms.button>
      </div>
    </x-forms.base>

    <x-forms.base :action="route('logout')">
      <x-forms.button class="underline text-sm text-gray-600 hover:text-gray-900">
        {{ __('accounts::actions.logout') }}
      </x-forms.button>
    </x-forms.base>
  </div>
</x-auth-layout>
