<x-public-layout>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <x-admin.list-section>
            <x-admin.form :action="route('customer.store')" x-data="{!! '{personFisica: ' . ($personFisica ? 'true' : 'false') . '}' !!}">
                <x-admin.form-grid gridCols="sm:grid-cols-3">
                    <x-admin.form-subtitle>Dados de Identificação
                    </x-admin.form-subtitle>
                    <x-admin.form-select inpName="status" title="Status" required>
                        @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                            <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue"
                                :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                        @endforeach
                    </x-admin.form-select>
                    <x-admin.form-select inpName="person" title="Tipo de Pessoa" required
                        x-on:change="personFisica = !personFisica">
                        @foreach ($customerPersons as $personKey => $personValue)
                            <x-admin.form-select-option :inpValue="$personKey" :title="$personValue"
                                :selected="(old('person') ?: $item->person?->value) == $personKey" />
                        @endforeach
                    </x-admin.form-select>
                    <x-admin.form-label inpName="fullname" title="Nome Completo">
                        <x-admin.form-input inpName="fullname" placeholder="Nome do cliente"
                            :inpValue="old('fullname') ?: $item->fullname" required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="cpf" title="CPF">
                        <x-admin.form-input inpName="cpf" placeholder="000.000.000-00"
                            :inpValue="old('cpf') ?: $item->cpf" required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="date_birth" title="Data de Nascimento">
                        <x-admin.form-input inpName="date_birth" type="date" placeholder="00/00/0000"
                            :inpValue="old('date_birth') ?: $item->date_birth" max="{{ Carbon\Carbon::now()->subYears(18) }}" required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="rg" title="RG">
                        <x-admin.form-input inpName="rg" placeholder="Identidade"
                            :inpValue="old('rg') ?: $item->rg" />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="cnpj" title="CNPJ" x-show="!personFisica"
                        :x-cloak="$personFisica">
                        <x-admin.form-input inpName="cnpj" placeholder="00.000.000/0000-00"
                            ::disabled="personFisica" :inpValue="old('cnpj') ?: $item->cnpj" required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="corporate_name" title="Razão Social" :x-cloak="$personFisica"
                        x-show="!personFisica">
                        <x-admin.form-input inpName="corporate_name" placeholder="Razão Social"
                            ::disabled="personFisica" :inpValue="old('corporate_name') ?: $item->corporate_name" required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="state_registration" title="Inscrição Estadual"
                        :x-cloak="$personFisica" x-show="!personFisica">
                        <x-admin.form-input inpName="state_registration"
                            placeholder="Inscrição Estadual" ::disabled="personFisica" :inpValue="old('state_registration') ?: $item->state_registration" required />
                    </x-admin.form-label>
                    <x-admin.form-subtitle>Dados de Endereço de Cobrança
                    </x-admin.form-subtitle>
                    <x-admin.form-label inpName="cep" title="CEP">
                        <x-admin.form-input inpName="cep" placeholder="00000-000" :inpValue="old('cep') ?: $address->cep"
                            required />
                    </x-admin.form-label>
                </x-admin.form-grid>
                <x-admin.form-grid gridCols="sm:grid-cols-3">
                    <x-admin.form-label inpName="street" title="Endereço">
                        <x-admin.form-input inpName="street" placeholder="Endereço" :inpValue="old('street') ?: $address->street"
                            required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="number" title="Número">
                        <x-admin.form-input inpName="number" placeholder="Número" :inpValue="old('number') ?: $address->number"
                            required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="complement" title="Complemento">
                        <x-admin.form-input inpName="complement" placeholder="Complemento"
                            :inpValue="old('complement') ?: $address->complement" />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="neighborhood" title="Bairro">
                        <x-admin.form-input inpName="neighborhood" placeholder="Bairro"
                            :inpValue="old('neighborhood') ?: $address->neighborhood" required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="city" title="Cidade">
                        <x-admin.form-input inpName="city" placeholder="Cidade" :inpValue="old('city') ?: $address->city"
                            required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="state" title="Estado">
                        <x-admin.form-input inpName="state" placeholder="Estado" :inpValue="old('state') ?: $address->state"
                            maxlength="2" required />
                    </x-admin.form-label>
                    <x-admin.form-subtitle>Dados de Contato e Acesso
                    </x-admin.form-subtitle>
                    <x-admin.form-label inpName="phone" title="Telefone">
                        <x-admin.form-input inpName="phone" placeholder="(00) 00000-0000"
                            :inpValue="old('phone') ?: $item->phone" required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="email" title="E-mail">
                        <x-admin.form-input inpName="email" type="email"
                            placeholder="cliente@email.com.br" :inpValue="old('email') ?: $item->email" required />
                    </x-admin.form-label>
                    @if ($item->id)
                        <x-admin.form-label inpName="recoverPass" title="Recuperação de Senha">
                            <x-admin.form-check-toggle inpName="recoverPass"
                                title="Enviar recuperação de senha" :checked="old('recoverPass')" />
                        </x-admin.form-label>
                    @else
                        <x-admin.form-label inpName="password" title="Senha do Usuário">
                            <x-admin.form-input inpName="password" type="password"
                                placeholder="••••••••" required />
                        </x-admin.form-label>
                        <x-admin.form-label inpName="password_confirmation"
                            title="Confirme a Senha do Usuário">
                            <x-admin.form-input inpName="password_confirmation" type="password"
                                placeholder="••••••••" required />
                        </x-admin.form-label>
                    @endif
                </x-admin.form-grid>
            </x-admin.form>
        </x-admin.list-section>
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
                mask: "99999-999",
            }).mask(document.querySelectorAll("#cep"))
            Inputmask({
                mask: "(99) 99999-9999",
            }).mask(document.querySelectorAll("#phone"))

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
</x-public-layout>
