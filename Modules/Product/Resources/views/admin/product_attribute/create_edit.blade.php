<x-admin.layout.app>
    @push('stylesAndScript')
        <script src="{{ Vite::asset('resources/js/sortable.min.js') }}"></script>
    @endpush
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Atributos >
            <x-admin.layout.sections.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.product_attributes.index')">
            Listar Atributos
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form :action="$item->id
            ? route('admin.product_attributes.update', $item->id)
            : route('admin.product_attributes.store')" :editing="(bool) $item->id" :hasFile="true">
            <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-2">
                <x-admin.layout.sections.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.layout.sections.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.layout.sections.form-select>
                <x-admin.layout.sections.form-label inpName="name" title="Nome">
                    <x-admin.layout.sections.form-input inpName="name" placeholder="Nome do atributo" :inpValue="old('name') ?: $item->name"
                        required />
                </x-admin.layout.sections.form-label>
            </x-admin.layout.sections.form-grid>
            <x-admin.layout.sections.table :collection="$item->options" :sortable="true">
                <x-slot name="ths">
                    <x-admin.layout.sections.table-th>
                        Ordem
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th>
                        Opção do Atributo
                    </x-admin.layout.sections.table-th>
                    @if ($item->has_files)
                        <x-admin.layout.sections.table-th>
                            Imagem
                        </x-admin.layout.sections.table-th>
                    @endif
                    <x-admin.layout.sections.table-th>
                        Cadastrado
                    </x-admin.layout.sections.table-th>
                    <x-admin.layout.sections.table-th>
                        Ações
                    </x-admin.layout.sections.table-th>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($listOptions as $keyOption => $option)
                        <tr class="bg-white border-b optBox">
                            <x-admin.layout.sections.table-td class="ordemNumber cursor-grab">
                                <i class="mr-3 text-base ti ti-arrows-up-down"></i>
                                <span class="text-xl">{{ $option->ordem }}</span>
                                <x-admin.layout.sections.form-input type="hidden" inpName="option_ordem[]" required
                                    :inpValue="$option->ordem" />
                                <x-admin.layout.sections.form-input type="hidden" inpName="option_id[]" required
                                    :inpValue="$option->id" />
                            </x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.table-td>
                                <x-admin.layout.sections.form-input inpName="option_name[]" required
                                    placeholder="Nome da opção" :inpValue="$option->name" />
                            </x-admin.layout.sections.table-td>
                            @if ($item->has_files)
                                <x-admin.layout.sections.table-actions-td>
                                    <div class="flex flex-col items-center justify-center">
                                        <x-admin.layout.sections.table-action href="javascript:;"
                                            class="z-10 addOptPhoto" :hasPhoto="(bool) $option->filename" :title="(!$option->filename ? 'Adicionar' : 'Alterar') . ' Imagem'">
                                            @if ($option->filename)
                                                <div class="w-10 h-10">
                                                    <div class="h-full mx-auto">
                                                        <img class="object-contain object-center w-full h-full"
                                                            src="{{ asset('storage/' . $option->filename) }}" />
                                                    </div>
                                                </div>
                                            @else
                                                <i class="text-base ti ti-photo-plus"></i>
                                            @endif
                                        </x-admin.layout.sections.table-action>
                                        <input class="w-px h-px option_filename -z-10" type="file"
                                            name="option_filename[]" accept=".png, .jpg, .jpeg">
                                    </div>
                                </x-admin.layout.sections.table-actions-td>
                            @endif
                            <x-admin.layout.sections.table-td>
                                {{ $option->created_at ? $option->created_at->format('d/m/Y H:i:s') : 'Salve para confirmar' }}
                                <x-admin.layout.sections.form-input type="hidden" inpName="option_created_at[]"
                                    required :inpValue="$option->created_at" />
                            </x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.table-actions-td>
                                <x-admin.layout.sections.table-action href="javascript:;" class="removeOptBtn"
                                    title="Remover Opção">
                                    <i class="text-base ti ti-trash"></i>
                                </x-admin.layout.sections.table-action>
                            </x-admin.layout.sections.table-actions-td>
                        </tr>
                    @endforeach
                    <tr class="hidden bg-white border-b optBoxNew notSortable">
                        <x-admin.layout.sections.table-td class="ordemNumber cursor-grab">
                            <i class="mr-3 text-base ti ti-arrows-up-down"></i>
                            <span class="text-xl"></span>
                            <x-admin.layout.sections.form-input type="hidden" inpName="option_ordem[]" disabled
                                required />
                            <x-admin.layout.sections.form-input type="hidden" inpName="option_id[]" disabled
                                required />
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            <x-admin.layout.sections.form-input inpName="option_name[]" disabled required
                                placeholder="Nome da opção" />
                        </x-admin.layout.sections.table-td>
                        @if ($item->has_files)
                            <x-admin.layout.sections.table-actions-td>
                                <div class="flex flex-col items-center justify-center">
                                    <x-admin.layout.sections.table-action href="javascript:;" class="z-10 addOptPhoto"
                                        title="Adicionar Opção">
                                        <i class="text-base ti ti-photo-plus"></i>
                                    </x-admin.layout.sections.table-action>
                                    <input class="w-px h-px option_filename -z-10" type="file"
                                        name="option_filename[]" accept=".png, .jpg, .jpeg" disabled required>
                                </div>
                            </x-admin.layout.sections.table-actions-td>
                        @endif
                        <x-admin.layout.sections.table-td>
                            Salve para confirmar
                            <x-admin.layout.sections.form-input type="hidden" inpName="option_created_at[]" required
                                disabled />
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-actions-td>
                            <x-admin.layout.sections.table-action href="javascript:;" class="removeOptBtn"
                                title="Remover Opção">
                                <i class="text-base ti ti-trash"></i>
                            </x-admin.layout.sections.table-action>
                        </x-admin.layout.sections.table-actions-td>
                    </tr>
                </x-slot>
                <x-slot name="tfoot">
                    <tr class="bg-white">
                        <x-admin.layout.sections.table-td colspan="{{ $item->has_files ? 4 : 3 }}">
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-actions-td>
                            <x-admin.layout.sections.table-action href="javascript:;" id="addOptBtn"
                                title="Adicionar Opção">
                                <i class="text-base ti ti-plus max-h-"></i>
                            </x-admin.layout.sections.table-action>
                        </x-admin.layout.sections.table-actions-td>
                    </tr>
                </x-slot>
            </x-admin.layout.sections.table>
        </x-admin.layout.sections.form>
    </x-admin.layout.sections.list-section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const addOptBtn = document.querySelector("#addOptBtn");
            const optBoxNew = document.querySelector(".optBoxNew");
            const sortableTable = document.querySelector(".table-sortable");

            const updateOrdem = () => {
                let sortItens = sortableTable.querySelectorAll("tr");
                sortItens.forEach((el3, i3) => {
                    let newOrdem3 = parseInt(i3) + 1;
                    el3.querySelector('.ordemNumber span').textContent = newOrdem3;
                    el3.querySelector('.ordemNumber input').value = newOrdem3;
                })
            }
            sortable = Sortable.create(sortableTable, {
                filter: ".notSortable",
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function(evt) {
                    updateOrdem();
                },
            });

            const bindRemoveOpt = (el1) => {
                el1.addEventListener("click", () => {
                    el1.closest("tr").remove();
                    updateOrdem();
                })
            }
            let removeOptBtns = document.querySelectorAll(".removeOptBtn");
            removeOptBtns.forEach((el1) => {
                bindRemoveOpt(el1);
            })

            @if ($item->has_files)
                const bindPhotoOpt = (el1) => {
                    let inpOptPhoto = el1.closest("td").querySelector("input");
                    el1.addEventListener("click", () => {
                        inpOptPhoto.click();
                    })
                    inpOptPhoto.addEventListener("change", (ev1) => {
                        if (ev1.target.files.length > 0) {
                            let imgPreview = URL.createObjectURL(ev1.target.files[0]);
                            el1.innerHTML =
                                '<div class="w-10 h-10"><div class="h-full mx-auto"><img class="object-contain object-center w-full h-full" src="' +
                                imgPreview +
                                '" /></div></div>';
                            el1.classList.remove("px-3", "py-2");
                        } else {
                            el1.classList.add("px-3", "py-2");
                            el1.innerHTML = '<i class="text-base ti ti-photo-plus"></i>';
                        }
                    })
                }
                let addOptPhotos = document.querySelectorAll(".addOptPhoto");
                addOptPhotos.forEach((el1) => {
                    bindPhotoOpt(el1);
                })
            @endif

            addOptBtn.addEventListener("click", () => {
                let counOptBoxes = document.querySelectorAll(".optBox").length;
                let elClone = optBoxNew.cloneNode(true);
                elClone.classList.remove("optBoxNew", "hidden", "notSortable");
                elClone.classList.add("optBox");

                elClone.querySelector(".ordemNumber span").textContent = counOptBoxes + 1;
                elClone.querySelector(".ordemNumber input").value = counOptBoxes + 1;

                elClone.querySelectorAll("input").forEach((el1) => {
                    el1.disabled = false;
                });

                @if ($item->has_files)
                    let addOptPhoto = elClone.querySelector(".addOptPhoto");
                    bindPhotoOpt(addOptPhoto);
                @endif

                let removeOptBtn = elClone.querySelector(".removeOptBtn");
                bindRemoveOpt(removeOptBtn);

                optBoxNew.before(elClone);
            })
        })
    </script>
</x-admin.layout.app>