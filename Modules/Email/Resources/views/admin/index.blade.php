<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Lista de E-mails
        </x-admin.page-title>
    </x-slot>
    <x-admin.list-section>
        <x-admin.filter gridCols="sm:grid-cols-2">
            <x-admin.filter-input inpName="name" title="Nome" placeholder="Nome" />
            <x-admin.filter-input inpName="email" title="E-mail" placeholder="contato@email.com.br" />
        </x-admin.filter>
        <x-admin.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.table-th>
                    Nome
                </x-admin.table-th>
                <x-admin.table-th>
                    Login
                </x-admin.table-th>
                <x-admin.table-th>
                    Cadastrado
                </x-admin.table-th>
                <x-admin.table-th>
                    Ações
                </x-admin.table-th>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($collection as $item)
                    <tr class="bg-white border-b">
                        <x-admin.table-td :main="true">
                            {{ $item->name }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->email }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->created_at->format('d/m/Y H:i:s') }}
                        </x-admin.table-td>
                        <x-admin.table-actions-td>
                            <x-admin.table-action :href="route('admin.emails.destroy', $item->id)" title="Excluir" :destroy="true">
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
