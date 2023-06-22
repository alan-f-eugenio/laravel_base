<x-admin.layout.app>
    @push('stylesAndScript')
        <script src="{{ Vite::asset('resources/js/sortable.min.js') }}"></script>
    @endpush
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Categorias
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.product_categories.create')">
            Cadastrar novo
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.table :collection="$collection" :sortable="true">
            <x-slot name="ths">
                <x-admin.layout.sections.table-th>
                    Ordem
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th width="20%">
                    Título
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
                    <x-admin.layout.sections.product-category-recursive-table :item="$item" :collection="$item->allChilds"
                        :first="true" />
                @empty
                    <x-admin.layout.sections.table-no-result />
                @endforelse
            </x-slot>
        </x-admin.layout.sections.table>
    </x-admin.layout.sections.list-section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const changeCategoryOrdem = (element) => {
                let sortJson = [];
                let sortItens = element.querySelectorAll(":scope > tr:not(.notSortable)");
                sortItens.forEach((el2, i2) => {
                    let newOrdem = parseInt(i2) + 1;
                    if (el2.querySelector('.ordemNumber')) {
                        el2.querySelector('.ordemNumber span').textContent = newOrdem;
                        sortJson[i2] = {
                            id: el2.dataset.id,
                            ordem: newOrdem
                        };
                    }
                })
                fetch("{{ route('admin.product_categories_order') }}", {
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
                changeCategoryOrdem(el1);

                sortList[i1] = Sortable.create(el1, {
                    group: {
                        name: 'nested' + i1,
                        pull: false,
                        put: false,
                    },
                    filter: ".notSortable",
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onUpdate: function(evt) {
                        changeCategoryOrdem(el1);
                    },
                });
            })
        })
    </script>
</x-admin.layout.app>
