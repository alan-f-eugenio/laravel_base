<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Banners >
            <x-admin.layout.sections.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.banners.index')">
            Listar Banners
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form :action="$item->id ? route('admin.banners.update', $item->id) : route('admin.banners.store')" :editing="(bool) $item->id" :hasFile="true">
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
                    <x-admin.layout.sections.form-input inpName="title" placeholder="Título do banner" :inpValue="old('title') ?: $item->title"
                        required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="link" title="Link">
                    <x-admin.layout.sections.form-input inpName="link" placeholder="Link do banner" :inpValue="old('link') ?: $item->link" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-select inpName="local_id" title="Local" required>
                    @foreach ($bannerLocals as $local)
                        <x-admin.layout.sections.form-select-option :inpValue="$local->id" :title="$local->title"
                            :selected="(old('local_id') ?: $item->local?->id) == $local->id" />
                    @endforeach
                </x-admin.layout.sections.form-select>
                <x-admin.layout.sections.form-input-file inpName="filename" title="Imagem" :required="!(bool) $item->id"
                    :update="(bool) $item->id && $item->filename" />
            </x-admin.layout.sections.form-grid>
            @if ($item->id)
                <input type="hidden" name="ordem" value="{{ $item->ordem }}">
            @endif
        </x-admin.layout.sections.form>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
