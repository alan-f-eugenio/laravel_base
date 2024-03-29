<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Usuários
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.users.create')">
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
            <x-admin.filter-input inpName="name" title="Nome" placeholder="Nome do contato" />
            <x-admin.filter-input inpName="email" title="Login do Usuário"
                placeholder="usuario@login.com.br" />
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
                            {{ $item->name }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->email }}
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
                            <x-admin.table-action :href="$item->id == auth('admin')->id()
                                ? route('admin.profile.edit')
                                : route('admin.users.edit', $item->id)" title="Editar">
                                <i class="text-base align-middle icon-[tabler--edit]"></i>
                            </x-admin.table-action>
                            @if ($item->id != auth('admin')->id())
                                <x-admin.table-action :href="route('admin.users.destroy', $item->id)" title="Excluir"
                                    :destroy="true">
                                    <i class="text-base align-middle icon-[tabler--trash]"></i>
                                </x-admin.table-action>
                            @else
                                <x-admin.table-action-disabled>
                                    <i class="text-base align-middle icon-[tabler--trash]"></i>
                                </x-admin.table-action-disabled>
                            @endif
                        </x-admin.table-actions-td>
                    </tr>
                @empty
                    <x-admin.table-no-result />
                @endforelse
            </x-slot>
        </x-admin.table>
    </x-admin.list-section>
</x-admin-layout>
