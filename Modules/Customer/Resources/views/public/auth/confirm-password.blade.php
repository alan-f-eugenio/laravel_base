<x-public-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-admin.breeze.input-label for="password" :value="__('Password')" />

            <x-admin.breeze.text-input id="password" class="block w-full mt-1" type="password" name="password" required
                autocomplete="current-password" />

            <x-admin.breeze.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-admin.breeze.primary-button>
                {{ __('Confirm') }}
            </x-admin.breeze.primary-button>
        </div>
    </form>
</x-public-layout>
