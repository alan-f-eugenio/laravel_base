<x-public-layout>
    <div class="flex flex-col items-center pt-6 bg-gray-100 sm:justify-center sm:pt-0">
        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">

            <!-- Session Status -->
            <x-admin.breeze.auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-admin.breeze.input-label for="email" :value="__('Email')" />
                    <x-admin.breeze.text-input id="email" class="block w-full mt-1" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-admin.breeze.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-admin.breeze.input-label for="password" :value="__('Password')" />

                    <x-admin.breeze.text-input id="password" class="block w-full mt-1" type="password" name="password"
                        required autocomplete="current-password" />

                    <x-admin.breeze.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-admin.breeze.primary-button class="ml-3">
                        {{ __('Log in') }}
                    </x-admin.breeze.primary-button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
