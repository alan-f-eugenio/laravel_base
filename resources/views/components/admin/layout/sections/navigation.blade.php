<aside class="flex-shrink-0 pb-16 xl:pb-0 xl:w-64">
    <div x-cloak x-show="openSideMenu" @click="openSideMenu = ! openSideMenu"
        class="fixed z-10 w-screen h-screen bg-gray-400 opacity-50 xl:hidden">
    </div>
    <nav
        class="fixed z-20 flex items-center justify-between w-full h-16 px-6 bg-white border-b border-gray-200 xl:hidden">
        <h2 class="font-medium">
            Painel Administrativo
        </h2>
        <div class="flex items-center">
            <button @click.stop="openSideMenu = ! openSideMenu"
                class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                <h2 class="mr-1 leading-5 text-gray-500 font-sm">
                    Menu
                </h2>
                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': openSideMenu, 'inline-flex': !openSideMenu }" class="inline-flex"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !openSideMenu, 'inline-flex': openSideMenu }" class="hidden"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>

    <nav :class="{ 'block': openSideMenu, 'hidden': !openSideMenu }"
        class="fixed z-20 hidden w-full h-full overflow-y-auto bg-white border-gray-200 xl:h-screen sm:border-r xl:mt-0 sm:w-64 xl:block ">
        <div class="py-3">
            <x-admin.nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                Home
            </x-admin.nav-link>

            <x-admin.nav-dropdown :hasSub="true" :active="request()->routeIs('admin.contacts.*', 'admin.emails.*')">
                <x-slot name="trigger">
                    Comunicação
                </x-slot>
                <x-slot name="content">
                    <x-admin.nav-dropdown-link :href="route('admin.contacts.index')" :active="request()->routeIs('admin.contacts.*')">
                        Contatos
                    </x-admin.nav-dropdown-link>
                    <x-admin.nav-dropdown-link :href="route('admin.emails.index')" :active="request()->routeIs('admin.emails.*')">
                        Lista de E-mails
                    </x-admin.nav-dropdown-link>
                </x-slot>
            </x-admin.nav-dropdown>


            <x-admin.nav-dropdown :hasSub="true" :active="request()->routeIs('admin.contentNavs.*', 'admin.contents.*', 'admin.banners.*')">
                <x-slot name="trigger">
                    Institucional
                </x-slot>
                <x-slot name="content">
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
                    <x-admin.nav-dropdown :sub="true" :hasSub="true" :active="request()->routeIs('admin.contentNavs.*', 'admin.contents.*')" subTitle="Conteúdos">
                        <x-slot name="trigger">
                            Páginas de Conteúdo
                        </x-slot>
                        <x-slot name="content">
                            <x-admin.nav-dropdown-link :href="route('admin.contentNavs.create')" :active="request()->routeIs('admin.contentNavs.create')">
                                Cadastrar
                            </x-admin.nav-dropdown-link>
                            <x-admin.nav-dropdown-link :href="route('admin.contentNavs.index')" :active="request()->routeIs('admin.contentNavs.index')">
                                Listar
                            </x-admin.nav-dropdown-link>
                        </x-slot>
                        <x-slot name="subContent">
                            @foreach (config('contentNavs') as $slug => $nav)
                                @if ($nav->status->ativo())
                                    @if ($nav->type->multiple())
                                        <x-admin.nav-dropdown :sub="true" :active="in_array($nav->id, [
                                            request()->nav?->id,
                                            request()->content?->nav->id,
                                        ])">
                                            <x-slot name="trigger">
                                                {{ $nav->title }}
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-admin.nav-dropdown-link :href="route('admin.contents.create', $nav->id)" :active="request()->routeIs('admin.contents.create', $nav->id)">
                                                    Cadastrar
                                                </x-admin.nav-dropdown-link>
                                                <x-admin.nav-dropdown-link :href="route('admin.contents.index', $nav->id)" :active="request()->routeIs('admin.contents.index') &&
                                                    request()->nav?->id == $nav->id">
                                                    Listar
                                                </x-admin.nav-dropdown-link>
                                            </x-slot>
                                        </x-admin.nav-dropdown>
                                    @else
                                        <x-admin.nav-dropdown-link :sub="true" :href="route('admin.contents.index', $nav->id)"
                                            :active="in_array($nav->id, [
                                                request()->nav?->id,
                                                request()->content?->nav->id,
                                            ])">
                                            {{ $nav->title }}
                                        </x-admin.nav-dropdown-link>
                                    @endif
                                @endif
                            @endforeach
                        </x-slot>
                    </x-admin.nav-dropdown>
                </x-slot>
            </x-admin.nav-dropdown>
            <x-admin.nav-dropdown :hasSub="true" :active="request()->routeIs(
                'admin.customers.*',
                'admin.coupons.*',
                'admin.product_categories.*',
                'admin.product_attributes.*',
                'admin.products.*',
                'admin.carts.*',
            )">
                <x-slot name="trigger">
                    Loja
                </x-slot>
                <x-slot name="content">
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
                </x-slot>
                <x-slot name="subContent" subTitle="">
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
                    <x-admin.nav-dropdown-link :href="route('admin.carts.index')" :active="request()->routeIs('admin.carts.*')">
                        Carrinhos Abandonados
                    </x-admin.nav-dropdown-link>
                </x-slot>
            </x-admin.nav-dropdown>
        </div>
        <div class="py-3 border-t border-gray-200">
            <x-admin.nav-dropdown :hasSub="true" :active="request()->routeIs('admin.users.*', 'admin.defines.*', 'admin.integrations.*')">
                <x-slot name="trigger">
                    Configurações
                </x-slot>
                <x-slot name="content">
                    <x-admin.nav-dropdown :sub="true" :active="request()->routeIs('admin.users.*')">
                        <x-slot name="trigger">
                            Usuários
                        </x-slot>
                        <x-slot name="content">
                            <x-admin.nav-dropdown-link :href="route('admin.users.create')" :active="request()->routeIs('admin.users.create')">
                                Cadastrar
                            </x-admin.nav-dropdown-link>
                            <x-admin.nav-dropdown-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                                Listar
                            </x-admin.nav-dropdown-link>
                        </x-slot>
                    </x-admin.nav-dropdown>
                    <x-admin.nav-dropdown-link :sub="true" :href="route('admin.defines.edit')" :active="request()->routeIs('admin.defines.edit')">
                        Definições
                    </x-admin.nav-dropdown-link>
                    <x-admin.nav-dropdown-link :sub="true" :href="route('admin.integrations.edit')" :active="request()->routeIs('admin.integrations.edit')">
                        Integrações
                    </x-admin.nav-dropdown-link>
                </x-slot>
            </x-admin.nav-dropdown>
        </div>
        <div class="py-3 border-t border-gray-200">
            <div class="space-y-1">
                <x-admin.nav-link :href="route('admin.profile.edit')" :active="request()->routeIs('admin.profile.*')">
                    {{ __('Profile') }}
                </x-admin.nav-link>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <x-admin.nav-link :href="route('admin.logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-admin.nav-link>
                </form>
            </div>
        </div>
    </nav>
</aside>
