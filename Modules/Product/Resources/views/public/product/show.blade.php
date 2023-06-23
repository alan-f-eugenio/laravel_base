<x-public-layout>
    <div class="space-y-6">
        <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
            <div class="grid items-center gap-6 bg-white sm:grid-cols-2">
                <div>
                    <img class="mx-auto"
                        src="{{ $item->filename ? asset('storage/' . $item->filename) : Vite::asset('resources/img/no-image.png') }}">
                </div>
                <div>
                    <h2 class="font-bold">{{ $item->name }}</h2>
                    {!! $item->text !!}
                    @if ($item->has_child->nenhuma())
                        <form action="{{ route('cart_product.store', $item->id) }}" method="POST">
                            @csrf
                            <input type="number" name="qtd" min="1" value="1">
                            <button type="submit">Adicionar</button>
                        </form>
                    @else
                        @foreach ($item->childs as $child)
                            <h3>
                                {{ $child->attribute1->name }}: {{ $child->option1->name }}
                                {{ $child->product_att2_id ? ' - ' . $child->attribute2->name . ': ' . $child->option2->name : '' }}
                            </h3>
                            <form action="{{ route('cart_product.store', $child->id) }}" method="POST">
                                @csrf
                                <input type="number" name="qtd" min="1" value="1">
                                <button type="submit">Adicionar</button>
                            </form>
                        @endforeach
                    @endif
                    @if ($item->type->venda())
                        <input class="mt-6" id="cepInp" type="text" value="{{ $cart->shipping_cep }}">
                        <a id="calcFrete" href="javascript:;">Calcular frete</a>
                        <div id="tableFrete"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const cepInp = document.querySelector("#cepInp");
                                const calcFrete = document.querySelector("#calcFrete");
                                const tableFrete = document.querySelector("#tableFrete");
                                calcFrete.addEventListener('click', () => {
                                    axios.get(`{{ route('shipping_calc') }}?cep=${cepInp.value}&product_id={{ $item->id }}`)
                                        .then((response) => {
                                            tableFrete.innerHTML = response.data.html
                                        });
                                })
                            })
                        </script>
                    @endif
                </div>
            </div>
            @if ($relatedProducts->count())
                <h2>Produtos relacionados</h2>
                <div class="grid items-center gap-6 bg-white sm:grid-cols-6">
                    @foreach ($relatedProducts as $product)
                        <x-product::public.box-product :product="$product" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
