@props(['item', 'collection', 'classes' => '', 'first' => false, 'stop' => false])

<tr data-id="{{ $item->id }}" x-data="{ openChild: false }">
    <x-admin.layout.sections.table-td colspan="99" :classes="$classes . ($first ? ' py-0' : '')">
        <div class="flex">
            @if (!$first)
                <i class="text-xl ti ti-corner-down-right"></i>
            @endif
            <x-admin.layout.sections.table :collection="$collection" :tableOnly="true">
                <x-slot name="ths">
                    <x-admin.layout.sections.table-th :hidden="true">
                        Ordem
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th :hidden="true" width="20%">
                        Título
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th :hidden="true">
                        Cadastrado
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th :hidden="true" width="19%">
                        Alterado
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th :hidden="true">
                        Status
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th :hidden="true">
                        Ações
                    </x-admin.layout.sections.table-th>
                </x-slot>
                <x-slot name="tbody">
<tr class="bg-white">
    <x-admin.layout.sections.table-td class="border-b ordemNumber">
        {{ $item->ordem }}
    </x-admin.layout.sections.table-td>
    <x-admin.layout.sections.table-td :main="true" class="border-b">
        {{ $item->name }}
    </x-admin.layout.sections.table-td>
    <x-admin.layout.sections.table-td class="border-b">
        {{ $item->created_at->format('d/m/Y H:i:s') }}
    </x-admin.layout.sections.table-td>
    <x-admin.layout.sections.table-td class="border-b">
        {{ $item->updated_at != $item->created_at ? $item->updated_at->format('d/m/Y H:i:s') : 'Nunca' }}
    </x-admin.layout.sections.table-td>
    <x-admin.layout.sections.table-td class="border-b">
        <x-admin.layout.sections.status-badge :condition="$item->status->ativo()" :trueTitle="$item->status->texto()" :falseTitle="$item->status->texto()" />
    </x-admin.layout.sections.table-td>
    <x-admin.layout.sections.table-actions-td class="border-b" :justifyEnd="true">
        <x-admin.layout.sections.table-action :href="route('admin.product_categories.edit', $item->id)" title="Editar">
            <i class="text-base ti ti-edit"></i>
        </x-admin.layout.sections.table-action>
        <x-admin.layout.sections.table-action :href="route('admin.product_categories.destroy', $item->id)" title="Excluir" :destroy="true">
            <i class="text-base ti ti-trash"></i>
        </x-admin.layout.sections.table-action>
        @if ($collection->count())
            <x-admin.layout.sections.table-action href="javascript:;" title="Subcategorias"
                @click="openChild = !openChild">
                <i class="text-base ti ti-chevron-down"
                    :class="{ 'ti-chevron-up font-semibold': openChild, 'ti-chevron-down': !openChild }"></i>
            </x-admin.layout.sections.table-action>
        @else
            <x-admin.layout.sections.table-action-disabled>
                <i class="text-base ti ti-chevron-down"></i>
            </x-admin.layout.sections.table-action-disabled>
        @endif
    </x-admin.layout.sections.table-actions-td>
</tr>
@if ($collection->count())
    <tr x-cloak x-show="openChild" class="notSortable">
        <x-admin.layout.sections.table-td colspan="99" classes="{{ $first ? 'py-1' : 'pt-1' }} px-0 bg-gray-100">
            <x-admin.layout.sections.table :sortable="true" :collection="$collection" :tableOnly="true">
                <x-slot name="tbody">
                    @foreach ($collection as $subItem)
                        <x-admin.layout.sections.product-category-recursive-table :item="$subItem"
                            :collection="$subItem->allChilds" />
                    @endforeach
                </x-slot>
            </x-admin.layout.sections.table>
        </x-admin.layout.sections.table-td>
    </tr>
@endif
</x-slot>
</x-admin.layout.sections.table>
</div>
</x-admin.layout.sections.table-td>
</tr>
