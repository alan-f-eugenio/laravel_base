<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Painel Administrativo
        </x-admin.layout.sections.page-title>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            {{ __("You're logged in!") }}
        </div>
    </div>
</x-admin.layout.app>
