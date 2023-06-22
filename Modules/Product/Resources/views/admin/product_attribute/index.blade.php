<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Atributos
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.product_attributes.create')">
            Cadastrar novo
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.filter gridCols="sm:grid-cols-2">
            <x-admin.layout.sections.filter-select inpName="status" title="Status">
                @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                    <x-admin.layout.sections.filter-select-option inpName="status" :inpValue="$statusKey" :title="$statusValue" />
                @endforeach
            </x-admin.layout.sections.filter-select>
            <x-admin.layout.sections.filter-input inpName="name" title="Nome" placeholder="Nome do atributo" />
        </x-admin.layout.sections.filter>
        <x-admin.layout.sections.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.layout.sections.table-th>
                    Nome
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Cadastrado
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Alterado
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Status
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Ações
                </x-admin.layout.sections.table-th>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($collection as $item)
                    <tr class="bg-white border-b">
                        <x-admin.layout.sections.table-td :main="true">
                            {{ $item->name }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            {{ $item->created_at->format('d/m/Y H:i:s') }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            {{ $item->updated_at != $item->created_at ? $item->updated_at->format('d/m/Y H:i:s') : 'Nunca' }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.status-badge :condition="$item->status->ativo()" :trueTitle="$item->status->texto()"
                                :falseTitle="$item->status->texto()" />
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-actions-td>
                            <x-admin.layout.sections.table-action :href="route('admin.product_attributes.edit', $item->id)" title="Editar">
                                <i class="text-base ti ti-edit"></i>
                            </x-admin.layout.sections.table-action>
                            <x-admin.layout.sections.table-action :href="route('admin.product_attributes.destroy', $item->id)" title="Excluir" :destroy="true">
                                <i class="text-base ti ti-trash"></i>
                            </x-admin.layout.sections.table-action>
                        </x-admin.layout.sections.table-actions-td>
                    </tr>
                @empty
                    <x-admin.layout.sections.table-no-result />
                @endforelse
            </x-slot>
        </x-admin.layout.sections.table>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
