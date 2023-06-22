<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Painel Administrativo
        </x-admin.page-title>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            {{ __("You're logged in!") }}
        </div>
    </div>
</x-admin-layout>
