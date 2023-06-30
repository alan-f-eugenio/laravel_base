<x-public-layout>
    <div class="space-y-6">
        @if (!$cart->cartProducts->count())
            <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
                <p>Carrinho Vazio</p>
            </div>
        @else
            <div class="grid grid-cols-12 gap-x-20">
                <div class="grid items-center col-span-8 gap-6 p-6 bg-white border shadow-sm sm:rounded-lg">
                    @foreach ($cart->cartProducts as $cartProduct)
                        @php
                            $link = route('products.show', $cartProduct->product->id_parent ? [$cartProduct->product->parent->slug] : [$cartProduct->product->slug]);
                        @endphp
                        <div class="grid items-center grid-cols-12 gap-6">
                            <div class="col-span-5 ">
                                <div class="grid items-center grid-cols-12 gap-3">
                                    <div class="flex justify-center col-span-5 align-center">
                                        <a class="flex items-center justify-center w-24 h-24 text-center border rounded border-gray-150 bg-gray-50"
                                            href="{{ $link }}">
                                            <img class="max-h-full"
                                                src="{{ $cartProduct->product->filename ? asset('storage/' . $cartProduct->product->filename) : Vite::asset('resources/img/no-image.png') }}" />
                                        </a>
                                    </div>
                                    <div class="col-span-7">
                                        <a class="" href="{{ $link }}">
                                            <p>{{ $cartProduct->product->id_parent ? $cartProduct->product->parent->name : $cartProduct->product->name }}
                                                {!! $cartProduct->product->id_parent
                                                    ? "<br/><small>{$cartProduct->product->attribute1->name}:{$cartProduct->product->option1->name}" .
                                                        ($cartProduct->product->product_att2_id
                                                            ? "<br/>{$cartProduct->product->attribute2->name}:{$cartProduct->product->option2->name}"
                                                            : '') .
                                                        '</small>'
                                                    : '' !!}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <form action="{{ route('cart_product.update', $cartProduct->id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <input class="w-full" type="number" min="1" name="qtd"
                                        value="{{ $cartProduct->qtd }}" onchange="this.form.submit()" />
                                </form>
                            </div>
                            <div class="col-span-2">
                                <p>{{ $cartProduct->product->type->orcamento() ? 'À Orçar' : $cartProduct->product->price }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p>{{ $cartProduct->product->type->orcamento() ? 'À Orçar' : number_format($cartProduct->product->getRawOriginal('price') * $cartProduct->qtd, 2, ',', '.') }}
                                </p>
                            </div>

                            <div class="col-span-1">
                                <form action="{{ route('cart_product.destroy', $cartProduct->id) }}" method="post"
                                    onsubmit="return confirm('Confirmar ação?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Remover produto"
                                        class="px-3 py-2 text-xs text-gray-900 bg-white hover:bg-gray-100 hover:text-blue-700">
                                        <i class="text-base ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-span-4 p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
                    <div>
                        <input id="couponInp" type="text" value="{{ $cart->coupon }}">
                        <a id="calcCoupon" href="javascript:;">Aplicar cupom</a>
                        <div id="resultCoupon"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const couponInp = document.querySelector("#couponInp");
                                const calcCoupon = document.querySelector("#calcCoupon");
                                const resultCoupon = document.querySelector("#resultCoupon");
                                calcCoupon.addEventListener('click', () => {
                                    axios.get(`{{ route('coupon_calc') }}?coupon=${couponInp.value}`)
                                        .then((response) => {
                                            if (response.data.message == "success") {
                                                resultCoupon.innerHTML = response.data.discount;
                                            } else {
                                                resultCoupon.innerHTML = response.data.message;
                                            }
                                        });
                                })
                            })
                        </script>
                    </div>
                    <div>
                        <input id="cepInp" type="text" value="{{ $cart->shipping_cep }}">
                        <a id="calcShipping" href="javascript:;">Calcular frete</a>
                        <div id="resultShipping"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const cepInp = document.querySelector("#cepInp");
                                const calcShipping = document.querySelector("#calcShipping");
                                const resultShipping = document.querySelector("#resultShipping");
                                calcShipping.addEventListener('click', () => {
                                    axios.get(`{{ route('shipping_calc') }}?cep=${cepInp.value}`)
                                        .then((response) => {
                                            resultShipping.innerHTML = response.data.html
                                        });
                                })
                            })
                        </script>
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('payment.index') }}">Ir para pagamento</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-public-layout>
