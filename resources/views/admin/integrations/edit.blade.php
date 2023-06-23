<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Integrações >
            <x-admin.page-subtitle>
                Alterar
            </x-admin.page-subtitle>
        </x-admin.page-title>
    </x-slot>
    <x-admin.list-section>
        @if ($itens)


            <x-admin.form :action="route('admin.integrations.update')" :editing="true">
                <x-admin.form-grid gridCols="sm:grid-cols-2">
                    @foreach ($itens as $type => $integrations)
                        @foreach ($integrations as $integrationName => $integration)
                            <x-admin.form-subtitle>
                                {{ ucwords($type) . ' - ' . ucwords($integrationName) }}
                            </x-admin.form-subtitle>
                            <x-admin.form-select inpName="{{ 'integration[' . $integration['id'] . '][status]' }}"
                                title="Status" required>
                                @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                                    <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue" :selected="$integration['status']->value == $statusKey" />
                                @endforeach
                            </x-admin.form-select>
                            @if ($integration['editable'])
                                @foreach ($integration['defines'] as $name => $value)
                                    <x-admin.form-label
                                        inpName="{{ 'integration[' . $integration['id'] . '][defines][' . $name . ']' }}"
                                        title="{{ ucwords($name) }}">
                                        <x-admin.form-input
                                            inpName="{{ 'integration[' . $integration['id'] . '][defines][' . $name . ']' }}"
                                            placeholder="{{ ucwords($name) }}" :inpValue="$value" />
                                    </x-admin.form-label>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </x-admin.form-grid>
            </x-admin.form>
        @else
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Nenhuma integração encontrada.
                </div>
            </div>
        @endif
    </x-admin.list-section>
</x-admin-layout>
