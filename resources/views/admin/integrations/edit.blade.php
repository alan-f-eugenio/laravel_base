<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Integrações >
            <x-admin.layout.sections.page-subtitle>
                Alterar
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form :action="route('admin.integrations.update')" :editing="true">
            <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-2">
                @foreach ($itens as $type => $integrations)
                    @foreach ($integrations as $integrationName => $integration)
                        <x-admin.layout.sections.form-subtitle>
                            {{ ucwords($type) . ' - ' . ucwords($integrationName) }}
                        </x-admin.layout.sections.form-subtitle>
                        <x-admin.layout.sections.form-select
                            inpName="{{ 'integration[' . $integration['id'] . '][status]' }}" title="Status" required>
                            @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                                <x-admin.layout.sections.form-select-option :inpValue="$statusKey" :title="$statusValue"
                                    :selected="$integration['status']->value == $statusKey" />
                            @endforeach
                        </x-admin.layout.sections.form-select>
                        @if ($integration['editable'])
                            @foreach ($integration['defines'] as $name => $value)
                                <x-admin.layout.sections.form-label
                                    inpName="{{ 'integration[' . $integration['id'] . '][defines][' . $name . ']' }}"
                                    title="{{ ucwords($name) }}">
                                    <x-admin.layout.sections.form-input
                                        inpName="{{ 'integration[' . $integration['id'] . '][defines][' . $name . ']' }}"
                                        placeholder="{{ ucwords($name) }}" :inpValue="$value" />
                                </x-admin.layout.sections.form-label>
                            @endforeach
                        @endif
                    @endforeach
                @endforeach
            </x-admin.layout.sections.form-grid>
        </x-admin.layout.sections.form>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
