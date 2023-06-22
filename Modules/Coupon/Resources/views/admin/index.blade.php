<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Cupons
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.coupons.create')">
            Cadastrar novo
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.filter gridCols="sm:grid-cols-3">
            <x-admin.filter-select inpName="status" title="Status">
                @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                    <x-admin.filter-select-option inpName="status" :inpValue="$statusKey"
                        :title="$statusValue" />
                @endforeach
            </x-admin.filter-select>
            <x-admin.filter-input inpName="token" title="Token" placeholder="Token do cupom" />
            <x-admin.filter-select inpName="discount_type" title="Tipo de Desconto">
                @foreach ($couponDiscountTypes as $typeKey => $typeValue)
                    <x-admin.filter-select-option inpName="discount_type" :inpValue="$typeKey" :title="$typeValue" />
                @endforeach
            </x-admin.filter-select>
        </x-admin.filter>
        <x-admin.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.table-th>
                    Token
                </x-admin.table-th>
                <x-admin.table-th>
                    Descrição
                </x-admin.table-th>
                <x-admin.table-th>
                    Tipo de Desconto
                </x-admin.table-th>
                <x-admin.table-th>
                    Cadastrado
                </x-admin.table-th>
                <x-admin.table-th>
                    Alterado
                </x-admin.table-th>
                <x-admin.table-th>
                    Status
                </x-admin.table-th>
                <x-admin.table-th>
                    Ações
                </x-admin.table-th>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($collection as $item)
                    <tr class="bg-white border-b">
                        <x-admin.table-td :main="true">
                            {{ $item->token }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->description }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            <x-admin.status-badge :condition="$item->discount_type->percent()" :trueTitle="$item->discount_type->texto()"
                                :falseTitle="$item->discount_type->texto()" />
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->created_at->format('d/m/Y H:i:s') }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->updated_at != $item->created_at ? $item->updated_at->format('d/m/Y H:i:s') : 'Nunca' }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            <x-admin.status-badge :condition="$item->status->ativo()" :trueTitle="$item->status->texto()"
                                :falseTitle="$item->status->texto()" />
                        </x-admin.table-td>
                        <x-admin.table-actions-td>
                            <x-admin.table-action :href="route('admin.coupons.edit', $item->id)" title="Editar">
                                <i class="text-base ti ti-edit"></i>
                            </x-admin.table-action>
                            <x-admin.table-action :href="route('admin.coupons.destroy', $item->id)" title="Excluir" :destroy="true">
                                <i class="text-base ti ti-trash"></i>
                            </x-admin.table-action>
                        </x-admin.table-actions-td>
                    </tr>
                @empty
                    <x-admin.table-no-result />
                @endforelse
            </x-slot>
        </x-admin.table>
    </x-admin.list-section>
</x-admin-layout>
