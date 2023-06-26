<x-admin.nav-dropdown :sub="true" :active="request()->routeIs('admin.banners.*')">
    <x-slot name="trigger">
        Banners
    </x-slot>
    <x-slot name="content">
        <x-admin.nav-dropdown-link :href="route('admin.banners.create')" :active="request()->routeIs('admin.banners.create')">
            Cadastrar
        </x-admin.nav-dropdown-link>
        <x-admin.nav-dropdown-link :href="route('admin.banners.index')" :active="request()->routeIs('admin.banners.index')">
            Listar
        </x-admin.nav-dropdown-link>
    </x-slot>
</x-admin.nav-dropdown>
