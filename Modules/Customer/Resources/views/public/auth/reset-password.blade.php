<x-public-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-admin.breeze.input-label for="email" :value="__('Email')" />
            <x-admin.breeze.text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required
                autofocus autocomplete="username" />
            <x-admin.breeze.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-admin.breeze.input-label for="password" :value="__('Password')" />
            <x-admin.breeze.text-input id="password" class="block w-full mt-1" type="password" name="password" required
                autocomplete="new-password" />
            <x-admin.breeze.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-admin.breeze.input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-admin.breeze.text-input id="password_confirmation" class="block w-full mt-1" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-admin.breeze.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-admin.breeze.primary-button>
                {{ __('Reset Password') }}
            </x-admin.breeze.primary-button>
        </div>
    </form>
</x-public-layout>
