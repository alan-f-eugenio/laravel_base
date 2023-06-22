<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Clientes
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.customers.create')">
            Cadastrar novo
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.filter gridCols="lg:grid-cols-4 sm:grid-cols-3">
            <x-admin.filter-select inpName="status" title="Status">
                @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                    <x-admin.filter-select-option inpName="status" :inpValue="$statusKey"
                        :title="$statusValue" />
                @endforeach
            </x-admin.filter-select>
            <x-admin.filter-input inpName="fullname" title="Nome" placeholder="Nome do Cliente" />
            <x-admin.filter-input inpName="email" title="E-mail do Cliente"
                placeholder="cliente@email.com.br" />
            <x-admin.filter-select inpName="person" title="Tipo de Pessoa">
                @foreach ($customerPersons as $personKey => $personValue)
                    <x-admin.filter-select-option inpName="person" :inpValue="$personKey"
                        :title="$personValue" />
                @endforeach
            </x-admin.filter-select>
            <x-admin.filter-input inpName="cpf" title="CPF" placeholder="CPF do Cliente" />
            <x-admin.filter-select inpName="month_birth" title="Mês de Aniversário">
                @foreach ($months as $keyMonth => $month)
                    <x-admin.filter-select-option inpName="month_birth" :inpValue="$keyMonth"
                        :title="$month" />
                @endforeach
            </x-admin.filter-select>
            <x-admin.filter-input inpName="cnpj" title="CNPJ" placeholder="CNPJ do Cliente" />
            <x-admin.filter-input inpName="corporate_name" title="Razão Social"
                placeholder="Razão Social do Cliente" />
        </x-admin.filter>
        <x-admin.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.table-th>
                    Nome
                </x-admin.table-th>
                <x-admin.table-th>
                    Tipo de Pessoa
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
                            {{ $item->fullname }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            <x-admin.status-badge :condition="$item->person->fisica()" :trueTitle="$item->person->texto()"
                                :falseTitle="$item->person->texto()" />
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
                            <x-admin.table-action :href="route('admin.customers.edit', $item->id)" title="Editar">
                                <i class="text-base ti ti-edit"></i>
                            </x-admin.table-action>
                            <x-admin.table-action :href="route('admin.customers.destroy', $item->id)" title="Excluir" :destroy="true">
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
