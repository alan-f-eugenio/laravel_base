<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Perfil
        </x-admin.layout.sections.page-title>
    </x-slot>
    <div class="mx-auto space-y-6">
        <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>
                    <form id="send-verification" method="post" action="{{ route('admin.verification.send') }}">
                        @csrf
                    </form>
                    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
                        <div>
                            <x-admin.breeze.input-label for="name" :value="__('Name')" />
                            <x-admin.breeze.text-input id="name" name="name" type="text"
                                class="block w-full mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-admin.breeze.input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-admin.breeze.input-label for="email" :value="__('Email')" />
                            <x-admin.breeze.text-input id="email" name="email" type="email"
                                class="block w-full mt-1" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-admin.breeze.input-error class="mt-2" :messages="$errors->get('email')" />
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div>
                                    <p class="mt-2 text-sm text-gray-800">
                                        {{ __('Your email address is unverified.') }}
                                        <button form="send-verification"
                                            class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 text-sm font-medium text-green-600">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-4">
                            <x-admin.breeze.primary-button>{{ __('Save') }}</x-admin.breeze.primary-button>
                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Update Password') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                    </header>
                    <form method="post" action="{{ route('admin.password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')
                        <div>
                            <x-admin.breeze.input-label for="current_password" :value="__('Current Password')" />
                            <x-admin.breeze.text-input id="current_password" name="current_password" type="password"
                                class="block w-full mt-1" autocomplete="current-password" />
                            <x-admin.breeze.input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
                        <div>
                            <x-admin.breeze.input-label for="password" :value="__('New Password')" />
                            <x-admin.breeze.text-input id="password" name="password" type="password"
                                class="block w-full mt-1" autocomplete="new-password" />
                            <x-admin.breeze.input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <x-admin.breeze.input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-admin.breeze.text-input id="password_confirmation" name="password_confirmation"
                                type="password" class="block w-full mt-1" autocomplete="new-password" />
                            <x-admin.breeze.input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-admin.breeze.primary-button>{{ __('Save') }}</x-admin.breeze.primary-button>
                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
            <div class="max-w-xl">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Inativar Conta
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Uma vez que sua conta é inativa, você perderá acesso a todos os dados e recursos desta
                            conta, portanto, antes de inativar a sua conta, copie todos os dados e informações que você deseje
                            manter.
                        </p>
                    </header>
                    <x-admin.breeze.danger-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                        Inativar Conta</x-admin.breeze.danger-button>
                    <x-admin.breeze.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('admin.profile.destroy') }}" class="p-6">
                            @csrf
                            @method('delete')
                            <h2 class="text-lg font-medium text-gray-900">
                                Tem certeza que quer inativar a sua conta?
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Por favor informe a sua senha para confirmar que você deseja inativar a sua conta.
                            </p>
                            <div class="mt-6">
                                <x-admin.breeze.input-label for="password" value="{{ __('Password') }}"
                                    class="sr-only" />
                                <x-admin.breeze.text-input id="password" name="password" type="password"
                                    class="block w-3/4 mt-1" placeholder="{{ __('Password') }}" />
                                <x-admin.breeze.input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                            </div>
                            <div class="flex justify-end mt-6">
                                <x-admin.breeze.secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-admin.breeze.secondary-button>
                                <x-admin.breeze.danger-button class="ml-3">
                                    Inativar Conta
                                </x-admin.breeze.danger-button>
                            </div>
                        </form>
                    </x-admin.breeze.modal>
                </section>
            </div>
        </div>
    </div>
</x-admin.layout.app>
