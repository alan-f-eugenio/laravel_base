<x-admin.nav-dropdown :sub="true" :active="request()->routeIs('admin.product_categories.*')">
    <x-slot name="trigger">
        Categorias
    </x-slot>
    <x-slot name="content">
        <x-admin.nav-dropdown-link :href="route('admin.product_categories.create')" :active="request()->routeIs('admin.product_categories.create')">
            Cadastrar
        </x-admin.nav-dropdown-link>
        <x-admin.nav-dropdown-link :href="route('admin.product_categories.index')" :active="request()->routeIs('admin.product_categories.index')">
            Listar
        </x-admin.nav-dropdown-link>
    </x-slot>
</x-admin.nav-dropdown>
<x-admin.nav-dropdown :sub="true" :active="request()->routeIs('admin.product_attributes.*')">
    <x-slot name="trigger">
        Atributos
    </x-slot>
    <x-slot name="content">
        <x-admin.nav-dropdown-link :href="route('admin.product_attributes.create')" :active="request()->routeIs('admin.product_attributes.create')">
            Cadastrar
        </x-admin.nav-dropdown-link>
        <x-admin.nav-dropdown-link :href="route('admin.product_attributes.index')" :active="request()->routeIs('admin.product_attributes.index')">
            Listar
        </x-admin.nav-dropdown-link>
    </x-slot>
</x-admin.nav-dropdown>
<x-admin.nav-dropdown :sub="true" :active="request()->routeIs('admin.products.*')">
    <x-slot name="trigger">
        Produtos
    </x-slot>
    <x-slot name="content">
        <x-admin.nav-dropdown-link :href="route('admin.products.create')" :active="request()->routeIs('admin.products.create')">
            Cadastrar
        </x-admin.nav-dropdown-link>
        <x-admin.nav-dropdown-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
            Listar
        </x-admin.nav-dropdown-link>
    </x-slot>
</x-admin.nav-dropdown>
