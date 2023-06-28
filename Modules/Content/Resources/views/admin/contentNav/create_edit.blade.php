<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Páginas de Conteúdo >
            <x-admin.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.contentNavs.index')">
            Listar Conteúdos
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.form :action="$item->id ? route('admin.contentNavs.update', $item->id) : route('admin.contentNavs.store')" :editing="(bool) $item->id">
            <x-admin.form-grid gridCols="">
                <x-admin.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-label inpName="title" title="Título">
                    <x-admin.form-input inpName="title" placeholder="Título da página de conteúdo" :inpValue="old('title') ?: $item->title"
                        required />
                </x-admin.form-label>
                <x-admin.form-select inpName="type" title="Tipo de Conteúdo" required>
                    @foreach ($contentNavTypes as $typeKey => $typeValue)
                        <x-admin.form-select-option :inpValue="$typeKey" :title="$typeValue"
                            :selected="(old('type') ?: $item->type?->value) == $typeKey" />
                    @endforeach
                </x-admin.form-select>
            </x-admin.form-grid>
        </x-admin.form>
    </x-admin.list-section>
</x-admin-layout>
