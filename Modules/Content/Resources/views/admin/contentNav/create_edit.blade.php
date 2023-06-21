<x-admin.layout.app>
    @push('stylesAndScript')
        <script src="{{ Vite::asset('resources/js/froala_editor.pkgd.min.js') }}"></script>
        <script src="{{ Vite::asset('resources/js/froala_pt_br.min.js') }}"></script>
        <link href="{{ Vite::asset('resources/css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Páginas de Conteúdo >
            <x-admin.layout.sections.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.contentNavs.index')">
            Listar Conteúdos
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form :action="$item->id ? route('admin.contentNavs.update', $item->id) : route('admin.contentNavs.store')" :editing="(bool) $item->id">
            <x-admin.layout.sections.form-grid gridCols="">
                <x-admin.layout.sections.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.layout.sections.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.layout.sections.form-select>
                <x-admin.layout.sections.form-label inpName="title" title="Título">
                    <x-admin.layout.sections.form-input inpName="title" placeholder="Título da página de conteúdo" :inpValue="old('title') ?: $item->title"
                        required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-select inpName="type" title="Tipo de Conteúdo" required>
                    @foreach (\App\Helpers\ContentNavTypes::array() as $typeKey => $typeValue)
                        <x-admin.layout.sections.form-select-option :inpValue="$typeKey" :title="$typeValue"
                            :selected="(old('type') ?: $item->type?->value) == $typeKey" />
                    @endforeach
                </x-admin.layout.sections.form-select>
            </x-admin.layout.sections.form-grid>
        </x-admin.layout.sections.form>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
