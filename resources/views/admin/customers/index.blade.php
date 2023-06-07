<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Clientes
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.customers.create')">
            Cadastrar novo
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.filter gridCols="lg:grid-cols-4 sm:grid-cols-3">
            <x-admin.layout.sections.filter-select inpName="status" title="Status">
                @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                    <x-admin.layout.sections.filter-select-option inpName="status" :inpValue="$statusKey"
                        :title="$statusValue" />
                @endforeach
            </x-admin.layout.sections.filter-select>
            <x-admin.layout.sections.filter-input inpName="fullname" title="Nome" placeholder="Nome do Cliente" />
            <x-admin.layout.sections.filter-input inpName="email" title="E-mail do Cliente"
                placeholder="cliente@email.com.br" />
            <x-admin.layout.sections.filter-select inpName="person" title="Tipo de Pessoa">
                @foreach (\App\Helpers\CustomerPersons::array() as $personKey => $personValue)
                    <x-admin.layout.sections.filter-select-option inpName="person" :inpValue="$personKey"
                        :title="$personValue" />
                @endforeach
            </x-admin.layout.sections.filter-select>
            <x-admin.layout.sections.filter-input inpName="cpf" title="CPF" placeholder="CPF do Cliente" />
            <x-admin.layout.sections.filter-select inpName="month_birth" title="Mês de Aniversário">
                @foreach ($months as $keyMonth => $month)
                    <x-admin.layout.sections.filter-select-option inpName="month_birth" :inpValue="$keyMonth"
                        :title="$month" />
                @endforeach
            </x-admin.layout.sections.filter-select>
            <x-admin.layout.sections.filter-input inpName="cnpj" title="CNPJ" placeholder="CNPJ do Cliente" />
            <x-admin.layout.sections.filter-input inpName="corporate_name" title="Razão Social"
                placeholder="Razão Social do Cliente" />
        </x-admin.layout.sections.filter>
        <x-admin.layout.sections.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.layout.sections.table-th>
                    Nome
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Tipo de Pessoa
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
                            {{ $item->fullname }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.status-badge :condition="$item->person->fisica()" :trueTitle="$item->person->texto()"
                                :falseTitle="$item->person->texto()" />
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
                            <x-admin.layout.sections.table-action :href="route('admin.customers.edit', $item->id)" title="Editar">
                                <i class="text-base ti ti-edit"></i>
                            </x-admin.layout.sections.table-action>
                            <x-admin.layout.sections.table-action :href="route('admin.customers.destroy', $item->id)" title="Excluir" :destroy="true">
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
