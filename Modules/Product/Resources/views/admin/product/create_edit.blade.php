<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Produtos >
            <x-admin.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.products.index')">
            Listar Produtos
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section id="section" x-data="{!! '{inPromo: ' .
        (!$inPromo ? 'true' : 'false') .
        ', typeOrca: ' .
        ($typeOrca ? 'true' : 'false') .
        ', hasChild: ' .
        ($hasChild ? '\'' . $hasChild . '\'' : '0') .
        ', childCount: ' .
        $listChilds->count() .
        '}' !!}">
        <x-admin.form :action="$item->id ? route('admin.products.update', $item->id) : route('admin.products.store')" :editing="(bool) $item->id" :hasFile="true">
            <x-admin.form-grid gridCols="sm:grid-cols-2">
                <x-admin.form-subtitle>Dados do Produto</x-admin.form-subtitle>
                <x-admin.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue" :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-select inpName="product_category_id" title="Categoria Principal" required>
                    @foreach ($categories as $category)
                        <x-admin.form-select-option :inpValue="$category->id" :title="$category->name" :selected="(old('product_category_id') ?: $item->product_category?->id) == $category->id" />
                        @if ($category->allChilds())
                            <x-product::admin.product-category-recursive-option :categories="$category->allChilds" :idSelected="$item->category?->id"
                                inpName="product_category_id" />
                        @endif
                    @endforeach
                </x-admin.form-select>
            </x-admin.form-grid>
            <x-admin.form-select id="product_secondary_category_id" inpName="product_secondary_category_id[]"
                title="Categorias Secundárias" size="1" multiple>
                @foreach ($categories as $category)
                    <x-admin.form-select-option :inpValue="$category->id" :title="$category->name" :selected="in_array($category->id, $listSecondaryCat)" />
                    @if ($category->allChilds())
                        <x-product::admin.product-category-recursive-option-tree :categories="$category->allChilds"
                            inpName="product_category_id" :treeStr="$category->name" />
                    @endif
                @endforeach
            </x-admin.form-select>
            <x-admin.form-grid gridCols="sm:grid-cols-2">
                <x-admin.form-label inpName="sku" title="Código">
                    <x-admin.form-input inpName="sku" placeholder="SKU" :inpValue="old('sku') ?: $item->sku" required />
                </x-admin.form-label>
                <x-admin.form-label inpName="name" title="Nome">
                    <x-admin.form-input inpName="name" placeholder="Nome do produto" :inpValue="old('name') ?: $item->name" required />
                </x-admin.form-label>
                <x-admin.form-label inpName="ean" title="EAN">
                    <x-admin.form-input inpName="ean" placeholder="Código de barras" :inpValue="old('ean') ?: $item->ean" />
                </x-admin.form-label>
                <x-admin.form-label inpName="brand" title="Marca">
                    <x-admin.form-input inpName="brand" placeholder="Marca do produto" :inpValue="old('brand') ?: $item->brand" />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-select inpName="type" title="Tipo do Produto" required x-on:change="typeOrca = !typeOrca">
                @foreach ($productTypes as $typeKey => $typeValue)
                    <x-admin.form-select-option :inpValue="$typeKey" :title="$typeValue" :selected="(old('type') ?: $item->type?->value) == $typeKey" />
                @endforeach
            </x-admin.form-select>
            <x-admin.form-grid gridCols="sm:grid-cols-3">
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="price_cost" title="Custo">
                    <x-admin.form-input inpName="price_cost" placeholder="R$ 0,00" :inpValue="old('price_cost') ?: $item->price_cost" required
                        ::disabled="typeOrca" :disabled="$typeOrca" class="moneyMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="price" title="Preço">
                    <x-admin.form-input inpName="price" placeholder="R$ 0,00" :inpValue="old('price') ?: $item->price" required
                        ::disabled="typeOrca" :disabled="$typeOrca" class="moneyMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="weight" title="Peso (kg)">
                    <x-admin.form-input inpName="weight" placeholder="0,000" :inpValue="old('weight') ?: $item->weight" required
                        ::disabled="typeOrca" :disabled="$typeOrca" class="weightMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="width" title="Largura (cm)">
                    <x-admin.form-input inpName="width" placeholder="0" :inpValue="old('width') ?: $item->width" required ::disabled="typeOrca"
                        :disabled="$typeOrca" class="integerMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="height" title="Altura (cm)">
                    <x-admin.form-input inpName="height" placeholder="0" :inpValue="old('height') ?: $item->height" required ::disabled="typeOrca"
                        :disabled="$typeOrca" class="integerMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="depth" title="Comprimento (cm)">
                    <x-admin.form-input inpName="depth" placeholder="0" :inpValue="old('depth') ?: $item->depth" required ::disabled="typeOrca"
                        :disabled="$typeOrca" class="integerMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca && !$hasChild" x-show="!typeOrca && hasChild == 0" inpName="stock"
                    title="Estoque">
                    <x-admin.form-input inpName="stock" placeholder="0" :inpValue="old('stock') ?: $item->stock" required ::disabled="typeOrca || hasChild > 0"
                        :disabled="$typeOrca" class="integerMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="deadline"
                    title="Prazo de Entrega Adicional">
                    <x-admin.form-input inpName="deadline" placeholder="Prazo adicional" :inpValue="old('deadline') ?: $item->deadline"
                        ::disabled="typeOrca" :disabled="$typeOrca" class="integerMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="inPromo"
                    title="Marcar Produto em Promoção">
                    <x-admin.form-check-toggle inpName="inPromo" title="Promoção" x-on:change="inPromo = !inPromo"
                        alpineDisabledVar="typeOrca" :checked="$inPromo" :disabled="$typeOrca" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="!$inPromo || $typeOrca" x-show="!inPromo && !typeOrca" inpName="promo_value"
                    title="Preço Promocional">
                    <x-admin.form-input inpName="promo_value" placeholder="R$ 0,00" :inpValue="old('promo_value') ?: $item->promo_value" required
                        ::disabled="inPromo || typeOrca" :disabled="!$inPromo || $typeOrca" class="moneyMask" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="!$inPromo || $typeOrca" x-show="!inPromo && !typeOrca" inpName="promo_date_in"
                    title="Data de Início da Promoção">
                    <x-admin.form-input inpName="promo_date_in" type="datetime-local" placeholder="00/00/000"
                        :inpValue="old('promo_date_in') ?: $item->promo_date_in" required ::disabled="inPromo || typeOrca" :disabled="!$inPromo || $typeOrca" />
                </x-admin.form-label>
                <x-admin.form-label :xCloak="!$inPromo || $typeOrca" x-show="!inPromo && !typeOrca" inpName="promo_date_end"
                    title="Data de Fim da Promoção">
                    <x-admin.form-input inpName="promo_date_end" type="datetime-local" placeholder="00/00/000"
                        :inpValue="old('promo_date_end') ?: $item->promo_date_end" required ::disabled="inPromo || typeOrca" :disabled="!$inPromo || $typeOrca" />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-grid gridCols="sm:grid-cols-2">
                <x-admin.form-subtitle>Informações do Produto</x-admin.form-subtitle>
                <x-admin.form-label inpName="page_title" title="Título da Página">
                    <x-admin.form-input inpName="page_title" placeholder="Page title" :inpValue="old('page_title') ?: $item->page_title" />
                </x-admin.form-label>
                <x-admin.form-label inpName="meta_description" title="Descrição da Página">
                    <x-admin.form-input inpName="meta_description" placeholder="Meta description"
                        :inpValue="old('meta_description') ?: $item->meta_description" />
                </x-admin.form-label>
                <x-admin.form-label inpName="meta_keywords" title="Palavras Chave">
                    <x-admin.form-input inpName="meta_keywords" placeholder="Meta keywords" :inpValue="old('meta_keywords') ?: $item->meta_keywords" />
                </x-admin.form-label>
                <x-admin.form-label inpName="warranty" title="Informações de Garantia">
                    <x-admin.form-input inpName="warranty" placeholder="Garantia" :inpValue="old('warranty') ?: $item->warranty" />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-textarea inpName="text" title="Descrição do Produto" placeholder="Descrição"
                :inpValue="old('text') ?: $item->text" />
            <x-admin.form-label inpName="filenames" title="Imagens do Produto (arraste para reordenar)">
                <input type="file" class="filepond" name="filenames[]" multiple>
            </x-admin.form-label>
            <x-admin.form-select id="product_related_id" inpName="product_related_id[]" title="Produtos Relacionados"
                size="1" multiple>
                @foreach ($listRelatedProducts as $related)
                    <x-admin.form-select-option :inpValue="$related->id" :title="$related->name" :selected="true" />
                @endforeach
            </x-admin.form-select>
            <x-admin.form-subtitle>Variações</x-admin.form-subtitle>
            <x-admin.form-select inpName="has_child" title="" required x-on:change="hasChild = $el.value"
                ::aria-disabled="childCount > 0" ::tabindex="childCount > 0 ? '-1' : '0'" ::class="childCount > 0 ? 'aria-disabled:bg-gray-300 pointer-events-none touch-none' : ''">
                @foreach ($productHasChildTypes as $hasChildKey => $hasChildValue)
                    <x-admin.form-select-option :inpValue="$hasChildKey" :title="$hasChildValue" :selected="(old('has_child') ?: $item->has_child?->value) == $hasChildKey" />
                @endforeach
            </x-admin.form-select>
            <x-admin.form-grid gridCols="sm:grid-cols-2">
                <x-admin.form-select id="product_attribute1_id" required :xCloak="!$hasChild" ::disabled="hasChild == 0"
                    xShow="hasChild > 0" inpName="product_att1_id" title="Atributo" ::aria-disabled="hasChild == 0 || childCount > 0"
                    ::tabindex="hasChild == 0 || childCount > 0 ? '-1' : '0'" ::class="hasChild == 0 || childCount > 0 ? 'aria-disabled:bg-gray-300 pointer-events-none touch-none' : ''">
                    <option disabled selected value="">Selecione</option>
                    @foreach ($attributes as $attribute)
                        <x-admin.form-select-option :inpValue="$attribute->id" :title="$attribute->name" :selected="(old('product_att1_id') ?: $item->product_att1_id) == $attribute->id" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-select :xCloak="!$hasChild" xShow="hasChild > 0" ::disabled="hasChild == 0" :disabled="!$hasChild || $listChilds->count()"
                    id="product_opt1_id" inpName="product_opt1_id[]" title="Opções" size="1" multiple>
                    <option disabled selected value="">Selecione a(s) opçõe(s)</option>
                </x-admin.form-select>
                <x-admin.form-select :xCloak="!$hasChild" xShow="hasChild == 2" id="product_attribute2_id"
                    ::disabled="hasChild < 2" inpName="product_att2_id" title="Atributo"
                    ::aria-disabled="hasChild < 2 || childCount > 0"
                    ::tabindex="hasChild < 2 || childCount > 0 ? '-1' : '0'"
                    ::class="hasChild < 2 || childCount > 0 ? 'aria-disabled:bg-gray-300 pointer-events-none touch-none' : ''">
                    <option disabled selected value="">Selecione</option>
                    @foreach ($attributes as $attribute)
                        <x-admin.form-select-option :inpValue="$attribute->id" :title="$attribute->name" :selected="(old('product_att2_id') ?: $item->product_att2_id) == $attribute->id" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-select :xCloak="!$hasChild" xShow="hasChild == 2" ::disabled="hasChild < 2"
                    :disabled="!$hasChild" id="product_opt2_id" inpName="product_opt2_id[]" title="Opções"
                    size="1" multiple>
                    <option disabled selected value="">Selecione a(s) opçõe(s)</option>
                </x-admin.form-select>
            </x-admin.form-grid>
            <div class="space-y-5" {{ !$hasChild ? 'x-cloak' : '' }} x-show="hasChild > 0">
                <div class="inline-flex flex-col items-center justify-center">
                    <button id="btnVarAdd" type="button" :disabled="hasChild == 0" disabled="!$hasChild"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Gerar Variações
                    </button>
                    <input class="w-px h-px child_filename -z-10" type="radio" id="checkOptBox">
                </div>
                <x-admin.table :collection="$item->childs" :sortable="true">
                    <x-slot name="ths">
                        <x-admin.table-th>
                            Ordem
                        </x-admin.table-th>
                        <x-admin.table-th>
                            Imagem
                        </x-admin.table-th>
                        <x-admin.table-th>
                            Informações da Variação
                        </x-admin.table-th>
                        <x-admin.table-th>
                            Ações
                        </x-admin.table-th>
                    </x-slot>
                    <x-slot name="tbody">
                        @foreach ($listChilds as $keyChild => $child)
                            <tr class="bg-white border-b optBox">
                                <x-admin.table-td class="text-lg font-bold text-center ordemNumber cursor-grab">
                                    <span>{{ $child->ordem }}</span>
                                    <x-admin.form-input type="hidden" inpName="child_ordem[]" required
                                        :inpValue="$child->ordem" />
                                    <x-admin.form-input type="hidden" inpName="child_id[]" required
                                        :inpValue="$child->id" />
                                </x-admin.table-td>
                                <x-admin.table-actions-td>
                                    <div class="flex flex-col items-center justify-center">
                                        <x-admin.table-action href="javascript:;" class="z-10 addOptPhoto"
                                            :hasPhoto="(bool) $child->filename" :title="(!$child->filename ? 'Adicionar' : 'Alterar') . ' Imagem'">
                                            @if ($child->filename)
                                                <div class="w-24 h-24">
                                                    <div class="h-full mx-auto">
                                                        <img class="object-contain object-center w-full h-full"
                                                            src="{{ asset('storage/' . $child->filename) }}" />
                                                    </div>
                                                </div>
                                            @else
                                                <i class="text-7xl ti ti-photo-plus"></i>
                                            @endif
                                        </x-admin.table-action>
                                        <input class="w-px h-px child_filename -z-10" type="file"
                                            name="child_filename[]" accept=".png, .jpg, .jpeg">
                                    </div>
                                </x-admin.table-actions-td>
                                <x-admin.table-td class="px-6 py-4 space-y-5">
                                    <x-admin.form-grid gridCols="sm:grid-cols-2">
                                        <x-admin.form-select inpName="child_opt1[]"
                                            title="{{ $child->attribute1->name }}" required>
                                            <option disabled selected value="">Selecione</option>
                                            @foreach ($child->attribute1->options as $opt1)
                                                <x-admin.form-select-option :inpValue="$opt1->id" :title="$opt1->name"
                                                    :selected="$child->product_opt1_id == $opt1->id" />
                                            @endforeach
                                        </x-admin.form-select>
                                        @if ($child->attribute2)
                                            <x-admin.form-select inpName="child_opt2[]"
                                                title="{{ $child->attribute2->name }}" required>
                                                <option disabled selected value="">Selecione</option>
                                                @foreach ($child->attribute2->options as $opt2)
                                                    <x-admin.form-select-option :inpValue="$opt2->id" :title="$opt2->name"
                                                        :selected="$child->product_opt2_id == $opt2->id" />
                                                @endforeach
                                            </x-admin.form-select>
                                        @endif
                                    </x-admin.form-grid>
                                    <x-admin.form-grid gridCols="sm:grid-cols-2">
                                        <x-admin.form-label :inpError="old('child_sku') ? 'child_sku.' . $keyChild : null" inpName="child_sku[]" title="Código">
                                            <x-admin.form-input inpName="child_sku[]" placeholder="SKU"
                                                :inpValue="$child->sku" required />
                                        </x-admin.form-label>
                                        <x-admin.form-label inpName="child_ean[]" title="EAN">
                                            <x-admin.form-input inpName="child_ean[]" placeholder="Código de barras"
                                                :inpValue="$child->ean" />
                                        </x-admin.form-label>
                                    </x-admin.form-grid>
                                    <x-admin.form-grid gridCols="sm:grid-cols-3">
                                        <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                            inpName="child_price_cost[]" title="Custo">
                                            <x-admin.form-input inpName="child_price_cost[]" placeholder="R$ 0,00"
                                                :inpValue="$child->price_cost" required ::disabled="typeOrca" :disabled="$typeOrca"
                                                class="moneyMask " />
                                        </x-admin.form-label>
                                        <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                            inpName="child_price[]" title="Preço">
                                            <x-admin.form-input inpName="child_price[]" placeholder="R$ 0,00"
                                                :inpValue="$child->price" required ::disabled="typeOrca" :disabled="$typeOrca"
                                                class="moneyMask " />
                                        </x-admin.form-label>
                                        <x-admin.form-label :xCloak="!$inPromo || $typeOrca" x-show="!inPromo && !typeOrca"
                                            inpName="child_promo_value[]" title="Preço Promocional">
                                            <x-admin.form-input inpName="child_promo_value[]" placeholder="R$ 0,00"
                                                :inpValue="$child->promo_value" required ::disabled="inPromo || typeOrca" :disabled="!$inPromo || $typeOrca"
                                                class="moneyMask " />
                                        </x-admin.form-label>
                                        <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                            inpName="child_weight[]" title="Peso (kg)">
                                            <x-admin.form-input inpName="child_weight[]" placeholder="0,000"
                                                :inpValue="$child->weight" required ::disabled="typeOrca" :disabled="$typeOrca"
                                                class="weightMask " />
                                        </x-admin.form-label>
                                        <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                            inpName="child_width[]" title="Largura (cm)">
                                            <x-admin.form-input inpName="child_width[]" placeholder="0"
                                                :inpValue="$child->width" required ::disabled="typeOrca" :disabled="$typeOrca"
                                                class="integerMask" />
                                        </x-admin.form-label>
                                        <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                            inpName="child_height[]" title="Altura (cm)">
                                            <x-admin.form-input inpName="child_height[]" placeholder="0"
                                                :inpValue="$child->height" required ::disabled="typeOrca" :disabled="$typeOrca"
                                                class="integerMask" />
                                        </x-admin.form-label>
                                        <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                            inpName="child_depth[]" title="Comprimento (cm)">
                                            <x-admin.form-input inpName="child_depth[]" placeholder="0"
                                                :inpValue="$child->depth" required ::disabled="typeOrca" :disabled="$typeOrca"
                                                class="integerMask" />
                                        </x-admin.form-label>
                                        <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                            inpName="child_stock[]" title="Estoque">
                                            <x-admin.form-input inpName="child_stock[]" placeholder="0"
                                                :inpValue="$child->stock" required ::disabled="typeOrca" :disabled="$typeOrca"
                                                class="integerMask" />
                                        </x-admin.form-label>
                                    </x-admin.form-grid>
                                </x-admin.table-td>
                                <x-admin.table-actions-td>
                                    <x-admin.table-action href="javascript:;" class="upOptBtn"
                                        title="Subir Ordenação">
                                        <i class="text-base ti ti-arrow-move-up"></i>
                                    </x-admin.table-action>
                                    <x-admin.table-action href="javascript:;" class="downOptBtn"
                                        title="Descer Ordenação">
                                        <i class="text-base ti ti-arrow-move-down"></i>
                                    </x-admin.table-action>
                                    <x-admin.table-action href="javascript:;" class="removeOptBtn"
                                        title="Remover Opção">
                                        <i class="text-base ti ti-trash"></i>
                                    </x-admin.table-action>
                                </x-admin.table-actions-td>
                            </tr>
                        @endforeach
                        <tr class="hidden bg-white border-b optBoxNew notSortable">
                            <x-admin.table-td class="text-lg font-bold text-center ordemNumber cursor-grab">
                                <span></span>
                                <x-admin.form-input type="hidden" inpName="child_ordem[]" disabled required />
                                <x-admin.form-input type="hidden" inpName="child_id[]" disabled required />
                            </x-admin.table-td>
                            <x-admin.table-actions-td>
                                <div class="flex flex-col items-center justify-center">
                                    <x-admin.table-action href="javascript:;" class="z-10 addOptPhoto"
                                        title="Adicionar Imagem">
                                        <i class="text-7xl ti ti-photo-plus"></i>
                                    </x-admin.table-action>
                                    <input class="w-px h-px child_filename -z-10" type="file"
                                        name="child_filename[]" accept=".png, .jpg, .jpeg" disabled>
                                </div>
                            </x-admin.table-actions-td>
                            <x-admin.table-td class="px-6 py-4 space-y-5">
                                <x-admin.form-grid gridCols="sm:grid-cols-2">
                                    <x-admin.form-select inpName="child_opt1[]" title="Opção de Atributo 1" required
                                        disabled>
                                        <option disabled selected value="">Selecione</option>
                                    </x-admin.form-select>
                                    <x-admin.form-select inpName="child_opt2[]" title="Opção de Atributo 2" required
                                        disabled>
                                        <option disabled selected value="">Selecione</option>
                                    </x-admin.form-select>
                                </x-admin.form-grid>
                                <x-admin.form-grid gridCols="sm:grid-cols-2">
                                    <x-admin.form-label inpName="child_sku[]" title="Código">
                                        <x-admin.form-input inpName="child_sku[]" placeholder="SKU" required
                                            disabled />
                                    </x-admin.form-label>
                                    <x-admin.form-label inpName="child_ean[]" title="EAN">
                                        <x-admin.form-input inpName="child_ean[]" placeholder="Código de barras"
                                            disabled />
                                    </x-admin.form-label>
                                </x-admin.form-grid>
                                <x-admin.form-grid gridCols="sm:grid-cols-3">
                                    <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                        inpName="child_price_cost[]" title="Custo">
                                        <x-admin.form-input inpName="child_price_cost[]" placeholder="R$ 0,00"
                                            required disabled class="moneyMask notTypeOrca" />
                                    </x-admin.form-label>
                                    <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="child_price[]"
                                        title="Preço">
                                        <x-admin.form-input inpName="child_price[]" placeholder="R$ 0,00" required
                                            disabled class="moneyMask notTypeOrca" />
                                    </x-admin.form-label>
                                    <x-admin.form-label :xCloak="!$inPromo || $typeOrca" x-show="!inPromo && !typeOrca"
                                        inpName="child_promo_value[]" disabled title="Preço Promocional">
                                        <x-admin.form-input inpName="child_promo_value[]" placeholder="R$ 0,00"
                                            required disabled class="moneyMask notTypeOrca inPromo" />
                                    </x-admin.form-label>
                                    <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                        inpName="child_weight[]" title="Peso (kg)">
                                        <x-admin.form-input inpName="child_weight[]" placeholder="0,000" required
                                            disabled class="weightMask notTypeOrca" />
                                    </x-admin.form-label>
                                    <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="child_width[]"
                                        title="Largura (cm)">
                                        <x-admin.form-input inpName="child_width[]" placeholder="0" required disabled
                                            class="notTypeOrca integerMask" />
                                    </x-admin.form-label>
                                    <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca"
                                        inpName="child_height[]" title="Altura (cm)">
                                        <x-admin.form-input inpName="child_height[]" placeholder="0" required disabled
                                            class="notTypeOrca integerMask" />
                                    </x-admin.form-label>
                                    <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="child_depth[]"
                                        title="Comprimento (cm)">
                                        <x-admin.form-input inpName="child_depth[]" placeholder="0" required disabled
                                            class="notTypeOrca integerMask" />
                                    </x-admin.form-label>
                                    <x-admin.form-label :xCloak="$typeOrca" x-show="!typeOrca" inpName="child_stock[]"
                                        title="Estoque">
                                        <x-admin.form-input inpName="child_stock[]" placeholder="0" required disabled
                                            class="notTypeOrca integerMask" />
                                    </x-admin.form-label>
                                </x-admin.form-grid>
                            </x-admin.table-td>
                            <x-admin.table-actions-td>
                                <x-admin.table-action href="javascript:;" class="upOptBtn" title="Subir Ordenação">
                                    <i class="text-base ti ti-arrow-move-up"></i>
                                </x-admin.table-action>
                                <x-admin.table-action href="javascript:;" class="downOptBtn"
                                    title="Descer Ordenação">
                                    <i class="text-base ti ti-arrow-move-down"></i>
                                </x-admin.table-action>
                                <x-admin.table-action href="javascript:;" class="removeOptBtn" title="Remover Opção">
                                    <i class="text-base ti ti-trash"></i>
                                </x-admin.table-action>
                            </x-admin.table-actions-td>
                        </tr>
                    </x-slot>
                </x-admin.table>
            </div>

        </x-admin.form>
    </x-admin.list-section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new TomSelect("#product_secondary_category_id", {
                plugins: {
                    remove_button: {
                        title: 'Remover',
                    }
                },
                placeholder: "Selecione categoria(s) secundária(s)",
                hidePlaceholder: true,
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Nenhum resultado encontrado para "' + escape(
                                data.input) +
                            '"</div>';
                    },
                }
            });

            const product_related = new TomSelect("#product_related_id", {
                plugins: {
                    remove_button: {
                        title: 'Remover',
                    }
                },
                placeholder: "Procure produtos relacionados",
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                onType: function(str) {
                    product_related.load(str);
                },
                load: function(query, callback) {
                    axios.get("{{ route('admin.products.search') }}?name=" +
                            encodeURIComponent(query) + "&except={{ $item->id }}")
                        .then(response => {
                            callback(response.data);
                        }).catch(() => {
                            callback();
                        });
                },
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Nenhum resultado encontrado para "' + escape(
                                data.input) +
                            '"</div>';
                    },
                }
            });

            const section = document.querySelector("#section");
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
                disabled: true,
                filter: ".notSortable",
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                easing: "cubic-bezier(1, 0, 0, 1)",
                onUpdate: function(evt) {
                    updateOrdem();
                },
            });
            updateOrdem();

            const productOpt1 = new TomSelect('#product_opt1_id', {
                plugins: {
                    remove_button: {
                        title: 'Remover',
                    }
                },
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                placeholder: "Selecione a(s) opçõe(s)",
                hidePlaceholder: true
            });

            const product_att1_id = document.querySelector("#product_attribute1_id");
            const getAtt1Opts = (openOpts = true) => {
                if (product_att1_id.value) {
                    axios.get("{{ route('admin.product_attribute_opts.index') }}?attribute=" + product_att1_id
                            .value)
                        .then(response => {
                            productOpt1.clear();
                            productOpt1.clearOptions();
                            productOpt1.addOptions(response.data);
                            productOpt1.refreshOptions(openOpts);
                        });
                }
            }
            getAtt1Opts(false);
            product_att1_id.addEventListener("change", () => {
                getAtt1Opts();
            })

            const productOpt2 = new TomSelect('#product_opt2_id', {
                plugins: {
                    remove_button: {
                        title: 'Remover',
                    }
                },
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                placeholder: "Selecione a(s) opçõe(s)",
                hidePlaceholder: true
            });
            const product_att2_id = document.querySelector("#product_attribute2_id");
            const getAtt2Opts = (openOpts = true) => {
                if (product_att2_id.value) {
                    axios.get("{{ route('admin.product_attribute_opts.index') }}?attribute=" + product_att2_id
                            .value)
                        .then(response => {
                            productOpt2.clear();
                            productOpt2.clearOptions();
                            productOpt2.addOptions(response.data);
                            productOpt2.refreshOptions(openOpts);
                        });
                }
            }
            getAtt2Opts(false);
            product_att2_id.addEventListener("change", () => {
                getAtt2Opts();
            })

            const hasChild = document.querySelector('#has_child')
            hasChild.addEventListener('change', () => {
                if (hasChild.value == 1) {
                    productOpt1.unlock();
                    productOpt1.enable();
                    productOpt2.lock();
                    productOpt2.disable();
                } else if (hasChild.value == 2) {
                    productOpt1.unlock();
                    productOpt1.enable();
                    productOpt2.unlock();
                    productOpt2.enable();
                } else {
                    productOpt1.lock();
                    productOpt1.disable();
                    productOpt2.lock();
                    productOpt2.disable();
                }
            })

            const bindRemoveOpt = (el1) => {
                el1.addEventListener("click", () => {
                    el1.closest("tr").remove();
                    section._x_dataStack[0].childCount--;
                    updateOrdem();
                })
            }
            let removeOptBtns = document.querySelectorAll(".removeOptBtn");
            removeOptBtns.forEach((el1) => {
                bindRemoveOpt(el1);
            })

            const bindMoveUpOpt = (el1) => {
                el1.addEventListener("click", () => {
                    let sortItens = sortableTable.querySelectorAll("tr");
                    sortItens.forEach((el2, i2) => {
                        if (el1.closest('tr') == el2) {
                            let sortArray = sortable.toArray();
                            if (i2 - 1 >= 0) {
                                let sortI = sortArray[i2];
                                sortArray[i2] = sortArray[i2 - 1];
                                sortArray[i2 - 1] = sortI;
                                sortable.sort(sortArray, true);
                            }
                        }
                    })
                    updateOrdem();
                })
            }
            let upOptBtns = document.querySelectorAll(".upOptBtn");
            upOptBtns.forEach((el1) => {
                bindMoveUpOpt(el1);
            })

            const bindMoveDownOpt = (el1) => {
                el1.addEventListener("click", () => {
                    let sortItens = sortableTable.querySelectorAll("tr");
                    sortItens.forEach((el2, i2) => {
                        if (el1.closest('tr') == el2) {
                            let sortArray = sortable.toArray();
                            if (i2 + 1 < sortArray.length - 1) {
                                let sortI = sortArray[i2];
                                sortArray[i2] = sortArray[i2 + 1];
                                sortArray[i2 + 1] = sortI;
                                sortable.sort(sortArray, true);
                            }
                        }
                    })
                    updateOrdem();
                })
            }
            let downOptBtns = document.querySelectorAll(".downOptBtn");
            downOptBtns.forEach((el1) => {
                bindMoveDownOpt(el1);
            })

            const bindPhotoOpt = (el1) => {
                let inpOptPhoto = el1.closest("td").querySelector("input");
                el1.addEventListener("click", () => {
                    inpOptPhoto.click();
                })
                inpOptPhoto.addEventListener("change", (ev1) => {
                    if (ev1.target.files.length > 0) {
                        let imgPreview = URL.createObjectURL(ev1.target.files[0]);
                        el1.innerHTML =
                            '<div class="w-24 h-24"><div class="h-full mx-auto"><img class="object-contain object-center w-full h-full" src="' +
                            imgPreview +
                            '" /></div></div>';
                        el1.classList.remove("px-3", "py-2");
                    } else {
                        el1.classList.add("px-3", "py-2");
                        el1.innerHTML = '<i class="text-7xl ti ti-photo-plus"></i>';
                    }
                })
            }
            let addOptPhotos = document.querySelectorAll(".addOptPhoto");
            addOptPhotos.forEach((el1) => {
                bindPhotoOpt(el1);
            })

            const btnVarAdd = document.querySelector('#btnVarAdd');
            btnVarAdd.addEventListener('click', () => {
                if (!hasChild.value || (hasChild.value == 2 && ((!product_att1_id.value || !productOpt1
                        .items.length) || (!product_att2_id.value || !productOpt2.items.length))) || (
                        hasChild.value == 1 && (!product_att1_id.value || !productOpt1.items.length))) {
                    return false;
                }

                let cloneOptList = [];
                att1 = {
                    id: product_att1_id.value,
                    name: product_att1_id.querySelector('option:checked').textContent,
                    options: productOpt1.items.map((it1) => {
                        return {
                            id: it1,
                            name: productOpt1.options[it1].name
                        }
                    })
                }

                if (att2 = (hasChild.value == 2 ? {
                        id: product_att2_id.value,
                        name: product_att2_id.querySelector('option:checked').textContent,
                        options: productOpt2.items.map((it2) => {
                            return {
                                id: it2,
                                name: productOpt2.options[it2].name
                            }
                        })
                    } : null)) {
                    productOpt1.items.forEach((id1) => {
                        productOpt2.items.forEach((id2) => {
                            let id1Text = productOpt1.options[id1].name;
                            let id2Text = productOpt2.options[id2]?.name;
                            let present = false;
                            document.querySelectorAll(".optBox").forEach((el2) => {
                                if (el2.querySelector("select[name^='child_opt1']")
                                    .value === id1 &&
                                    el2.querySelector("select[name^='child_opt2']")
                                    .value === id2) {
                                    present = true;
                                }
                            })
                            if (!present) {
                                cloneOptList.push({
                                    id1: id1,
                                    id1Text: id1Text,
                                    id2: id2,
                                    id2Text: id2Text,
                                });
                            }
                        })
                    })
                } else {
                    productOpt1.items.forEach((id1) => {
                        let id1Text = productOpt1.options[id1].name;
                        let present = false;
                        document.querySelectorAll(".optBox").forEach((el2) => {
                            if (el2.querySelector("select[name^='child_opt1']")
                                .value === id1) {
                                present = true;
                            }
                        })
                        if (!present) {
                            cloneOptList.push({
                                id1: id1,
                                id1Text: id1Text,
                            });
                        }
                    })
                }

                cloneOptList.forEach((cloneOpt) => {
                    let counOptBoxes = document.querySelectorAll(".optBox").length;
                    let elClone = optBoxNew.cloneNode(true);
                    elClone.classList.remove("optBoxNew", "hidden", "notSortable");
                    elClone.classList.add("optBox");

                    elClone.querySelector(".ordemNumber span").textContent = counOptBoxes + 1;
                    elClone.querySelector(".ordemNumber input").value = counOptBoxes + 1;

                    elClone.querySelectorAll("input").forEach((el1) => {
                        let typeOrca = section._x_dataStack[0].typeOrca;
                        let inPromo = section._x_dataStack[0].inPromo;
                        if (!el1.classList.contains("notTypeOrca") || !typeOrca) {
                            el1.disabled = false;
                        }
                        if (el1.classList.contains("notTypeOrca")) {
                            if (el1.classList.contains("inPromo")) {
                                el1.setAttribute(":disabled", "inPromo || typeOrca")
                            } else {
                                el1.setAttribute(":disabled", "typeOrca")
                            }
                            el1.classList.remove('notTypeOrca')
                        }
                    });
                    Inputmask(integerOptions).mask(elClone.querySelectorAll(".integerMask"));
                    Inputmask(moneyOptions).mask(elClone.querySelectorAll(".moneyMask"));
                    Inputmask(decimalOptions).mask(elClone.querySelectorAll(".decimalMask"));
                    Inputmask(weightOptions).mask(elClone.querySelectorAll(".weightMask"));

                    elClone.querySelectorAll("select").forEach((el1) => {
                        el1.disabled = false;
                        if (el1.name == "child_opt1[]") {
                            axios.get(
                                    "{{ route('admin.product_attribute_opts.index') }}?attribute=" +
                                    product_att1_id.value)
                                .then(response => {
                                    response.data.forEach((opt1) => {
                                        let optHtml = document.createElement(
                                            "option");
                                        optHtml.value = opt1.id;
                                        optHtml.text = opt1.name;
                                        if (opt1.id == cloneOpt.id1) {
                                            optHtml.selected = true;
                                        }
                                        el1.add(optHtml);
                                    })
                                });
                            el1.closest("div").querySelector("label").textContent = att1
                                .name;
                        } else if (el1.name == "child_opt2[]") {
                            if (hasChild.value == 2) {
                                axios.get(
                                        "{{ route('admin.product_attribute_opts.index') }}?attribute=" +
                                        product_att2_id.value)
                                    .then(response => {
                                        response.data.forEach((opt2) => {
                                            let optHtml = document
                                                .createElement(
                                                    "option");
                                            optHtml.value = opt2.id;
                                            optHtml.text = opt2.name;
                                            if (opt2.id == cloneOpt.id2) {
                                                optHtml.selected = true;
                                            }
                                            el1.add(optHtml);
                                        })
                                    });
                                el1.closest("div").querySelector("label").textContent = att2
                                    .name;
                            } else {
                                el1.closest('div').remove();
                            }
                        }
                    });

                    let addOptPhoto = elClone.querySelector(".addOptPhoto");
                    bindPhotoOpt(addOptPhoto);

                    let upOptBtn = elClone.querySelector(".upOptBtn");
                    bindMoveUpOpt(upOptBtn);

                    let downOptBtn = elClone.querySelector(".downOptBtn");
                    bindMoveDownOpt(downOptBtn);

                    let removeOptBtn = elClone.querySelector(".removeOptBtn");
                    bindRemoveOpt(removeOptBtn);

                    section._x_dataStack[0].childCount++;
                    optBoxNew.before(elClone);
                })
                productOpt1.clear();
                productOpt2.clear();
            })

            FilePond.setOptions({
                allowReorder: true,
                allowMultiple: true,
                instantUpload: false,
                storeAsFile: true,
                itemInsertLocation: "after",
                acceptedFileTypes: ['image/png', 'image/jpeg'],
                fileValidateTypeLabelExpectedTypesMap: {
                    'image/png': '.png',
                    'image/jpeg': '.jpg',
                },
                styleItemPanelAspectRatio: "0.5",
                maxFileSize: '5MB'
            });
            const pond = FilePond.create(document.querySelector('.filepond'));

            @if ($item->filename)
                pond.addFile("{{ asset('storage/' . $item->filename) }}")
            @endif
            @if ($item->images->count())
                @foreach ($item->images as $image)
                    pond.addFile("{{ asset('storage/' . $image->filename) }}")
                @endforeach
            @endif

            const setMainPond = (e) => {
                if (document.querySelector(".filepond--item.mainPond")) {
                    document.querySelector(".filepond--item.mainPond").classList.remove("mainPond");
                }
                let firstItem = e.detail.items[0];
                let elementLegends = document.querySelectorAll(".filepond--file-info-main")
                elementLegends.forEach((el1) => {
                    if (firstItem && el1.textContent == firstItem.filename) {
                        el1.closest(".filepond--item").classList.add("mainPond");
                    }
                })
            }

            document.addEventListener("FilePond:reorderfiles", (e) => {
                setMainPond(e);
            })

            document.addEventListener("FilePond:updatefiles", (e) => {
                setMainPond(e);
            })

        })
    </script>
</x-admin-layout>
