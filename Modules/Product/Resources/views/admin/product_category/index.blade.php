<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Categorias
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.product_categories.create')">
            Cadastrar novo
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.table :collection="$collection" :sortable="true">
            <x-slot name="ths">
                <x-admin.table-th>
                    Ordem
                </x-admin.table-th>
                <x-admin.table-th width="20%">
                    Título
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
                    <x-product::admin.product-category-recursive-table :item="$item" :collection="$item->allChilds"
                        :first="true" />
                @empty
                    <x-admin.table-no-result />
                @endforelse
            </x-slot>
        </x-admin.table>
    </x-admin.list-section>
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
                axios.put("{{ route('admin.product_categories_order') }}", sortJson)
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
</x-admin-layout>
