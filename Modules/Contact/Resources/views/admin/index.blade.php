<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Contatos
        </x-admin.layout.sections.page-title>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.filter gridCols="sm:grid-cols-4">
            <x-admin.layout.sections.filter-select inpName="seen" title="Status">
                @foreach ($contactStatus as $statusKey => $statusValue)
                    <x-admin.layout.sections.filter-select-option inpName="status" :inpValue="$statusKey"
                        :title="$statusValue" />
                @endforeach
            </x-admin.layout.sections.filter-select>
            <x-admin.layout.sections.filter-input inpName="name" title="Nome" placeholder="Nome do contato" />
            <x-admin.layout.sections.filter-input inpName="email" title="E-mail" placeholder="contato@email.com.br" />
            <x-admin.layout.sections.filter-input inpName="subject" title="Assunto" placeholder="Assunto do contato" />
        </x-admin.layout.sections.filter>
        <x-admin.layout.sections.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.layout.sections.table-th>
                    Nome
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    E-mail
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Assunto
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Cadastrado
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
                            {{ $item->email }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            {{ $item->subject }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            {{ $item->created_at->format('d/m/Y H:i:s') }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.status-badge :condition="!$item->seen" trueTitle="Novo" falseTitle="Visto" />
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-actions-td>
                            <x-admin.layout.sections.table-action :href="route('admin.contacts.show', $item->id)" title="Visualizar">
                                <i class="text-base ti ti-eye"></i>
                            </x-admin.layout.sections.table-action>
                            <x-admin.layout.sections.table-action :href="route('admin.contacts.destroy', $item->id)" title="Excluir" :destroy="true">
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
