<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Lista de E-mails
        </x-admin.layout.sections.page-title>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.filter gridCols="sm:grid-cols-2">
            <x-admin.layout.sections.filter-input inpName="name" title="Nome" placeholder="Nome" />
            <x-admin.layout.sections.filter-input inpName="email" title="E-mail" placeholder="contato@email.com.br" />
        </x-admin.layout.sections.filter>
        <x-admin.layout.sections.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.layout.sections.table-th>
                    Nome
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Login
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Cadastrado
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
                            {{ $item->created_at->format('d/m/Y H:i:s') }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-actions-td>
                            <x-admin.layout.sections.table-action :href="route('admin.emails.destroy', $item->id)" title="Excluir" :destroy="true">
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
