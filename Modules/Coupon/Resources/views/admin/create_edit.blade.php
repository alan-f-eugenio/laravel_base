<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Cupons >
            <x-admin.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.coupons.index')">
            Listar Cupons
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.form :action="$item->id ? route('admin.coupons.update', $item->id) : route('admin.coupons.store')" :editing="(bool) $item->id">
            @if ($item->filename)
                <x-admin.form-image :filename="$item->filename" />
            @endif
            <x-admin.form-grid gridCols="sm:grid-cols-2">
                <x-admin.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-label inpName="token" title="Token">
                    <x-admin.form-input inpName="token" placeholder="Token do cupom" :inpValue="old('token') ?: $item->token"
                        required />
                </x-admin.form-label>
                <x-admin.form-label inpName="description" title="Descrição">
                    <x-admin.form-input inpName="description" placeholder="Descrição do cupom"
                        :inpValue="old('description') ?: $item->description" required />
                </x-admin.form-label>
                <x-admin.form-label inpName="first_buy" title="Regra de utilização">
                    <x-admin.form-check-toggle inpName="first_buy" title="Apenas primeira compra"
                        :checked="(old() && old('first_buy') == 'checked') || (!old() && $item->first_buy)" />
                </x-admin.form-label>
                <x-admin.form-select inpName="discount_type" title="Tipo de Desconto" required>
                    @foreach ($couponDiscountTypes as $typeKey => $typeValue)
                        <x-admin.form-select-option :inpValue="$typeKey" :title="$typeValue"
                            :selected="(old('discount_type') ?: $item->discount_type?->value) == $typeKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-label inpName="discount" title="Desconto (% ou R$)">
                    <x-admin.form-input inpName="discount" placeholder="Desconto (% ou R$)"
                        :inpValue="old('discount') ?: $item->discount" required />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-grid gridCols="sm:grid-cols-2" x-data="{!! '{hasDateStartLimit: ' . (!$hasDateStartLimit ? 'true' : 'false') . '}' !!}">
                <x-admin.form-label inpName="hasDateStartLimit" title="Período de validade">
                    <x-admin.form-check-toggle inpName="hasDateStartLimit"
                        x-on:change="hasDateStartLimit = !hasDateStartLimit" title="Não possui data de início"
                        :checked="!$hasDateStartLimit" />
                </x-admin.form-label>
                <x-admin.form-label inpName="date_start" title="Data de Início">
                    <x-admin.form-input inpName="date_start" type="datetime-local" ::disabled="hasDateStartLimit"
                        :disabled="!$hasDateStartLimit" placeholder="00/00/0000 00:00:00" :inpValue="old('date_start') ?: $item->date_start" required />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-grid gridCols="sm:grid-cols-2" x-data="{!! '{hasDateEndLimit: ' . (!$hasDateEndLimit ? 'true' : 'false') . '}' !!}">
                <x-admin.form-label inpName="hasDateEndLimit" title="Período de validade">
                    <x-admin.form-check-toggle inpName="hasDateEndLimit"
                        x-on:change="hasDateEndLimit = !hasDateEndLimit" title="Não possui data de expiração"
                        :checked="!$hasDateEndLimit" />
                </x-admin.form-label>
                <x-admin.form-label inpName="date_end" title="Data de Expiração">
                    <x-admin.form-input inpName="date_end" type="datetime-local" ::disabled="hasDateEndLimit"
                        :disabled="!$hasDateEndLimit" placeholder="00/00/0000 00:00:00" :inpValue="old('date_end') ?: $item->date_end" required />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-grid gridCols="sm:grid-cols-2" x-data="{!! '{hasQtdLimit: ' . (!$hasQtdLimit ? 'true' : 'false') . '}' !!}">
                <x-admin.form-label inpName="hasQtdLimit" title="Quantidade de utilizações do cupom">
                    <x-admin.form-check-toggle inpName="hasQtdLimit"
                        x-on:change="hasQtdLimit = !hasQtdLimit" title="Sem limite de uso" :checked="!$hasQtdLimit" />
                </x-admin.form-label>
                <x-admin.form-label inpName="qtd" title="Utilizações">
                    <x-admin.form-input inpName="qtd" type="number" ::disabled="hasQtdLimit"
                        :disabled="!$hasQtdLimit" placeholder="Qtd. Utlizações" :inpValue="old('qtd') !== '' && old('qtd') !== null ? old('qtd') : $item->qtd" required />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-grid gridCols="sm:grid-cols-2" x-data="{!! '{hasValueMinLimit: ' . (!$hasValueMinLimit ? 'true' : 'false') . '}' !!}">
                <x-admin.form-label inpName="hasValueMinLimit" title="Valor mínimo do pedido">
                    <x-admin.form-check-toggle inpName="hasValueMinLimit"
                        x-on:change="hasValueMinLimit = !hasValueMinLimit" title="Não possui valor mínimo"
                        :checked="!$hasValueMinLimit" />
                </x-admin.form-label>
                <x-admin.form-label inpName="value_min" title="Valor Mínimo">
                    <x-admin.form-input class="moneyMask" inpName="value_min" ::disabled="hasValueMinLimit"
                        :disabled="!$hasValueMinLimit" placeholder="R$ 0,00" :inpValue="old('value_min') ?: $item->value_min" required />
                </x-admin.form-label>
            </x-admin.form-grid>
            <x-admin.form-grid gridCols="sm:grid-cols-2" x-data="{!! '{hasValueMaxLimit: ' . (!$hasValueMaxLimit ? 'true' : 'false') . '}' !!}">
                <x-admin.form-label inpName="hasValueMaxLimit" title="Valor máximo do pedido">
                    <x-admin.form-check-toggle inpName="hasValueMaxLimit"
                        x-on:change="hasValueMaxLimit = !hasValueMaxLimit" title="Não possui valor máximo"
                        :checked="!$hasValueMaxLimit" />
                </x-admin.form-label>
                <x-admin.form-label inpName="value_max" title="Valor Máximo">
                    <x-admin.form-input class="moneyMask" inpName="value_max" ::disabled="hasValueMaxLimit"
                        :disabled="!$hasValueMaxLimit" placeholder="R$ 0,00" :inpValue="old('value_max') ?: $item->value_max" required />
                </x-admin.form-label>
            </x-admin.form-grid>
        </x-admin.form>
    </x-admin.list-section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let discountInp = document.querySelector("#discount");
            let discountTypeInp = document.querySelector("#discount_type");
            const checkDiscountType = () => {
                if (discountTypeInp.value == {{ $typePercentValue }}) {
                    if (!discountInp.inputmask) {
                        Inputmask(percentOptions).mask(discountInp);
                    } else {
                        discountInp.inputmask.option(percentOptions)
                    }
                } else {
                    if (!discountInp.inputmask) {
                        Inputmask(moneyOptions).mask(discountInp);
                    } else {
                        discountInp.inputmask.option(moneyOptions)
                    }
                }
            }
            checkDiscountType();
            discountTypeInp.addEventListener("change", () => {
                checkDiscountType();
            })
        })
    </script>
</x-admin-layout>
