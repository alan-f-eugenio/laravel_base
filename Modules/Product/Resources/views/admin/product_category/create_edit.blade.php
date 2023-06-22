<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Categorias >
            <x-admin.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.product_categories.index')">
            Listar Categorias
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.form :action="$item->id
            ? route('admin.product_categories.update', $item->id)
            : route('admin.product_categories.store')" :editing="(bool) $item->id" :hasFile="true">
            @if ($item->filename)
                <x-admin.form-image :filename="$item->filename" />
            @endif
            <x-admin.form-grid gridCols="sm:grid-cols-2">
                <x-admin.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-select inpName="id_parent" title="Categoria Pai" required>
                    <x-admin.form-select-option inpValue="0" title="Principal" :selected="old() && !old('id_parent') ? true : (!$item->id_parent ? true : false)" />
                    @foreach ($categories as $category)
                        <x-admin.form-select-option :inpValue="$category->id" :title="$category->name"
                            :selected="(old('id_parent') ?: $item->id_parent) == $category->id" :disabled="in_array($category->id, $treeList)" />
                        @if ($category->allChilds())
                            <x-product::admin.product-category-recursive-option :categories="$category->allChilds" :idSelected="$item->id_parent"
                                inpName="id_parent" :treeList="$treeList" />
                        @endif
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-label inpName="name" title="Nome">
                    <x-admin.form-input inpName="name" placeholder="Nome da categoria"
                        :inpValue="old('name') ?: $item->name" required />
                </x-admin.form-label>
                <x-admin.form-label inpName="page_title" title="Título da Página (SEO)">
                    <x-admin.form-input inpName="page_title" placeholder="Page title"
                        :inpValue="old('page_title') ?: $item->page_title" />
                </x-admin.form-label>
                <x-admin.form-label inpName="meta_keywords" title="Palavras Chave (SEO)">
                    <x-admin.form-input inpName="meta_keywords" placeholder="Meta keywords"
                        :inpValue="old('meta_keywords') ?: $item->meta_keywords" />
                </x-admin.form-label>
                <x-admin.form-label inpName="meta_description" title="Descrição (SEO)">
                    <x-admin.form-input inpName="meta_description" placeholder="Meta description"
                        :inpValue="old('meta_description') ?: $item->meta_description" />
                </x-admin.form-label>
                <x-admin.form-textarea inpName="text" title="Descrição"
                    placeholder="Descrição da categoria" :inpValue="old('text') ?: $item->text" />
                <x-admin.form-input-file inpName="filename" title="Imagem" :update="(bool) $item->id && $item->filename" />
            </x-admin.form-grid>
        </x-admin.form>
    </x-admin.list-section>
</x-admin-layout>
