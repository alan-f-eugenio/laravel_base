<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Lista de Carrinhos Abandonados
        </x-admin.page-title>
    </x-slot>
    <x-admin.list-section>
        <x-admin.filter gridCols="sm:grid-cols-3">
            <x-admin.filter-select inpName="has_customer" title="Cliente">
                <x-admin.filter-select-option inpName="has_customer" inpValue="1"
                    title="Identificado" />
                <x-admin.filter-select-option inpName="has_customer" inpValue="2"
                    title="Não Identificado" />
            </x-admin.filter-select>
            <x-admin.filter-input inpName="name" title="Nome" placeholder="Nome do cliente" />
            <x-admin.filter-input type="date" inpName="date" title="Data"
                placeholder="Data do carrinho" />
        </x-admin.filter>
        <x-admin.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.table-th>
                    Data do Carrinho
                </x-admin.table-th>
                <x-admin.table-th>
                    Cliente
                </x-admin.table-th>
                <x-admin.table-th>
                    Cupom
                </x-admin.table-th>
                <x-admin.table-th>
                    Frete
                </x-admin.table-th>
                <x-admin.table-th>
                    Produtos
                </x-admin.table-th>
                <x-admin.table-th>
                    Ações
                </x-admin.table-th>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($collection as $item)
                    <tr class="bg-white border-b">
                        <x-admin.table-td :main="true">
                            {{ $item->updated_at->format('d/m/Y H:i:s') }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->customer_id ? $item->customer->fullname : 'Não identificado' }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            {{ $item->coupon_id ? $item->coupon->token : 'Nenhum' }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            CEP {{ $item->shipping_cep ?: '_____-___' }}<br />
                            R$ {{ $item->shipping_value ?: '__,__' }}
                        </x-admin.table-td>
                        <x-admin.table-td>
                            <div class="inline-grid grid-cols-4 gap-3 max-w-fit">
                                @foreach ($item->cartProducts as $cart_product)
                                    <a class="flex items-center justify-center w-12 h-12 text-center border rounded border-gray-150 bg-gray-50"
                                        target="_blank"
                                        href="{{ route('admin.products.edit', $cart_product->product_id) }}">
                                        <img class="max-h-full"
                                            src="{{ $cart_product->product->filename ? asset('storage/' . $cart_product->product->filename) : Vite::asset('resources/img/no-image.png') }}" />
                                    </a>
                                @endforeach
                            </div>
                        </x-admin.table-td>
                        <x-admin.table-actions-td>
                            <x-admin.table-action :href="route('admin.carts.destroy', $item->id)" title="Excluir" :destroy="true">
                                <i class="text-base ti ti-trash"></i>
                            </x-admin.table-action>
                        </x-admin.table-actions-td>
                    </tr>
                @empty
                    <x-admin.table-no-result />
                @endforelse
            </x-slot>
        </x-admin.table>
    </x-admin.list-section>
</x-admin-layout>
