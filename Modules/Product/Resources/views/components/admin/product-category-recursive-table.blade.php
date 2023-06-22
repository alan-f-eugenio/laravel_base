@props(['item', 'collection', 'classes' => '', 'first' => false, 'stop' => false])

<tr data-id="{{ $item->id }}" x-data="{ openChild: false }">
    <x-admin.table-td colspan="99" :classes="$classes . ($first ? ' py-0' : '')">
        <div class="flex">
            @if (!$first)
                <i class="text-xl ti ti-corner-down-right"></i>
            @endif
            <x-admin.table :collection="$collection" :tableOnly="true">
                <x-slot name="ths">
                    <x-admin.table-th :hidden="true">
                        Ordem
                    </x-admin.table-th>
                    <x-admin.table-th :hidden="true" width="20%">
                        Título
                    </x-admin.table-th>
                    <x-admin.table-th :hidden="true">
                        Cadastrado
                    </x-admin.table-th>
                    <x-admin.table-th :hidden="true" width="19%">
                        Alterado
                    </x-admin.table-th>
                    <x-admin.table-th :hidden="true">
                        Status
                    </x-admin.table-th>
                    <x-admin.table-th :hidden="true">
                        Ações
                    </x-admin.table-th>
                </x-slot>
                <x-slot name="tbody">
<tr class="bg-white">
    <x-admin.table-td class="border-b ordemNumber cursor-grab">
        <i class="mr-3 text-base ti ti-arrows-up-down"></i>
        <span class="text-xl">{{ $item->ordem }}</span>
    </x-admin.table-td>
    <x-admin.table-td :main="true" class="border-b">
        {{ $item->name }}
    </x-admin.table-td>
    <x-admin.table-td class="border-b">
        {{ $item->created_at->format('d/m/Y H:i:s') }}
    </x-admin.table-td>
    <x-admin.table-td class="border-b">
        {{ $item->updated_at != $item->created_at ? $item->updated_at->format('d/m/Y H:i:s') : 'Nunca' }}
    </x-admin.table-td>
    <x-admin.table-td class="border-b">
        <x-admin.status-badge :condition="$item->status->ativo()" :trueTitle="$item->status->texto()" :falseTitle="$item->status->texto()" />
    </x-admin.table-td>
    <x-admin.table-actions-td class="border-b" :justifyEnd="true">
        <x-admin.table-action :href="route('admin.product_categories.edit', $item->id)" title="Editar">
            <i class="text-base ti ti-edit"></i>
        </x-admin.table-action>
        <x-admin.table-action :href="route('admin.product_categories.destroy', $item->id)" title="Excluir" :destroy="true">
            <i class="text-base ti ti-trash"></i>
        </x-admin.table-action>
        @if ($collection->count())
            <x-admin.table-action href="javascript:;" title="Subcategorias"
                @click="openChild = !openChild">
                <i class="text-base ti ti-chevron-down"
                    :class="{ 'ti-chevron-up font-semibold': openChild, 'ti-chevron-down': !openChild }"></i>
            </x-admin.table-action>
        @else
            <x-admin.table-action-disabled>
                <i class="text-base ti ti-chevron-down"></i>
            </x-admin.table-action-disabled>
        @endif
    </x-admin.table-actions-td>
</tr>
@if ($collection->count())
    <tr x-cloak x-show="openChild" class="notSortable">
        <x-admin.table-td colspan="99" classes="{{ $first ? 'py-1' : 'pt-1' }} px-0 bg-gray-100">
            <x-admin.table :sortable="true" :collection="$collection" :tableOnly="true">
                <x-slot name="tbody">
                    @foreach ($collection as $subItem)
                        <x-product::admin.product-category-recursive-table :item="$subItem" :collection="$subItem->allChilds" />
                    @endforeach
                </x-slot>
            </x-admin.table>
        </x-admin.table-td>
    </tr>
@endif
</x-slot>
</x-admin.table>
</div>
</x-admin.table-td>
</tr>
