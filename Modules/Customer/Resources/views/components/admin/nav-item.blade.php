<x-admin.nav-dropdown :sub="true" :active="request()->routeIs('admin.customers.*')">
    <x-slot name="trigger">
        Clientes
    </x-slot>
    <x-slot name="content">
        <x-admin.nav-dropdown-link :href="route('admin.customers.create')" :active="request()->routeIs('admin.customers.create')">
            Cadastrar
        </x-admin.nav-dropdown-link>
        <x-admin.nav-dropdown-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.index')">
            Listar
        </x-admin.nav-dropdown-link>
    </x-slot>
</x-admin.nav-dropdown>
