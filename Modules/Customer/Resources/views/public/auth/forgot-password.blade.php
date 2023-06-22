<x-public-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-admin.breeze.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-admin.breeze.input-label for="email" :value="__('Email')" />
            <x-admin.breeze.text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            <x-admin.breeze.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-admin.breeze.primary-button>
                {{ __('Email Password Reset Link') }}
            </x-admin.breeze.primary-button>
        </div>
    </form>
</x-public-layout>
