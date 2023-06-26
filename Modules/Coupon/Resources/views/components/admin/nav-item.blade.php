<x-admin.nav-dropdown :sub="true" :active="request()->routeIs('admin.coupons.*')">
    <x-slot name="trigger">
        Cupons
    </x-slot>
    <x-slot name="content">
        <x-admin.nav-dropdown-link :href="route('admin.coupons.create')" :active="request()->routeIs('admin.coupons.create')">
            Cadastrar
        </x-admin.nav-dropdown-link>
        <x-admin.nav-dropdown-link :href="route('admin.coupons.index')" :active="request()->routeIs('admin.coupons.index')">
            Listar
        </x-admin.nav-dropdown-link>
    </x-slot>
</x-admin.nav-dropdown>
