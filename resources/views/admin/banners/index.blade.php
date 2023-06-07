<x-admin.layout.app>
    @push('stylesAndScript')
        {{-- <link href="{{ Vite::asset('resources/css/baguetteBox.min.css') }}" rel="stylesheet"> --}}

        <script src="{{ Vite::asset('resources/js/sortable.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/js/spotlight.bundle.js') }}"></script>
        {{-- <script src="{{ Vite::asset('resources/js/baguetteBox.min.js') }}"></script> --}}
    @endpush
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Banners
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.banners.create')">
            Cadastrar novo
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.filter gridCols="sm:grid-cols-3">
            <x-admin.layout.sections.filter-select inpName="status" title="Status">
                @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                    <x-admin.layout.sections.filter-select-option inpName="status" :inpValue="$statusKey" :title="$statusValue" />
                @endforeach
            </x-admin.layout.sections.filter-select>
            <x-admin.layout.sections.filter-input inpName="title" title="Título" placeholder="Título do banner" />
            <x-admin.layout.sections.filter-select inpName="local_id" title="Local">
                @foreach (\App\Models\BannerLocal::all() as $local)
                    <x-admin.layout.sections.filter-select-option inpName="local_id" :inpValue="$local->id"
                        :title="$local->title" />
                @endforeach
            </x-admin.layout.sections.filter-select>
        </x-admin.layout.sections.filter>
        @foreach ($collection as $local => $items)
            <x-admin.layout.sections.form-subtitle>
                {{ $local }}
            </x-admin.layout.sections.form-subtitle>
            <x-admin.layout.sections.table :collection="$items" :sortable="true">
                <x-slot name="ths">
                    <x-admin.layout.sections.table-th>
                        Ordem
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th>
                        Título
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th>
                        Local
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
                    @forelse ($items as $item)
                        <tr data-id="{{ $item->id }}" class="bg-white border-b">
                            <x-admin.layout.sections.table-td class="ordemNumber">
                                {{ $item->ordem }}
                            </x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.table-td :main="true">
                                {{ $item->title }}
                            </x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.table-td>
                                {{ $item->local->title }}
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
                                <x-admin.layout.sections.table-action class="spotlight" :data-title="$local . ' - ' . $item->title"
                                    :href="asset('storage/' . $item->filename)" title="Visualizar">
                                    <i class="text-base ti ti-eye"></i>
                                </x-admin.layout.sections.table-action>
                                <x-admin.layout.sections.table-action :href="route('admin.banners.edit', $item->id)" title="Editar">
                                    <i class="text-base ti ti-edit"></i>
                                </x-admin.layout.sections.table-action>
                                <x-admin.layout.sections.table-action :href="route('admin.banners.destroy', $item->id)" title="Excluir"
                                    :destroy="true">
                                    <i class="text-base ti ti-trash"></i>
                                </x-admin.layout.sections.table-action>
                            </x-admin.layout.sections.table-actions-td>
                        </tr>
                    @empty
                        <x-admin.layout.sections.table-no-result />
                    @endforelse
                </x-slot>
            </x-admin.layout.sections.table>
        @endforeach
    </x-admin.layout.sections.list-section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const changeBannersOrdem = (element) => {
                let sortJson = [];
                let sortItens = element.querySelectorAll("tr");
                sortItens.forEach((el2, i2) => {
                    let newOrdem = parseInt(i2) + 1;
                    el2.querySelector('.ordemNumber').textContent = newOrdem;
                    sortJson[i2] = {
                        id: el2.dataset.id,
                        ordem: newOrdem
                    };
                })
                fetch("{{ route('admin.banners_order') }}", {
                    headers: {
                        "Content-type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    method: "PUT",
                    body: JSON.stringify(sortJson)
                });
            }

            let sortables = document.querySelectorAll(".table-sortable");
            sortList = [];
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

            // baguetteBox.run('.bagueteBox', {
            //     captions: function(element) {
            //         return element.getElementsByTagName('img')[0].alt;
            //     }
            // });
        })
    </script>
</x-admin.layout.app>
