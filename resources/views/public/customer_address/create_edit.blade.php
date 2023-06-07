<x-public.layout.app>
    @push('scripts')
        <script src="{{ Vite::asset('resources/js/cep-promise-browser.min.js') }}"></script>
    @endpush
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <x-admin.layout.sections.list-section>
            <x-admin.layout.sections.form :action="$item->id ? route('customer_address.update', $item->id) : route('customer_address.store')" :editing="(bool) $item->id">
                <x-admin.layout.sections.form-subtitle>Dados do
                    {{ $item->type ? $item->type->texto() : 'Endereço de Entrega' }}
                </x-admin.layout.sections.form-subtitle>
                <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-2">
                    <x-admin.layout.sections.form-label inpName="recipient" title="Destinatário">
                        <x-admin.layout.sections.form-input inpName="recipient" placeholder="Nome do destinatário"
                            :inpValue="old('recipient') ?: $item->recipient" required />
                    </x-admin.layout.sections.form-label>
                </x-admin.layout.sections.form-grid>
                <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3">
                    <x-admin.layout.sections.form-label inpName="cep" title="CEP">
                        <x-admin.layout.sections.form-input inpName="cep" placeholder="00000-000" :inpValue="old('cep') ?: $item->cep"
                            required />
                    </x-admin.layout.sections.form-label>
                </x-admin.layout.sections.form-grid>
                <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3">
                    <x-admin.layout.sections.form-label inpName="street" title="Endereço">
                        <x-admin.layout.sections.form-input inpName="street" placeholder="Endereço" :inpValue="old('street') ?: $item->street"
                            required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="number" title="Número">
                        <x-admin.layout.sections.form-input inpName="number" placeholder="Número" :inpValue="old('number') ?: $item->number"
                            required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="complement" title="Complemento">
                        <x-admin.layout.sections.form-input inpName="complement" placeholder="Complemento"
                            :inpValue="old('complement') ?: $item->complement" />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="neighborhood" title="Bairro">
                        <x-admin.layout.sections.form-input inpName="neighborhood" placeholder="Bairro"
                            :inpValue="old('neighborhood') ?: $item->neighborhood" required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="city" title="Cidade">
                        <x-admin.layout.sections.form-input inpName="city" placeholder="Cidade" :inpValue="old('city') ?: $item->city"
                            required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="state" title="Estado">
                        <x-admin.layout.sections.form-input inpName="state" placeholder="Estado" :inpValue="old('state') ?: $item->state"
                            maxlength="2" required />
                    </x-admin.layout.sections.form-label>
                </x-admin.layout.sections.form-grid>
            </x-admin.layout.sections.form>
        </x-admin.layout.sections.list-section>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Inputmask({
                mask: "99999-999",
            }).mask(document.querySelectorAll("#cep"))

            const cepInp = document.querySelector("#cep");
            let oldCepValue = '{{ $item->cep }}';
            cepInp.addEventListener('keyup', () => {
                fetchAddressByCep(cepInp,
                    document.querySelector('#street'),
                    document.querySelector('#neighborhood'),
                    document.querySelector('#city'),
                    document.querySelector('#state'),
                    oldCepValue
                )
            })
        })
    </script>
</x-public.layout.app>
