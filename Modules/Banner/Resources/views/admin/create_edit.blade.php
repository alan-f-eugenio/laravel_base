<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Banners >
            <x-admin.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.banners.index')">
            Listar Banners
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.form :action="$item->id ? route('admin.banners.update', $item->id) : route('admin.banners.store')" :editing="(bool) $item->id" :hasFile="true">
            @if ($item->filename)
                <x-admin.form-image :filename="$item->filename" />
            @endif
            <x-admin.form-grid gridCols="sm:grid-cols-3">
                <x-admin.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-label inpName="title" title="Título">
                    <x-admin.form-input inpName="title" placeholder="Título do banner" :inpValue="old('title') ?: $item->title"
                        required />
                </x-admin.form-label>
                <x-admin.form-label inpName="link" title="Link">
                    <x-admin.form-input inpName="link" placeholder="Link do banner" :inpValue="old('link') ?: $item->link" />
                </x-admin.form-label>
                <x-admin.form-select inpName="local_id" title="Local" required>
                    @foreach ($bannerLocals as $local)
                        <x-admin.form-select-option :inpValue="$local->id" :title="$local->title"
                            :selected="(old('local_id') ?: $item->local?->id) == $local->id" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-input-file inpName="filename" title="Imagem" :required="!(bool) $item->id"
                    :update="(bool) $item->id && $item->filename" />
            </x-admin.form-grid>
            @if ($item->id)
                <input type="hidden" name="ordem" value="{{ $item->ordem }}">
            @endif
        </x-admin.form>
    </x-admin.list-section>
</x-admin-layout>
