<x-admin.layout.app>
    @push('stylesAndScript')
        <script src="{{ Vite::asset('resources/js/froala_editor.pkgd.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/js/froala_pt_br.min.js') }}"></script>
        <link href="{{ Vite::asset('resources/css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            {{ $nav->title }} >
            <x-admin.layout.sections.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.contents.index', $nav->id)">
            Listar Conteúdos
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form :action="$item->id ? route('admin.contents.update', $item->id) : route('admin.contents.store', $nav->id)" :editing="(bool) $item->id" :hasFile="true">
            @if ($item->filename)
                <x-admin.layout.sections.form-image :filename="$item->filename" />
            @endif
            <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3">
                <x-admin.layout.sections.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.layout.sections.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.layout.sections.form-select>
                <x-admin.layout.sections.form-label inpName="title" title="Título">
                    <x-admin.layout.sections.form-input inpName="title" placeholder="Título do conteúdo" :inpValue="old('title') ?: $item->title"
                        required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="subtitle" title="Subtítulo">
                    <x-admin.layout.sections.form-input inpName="subtitle" placeholder="Subtítulo do conteúdo"
                        :inpValue="old('subtitle') ?: $item->subtitle" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="author" title="Autor">
                    <x-admin.layout.sections.form-input inpName="author" placeholder="Autor do conteúdo"
                        :inpValue="old('author') ?: $item->author" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="link" title="Link (conteúdo externo)">
                    <x-admin.layout.sections.form-input inpName="link" placeholder="Link do conteúdo"
                        :inpValue="old('link') ?: $item->link" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="page_title" title="Título da Página (SEO)">
                    <x-admin.layout.sections.form-input inpName="page_title" placeholder="Page title"
                        :inpValue="old('page_title') ?: $item->page_title" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="meta_keywords" title="Palavras Chave (SEO)">
                    <x-admin.layout.sections.form-input inpName="meta_keywords" placeholder="Meta keywords"
                        :inpValue="old('meta_keywords') ?: $item->meta_keywords" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="meta_description" title="Descrição (SEO)">
                    <x-admin.layout.sections.form-input inpName="meta_description" placeholder="Meta description"
                        :inpValue="old('meta_description') ?: $item->meta_description" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-input-file inpName="filename" title="Imagem Principal"
                    :update="(bool) $item->id && $item->filename" />
            </x-admin.layout.sections.form-grid>
            <x-admin.layout.sections.form-textarea inpName="text" title="Texto" placeholder="Texto do conteúdo"
                :inpValue="old('text') ?: $item->text" />
            <x-admin.layout.sections.form-textarea inpName="abstract" title="Resumo" placeholder="Resumo do conteúdo"
                :inpValue="old('abstract') ?: $item->abstract" />
            <script>
                var editor = new FroalaEditor('.textEditor', {
                    language: 'pt_br',
                    pluginsEnabled: ['link', 'url', 'table', 'save', 'align', 'colors', 'draggable',
                        'lists', 'paragraphFormat', 'charCounter',
                        'video',
                        'image', 'imageManager'
                    ],
                    toolbarButtons: {
                        'moreText': {
                            'buttons': ['bold', 'italic', 'underline', 'strikeThrough', ],
                            'buttonsVisible': 4
                        },
                        'moreParagraph': {
                            'buttons': ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'paragraphFormat',
                                'formatUL', 'formatOL',
                            ],
                            'buttonsVisible': 7
                        },
                        'moreRich': {
                            'buttons': ['insertLink', 'insertTable', 'insertImage', 'insertVideo', ],
                            'buttonsVisible': 4
                        },
                    },
                    imageUploadParams: {
                        _token: "{{ csrf_token() }}"
                    },
                    imageUploadURL: "{{ route('admin.content_images.store') }}",
                    imageMaxSize: 5 * 1024 * 1024,
                    imageManagerLoadURL: "{{ route('admin.content_images.index') }}",
                    imageManagerDeleteURL: "{{ route('admin.content_images.destroy') }}",
                    imageManagerDeleteMethod: "DELETE",
                    imageManagerDeleteParams: {
                        _token: "{{ csrf_token() }}"
                    },
                    videoUpload: false,
                    events: {
                        'image.error': function(error, response) {
                            console.log(error)
                            console.log(response)
                        },
                    }
                });
            </script>
        </x-admin.layout.sections.form>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
