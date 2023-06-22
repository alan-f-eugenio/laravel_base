<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Lista de Carrinhos Abandonados
        </x-admin.layout.sections.page-title>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.filter gridCols="sm:grid-cols-3">
            <x-admin.layout.sections.filter-select inpName="has_customer" title="Cliente">
                <x-admin.layout.sections.filter-select-option inpName="has_customer" inpValue="1"
                    title="Identificado" />
                <x-admin.layout.sections.filter-select-option inpName="has_customer" inpValue="2"
                    title="Não Identificado" />
            </x-admin.layout.sections.filter-select>
            <x-admin.layout.sections.filter-input inpName="name" title="Nome" placeholder="Nome do cliente" />
            <x-admin.layout.sections.filter-input type="date" inpName="date" title="Data"
                placeholder="Data do carrinho" />
        </x-admin.layout.sections.filter>
        <x-admin.layout.sections.table :collection="$collection">
            <x-slot name="ths">
                <x-admin.layout.sections.table-th>
                    Data do Carrinho
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Cliente
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Cupom
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Frete
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Produtos
                </x-admin.layout.sections.table-th>
                <x-admin.layout.sections.table-th>
                    Ações
                </x-admin.layout.sections.table-th>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($collection as $item)
                    <tr class="bg-white border-b">
                        <x-admin.layout.sections.table-td :main="true">
                            {{ $item->updated_at->format('d/m/Y H:i:s') }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            {{ $item->customer_id ? $item->customer->fullname : 'Não identificado' }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            {{ $item->coupon_id ? $item->coupon->token : 'Nenhum' }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
                            CEP {{ $item->shipping_cep ?: '_____-___' }}<br />
                            R$ {{ $item->shipping_value ?: '__,__' }}
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-td>
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
                        </x-admin.layout.sections.table-td>
                        <x-admin.layout.sections.table-actions-td>
                            <x-admin.layout.sections.table-action :href="route('admin.carts.destroy', $item->id)" title="Excluir" :destroy="true">
                                <i class="text-base ti ti-trash"></i>
                            </x-admin.layout.sections.table-action>
                        </x-admin.layout.sections.table-actions-td>
                    </tr>
                @empty
                    <x-admin.layout.sections.table-no-result />
                @endforelse
            </x-slot>
        </x-admin.layout.sections.table>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
