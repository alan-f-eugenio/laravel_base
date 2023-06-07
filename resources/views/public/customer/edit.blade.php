<x-public.layout.app>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <x-admin.layout.sections.list-section>
            <x-admin.layout.sections.form :action="route('customer.update')" :editing="(bool) $item->id" x-data="{!! '{personFisica: ' . ($personFisica ? 'true' : 'false') . '}' !!}">
                <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3">
                    <x-admin.layout.sections.form-subtitle>Dados de Identificação
                    </x-admin.layout.sections.form-subtitle>
                    <x-admin.layout.sections.form-select inpName="person" title="Tipo de Pessoa" required
                        x-on:change="personFisica = !personFisica">
                        @foreach (\App\Helpers\CustomerPersons::array() as $personKey => $personValue)
                            <x-admin.layout.sections.form-select-option :inpValue="$personKey" :title="$personValue"
                                :selected="(old('person') ?: $item->person?->value) == $personKey" />
                        @endforeach
                    </x-admin.layout.sections.form-select>
                    <x-admin.layout.sections.form-label inpName="fullname" title="Nome">
                        <x-admin.layout.sections.form-input inpName="fullname" placeholder="Nome do cliente"
                            :inpValue="old('fullname') ?: $item->fullname" required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="cpf" title="CPF" x-show="personFisica"
                        :x-cloak="!$personFisica">
                        <x-admin.layout.sections.form-input inpName="cpf" placeholder="000.000.000-00"
                            ::disabled="!personFisica" :inpValue="old('cpf') ?: $item->cpf" required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="rg" title="RG" x-show="personFisica"
                        :x-cloak="!$personFisica">
                        <x-admin.layout.sections.form-input inpName="rg" placeholder="Identidade" ::disabled="!personFisica"
                            :inpValue="old('rg') ?: $item->rg" required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="date_birth" title="Data de Nascimento"
                        :x-cloak="!$personFisica" x-show="personFisica">
                        <x-admin.layout.sections.form-input inpName="date_birth" type="date" placeholder="00/00/0000"
                            ::disabled="!personFisica" :inpValue="old('date_birth') ?: $item->date_birth" max="{{ Carbon\Carbon::now()->subYears(18) }}"
                            required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="cnpj" title="CNPJ" x-show="!personFisica"
                        :x-cloak="$personFisica">
                        <x-admin.layout.sections.form-input inpName="cnpj" placeholder="00.000.000/0000-00"
                            ::disabled="personFisica" :inpValue="old('cnpj') ?: $item->cnpj" required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="corporate_name" title="Razão Social" :x-cloak="$personFisica"
                        x-show="!personFisica">
                        <x-admin.layout.sections.form-input inpName="corporate_name" placeholder="Razão Social"
                            ::disabled="personFisica" :inpValue="old('corporate_name') ?: $item->corporate_name" required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="state_registration" title="Inscrição Estadual"
                        :x-cloak="$personFisica" x-show="!personFisica">
                        <x-admin.layout.sections.form-input inpName="state_registration"
                            placeholder="Inscrição Estadual" ::disabled="personFisica" :inpValue="old('state_registration') ?: $item->state_registration" required />
                    </x-admin.layout.sections.form-label>
                </x-admin.layout.sections.form-grid>
                <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3">
                    <x-admin.layout.sections.form-subtitle>Dados de Contato e Acesso
                    </x-admin.layout.sections.form-subtitle>
                    <x-admin.layout.sections.form-label inpName="phone" title="Telefone">
                        <x-admin.layout.sections.form-input inpName="phone" placeholder="(00) 00000-0000"
                            :inpValue="old('phone') ?: $item->phone" required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="email" title="E-mail">
                        <x-admin.layout.sections.form-input inpName="email" type="email"
                            placeholder="cliente@email.com.br" :inpValue="old('email') ?: $item->email" required />
                    </x-admin.layout.sections.form-label>
                </x-admin.layout.sections.form-grid>
            </x-admin.layout.sections.form>
        </x-admin.layout.sections.list-section>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Inputmask({
                mask: "999.999.999-99",
            }).mask(document.querySelectorAll("#cpf"))
            Inputmask({
                mask: "99.999.999/9999-99",
            }).mask(document.querySelectorAll("#cnpj"))
            Inputmask({
                mask: "(99) 99999-9999",
            }).mask(document.querySelectorAll("#phone"))
        })
    </script>
</x-public.layout.app>
