<x-admin-layout>
    @push('stylesAndScript')
        <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/translations/pt-br.js"></script>
    @endpush
    <x-slot name="header">
        <x-admin.page-title>
            {{ $nav->title }} >
            <x-admin.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.contents.index', $nav->id)">
            Listar Conteúdos
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.form :action="$item->id ? route('admin.contents.update', $item->id) : route('admin.contents.store', $nav->id)" :editing="(bool) $item->id" :hasFile="true">
            @if ($item->filename)
                <x-admin.form-image :filename="$item->filename" />
            @endif
            <x-admin.form-grid gridCols="sm:grid-cols-3">
                <x-admin.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue" :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-label inpName="title" title="Título">
                    <x-admin.form-input inpName="title" placeholder="Título do conteúdo" :inpValue="old('title') ?: $item->title" required />
                </x-admin.form-label>
                <x-admin.form-label inpName="subtitle" title="Subtítulo">
                    <x-admin.form-input inpName="subtitle" placeholder="Subtítulo do conteúdo" :inpValue="old('subtitle') ?: $item->subtitle" />
                </x-admin.form-label>
                <x-admin.form-label inpName="author" title="Autor">
                    <x-admin.form-input inpName="author" placeholder="Autor do conteúdo" :inpValue="old('author') ?: $item->author" />
                </x-admin.form-label>
                <x-admin.form-label inpName="link" title="Link (conteúdo externo)">
                    <x-admin.form-input inpName="link" placeholder="Link do conteúdo" :inpValue="old('link') ?: $item->link" />
                </x-admin.form-label>
                <x-admin.form-label inpName="page_title" title="Título da Página (SEO)">
                    <x-admin.form-input inpName="page_title" placeholder="Page title" :inpValue="old('page_title') ?: $item->page_title" />
                </x-admin.form-label>
                <x-admin.form-label inpName="meta_keywords" title="Palavras Chave (SEO)">
                    <x-admin.form-input inpName="meta_keywords" placeholder="Meta keywords" :inpValue="old('meta_keywords') ?: $item->meta_keywords" />
                </x-admin.form-label>
                <x-admin.form-label inpName="meta_description" title="Descrição (SEO)">
                    <x-admin.form-input inpName="meta_description" placeholder="Meta description" :inpValue="old('meta_description') ?: $item->meta_description" />
                </x-admin.form-label>
                <x-admin.form-input-file inpName="filename" title="Imagem Principal" :update="(bool) $item->id && $item->filename" />
            </x-admin.form-grid>
            <x-admin.form-textarea inpName="text" title="Texto" placeholder="Texto do conteúdo" :inpValue="old('text') ?: $item->text" />
            <x-admin.form-textarea inpName="abstract" title="Resumo" placeholder="Resumo do conteúdo"
                :inpValue="old('abstract') ?: $item->abstract" />
            <script>
                document.querySelectorAll('textarea.textEditor').forEach((el1) => {
                    ClassicEditor
                        .create(el1, {
                            simpleUpload: {
                                uploadUrl: '{{ route('admin.content_images.store') }}',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'accept': 'application/json'
                                }
                            },
                            language: 'pt-br'
                        });
                })
            </script>
        </x-admin.form>
    </x-admin.list-section>
</x-admin-layout>
