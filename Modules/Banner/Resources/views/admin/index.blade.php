<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Banners
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.banners.create')">
            Cadastrar novo
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.filter gridCols="sm:grid-cols-3">
            <x-admin.filter-select inpName="status" title="Status">
                @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                    <x-admin.filter-select-option inpName="status" :inpValue="$statusKey" :title="$statusValue" />
                @endforeach
            </x-admin.filter-select>
            <x-admin.filter-input inpName="title" title="Título" placeholder="Título do banner" />
            <x-admin.filter-select inpName="local_id" title="Local">
                @foreach ($bannerLocals as $local)
                    <x-admin.filter-select-option inpName="local_id" :inpValue="$local->id" :title="$local->title" />
                @endforeach
            </x-admin.filter-select>
        </x-admin.filter>
        @foreach ($collection as $local => $items)
            <x-admin.form-subtitle>
                {{ $local }}
            </x-admin.form-subtitle>
            <x-admin.table :collection="$items" :sortable="true">
                <x-slot name="ths">
                    <x-admin.table-th>
                        Ordem
                    </x-admin.table-th>
                    <x-admin.table-th>
                        Título
                    </x-admin.table-th>
                    <x-admin.table-th>
                        Local
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
                    @forelse ($items as $item)
                        <tr data-id="{{ $item->id }}" class="bg-white border-b">
                            <x-admin.table-td class="ordemNumber cursor-grab">
                                <i class="mr-3 text-base ti ti-arrows-up-down"></i>
                                <span class="text-xl">{{ $item->ordem }}</span>
                            </x-admin.table-td>
                            <x-admin.table-td :main="true">
                                {{ $item->title }}
                            </x-admin.table-td>
                            <x-admin.table-td>
                                {{ $item->local->title }}
                            </x-admin.table-td>
                            <x-admin.table-td>
                                {{ $item->created_at->format('d/m/Y H:i:s') }}
                            </x-admin.table-td>
                            <x-admin.table-td>
                                {{ $item->updated_at != $item->created_at ? $item->updated_at->format('d/m/Y H:i:s') : 'Nunca' }}
                            </x-admin.table-td>
                            <x-admin.table-td>
                                <x-admin.status-badge :condition="$item->status->ativo()" :trueTitle="$item->status->texto()" :falseTitle="$item->status->texto()" />
                            </x-admin.table-td>
                            <x-admin.table-actions-td>
                                <x-admin.table-action class="spotlight" :data-title="$local . ' - ' . $item->title" :href="asset('storage/' . $item->filename)"
                                    title="Visualizar">
                                    <i class="text-base ti ti-eye"></i>
                                </x-admin.table-action>
                                <x-admin.table-action :href="route('admin.banners.edit', $item->id)" title="Editar">
                                    <i class="text-base ti ti-edit"></i>
                                </x-admin.table-action>
                                <x-admin.table-action :href="route('admin.banners.destroy', $item->id)" title="Excluir" :destroy="true">
                                    <i class="text-base ti ti-trash"></i>
                                </x-admin.table-action>
                            </x-admin.table-actions-td>
                        </tr>
                    @empty
                        <x-admin.table-no-result />
                    @endforelse
                </x-slot>
            </x-admin.table>
        @endforeach
    </x-admin.list-section>
    <script type="module">
        document.addEventListener("DOMContentLoaded", () => {

            const changeBannersOrdem = (element) => {
                let sortJson = [];
                let sortItens = element.querySelectorAll("tr");
                sortItens.forEach((el2, i2) => {
                    let newOrdem = parseInt(i2) + 1;
                    el2.querySelector('.ordemNumber span').textContent = newOrdem;
                    sortJson[i2] = {
                        id: el2.dataset.id,
                        ordem: newOrdem
                    };
                })
                axios.put("{{ route('admin.banners_order') }}", sortJson);
            }

            let sortables = document.querySelectorAll(".table-sortable");
            let sortList = [];
            sortables.forEach((el1, i1) => {
                changeBannersOrdem(el1);

                sortList[i1] = Sortable.create(el1, {
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onUpdate: function(evt) {
                        changeBannersOrdem(el1);
                    },
                });
            })
        })
    </script>
</x-admin-layout>
