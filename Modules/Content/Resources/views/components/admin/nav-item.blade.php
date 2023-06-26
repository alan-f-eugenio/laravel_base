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
                    <x-admin.nav-dropdown :sub="true" :active="in_array($nav->id, [request()->nav?->id, request()->content?->nav->id])">
                        <x-slot name="trigger">
                            {{ $nav->title }}
                        </x-slot>
                        <x-slot name="content">
                            <x-admin.nav-dropdown-link :href="route('admin.contents.create', $nav->id)" :active="request()->routeIs('admin.contents.create', $nav->id)">
                                Cadastrar
                            </x-admin.nav-dropdown-link>
                            <x-admin.nav-dropdown-link :href="route('admin.contents.index', $nav->id)" :active="request()->routeIs('admin.contents.index') && request()->nav?->id == $nav->id">
                                Listar
                            </x-admin.nav-dropdown-link>
                        </x-slot>
                    </x-admin.nav-dropdown>
                @else
                    <x-admin.nav-dropdown-link :sub="true" :href="route('admin.contents.index', $nav->id)" :active="in_array($nav->id, [request()->nav?->id, request()->content?->nav->id])">
                        {{ $nav->title }}
                    </x-admin.nav-dropdown-link>
                @endif
            @endif
        @endforeach
    </x-slot>
</x-admin.nav-dropdown>
