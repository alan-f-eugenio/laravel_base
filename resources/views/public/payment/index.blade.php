<x-public-layout>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <x-admin.list-section>
            <form action="" class="space-y-6" method="POST">
                @csrf
                <div class="addressList">
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li class="relative">
                            <input type="radio" id="shippingAddress{{ $mainAddress->id }}" name="address"
                                value="{{ $mainAddress->id }}"
                                class="absolute bottom-0 w-0 h-0 -translate-x-1/2 opacity-0 peer left-1/2"
                                data-cep="{{ $mainAddress->cep }}" required checked>
                            <label for="shippingAddress{{ $mainAddress->id }}"
                                class="inline-flex items-center justify-between w-full h-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">{{ $customer->fullname }}</div>
                                    <div class="w-full">
                                        {{ $mainAddress->street . ', ' . $mainAddress->number . ($mainAddress->complement ? ", {$mainAddress->complement}" : '') }}
                                    </div>
                                    <div class="w-full">
                                        {{ $mainAddress->neighborhood . ', ' . $mainAddress->city . '/' . $mainAddress->state }}
                                    </div>
                                    <div class="w-full">
                                        {{ $mainAddress->cep }}
                                    </div>
                                </div>
                            </label>
                        </li>
                        <li class="relative">
                            @if ($secondaryAddress)
                                <input type="radio" id="shippingAddress{{ $secondaryAddress->id }}" name="address"
                                    value="{{ $secondaryAddress->id }}"
                                    class="absolute bottom-0 w-0 h-0 -translate-x-1/2 opacity-0 peer left-1/2"
                                    data-cep="{{ $secondaryAddress->cep }}" required>
                                <label for="shippingAddress{{ $secondaryAddress->id }}"
                                    class="inline-flex items-center justify-between w-full h-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">{{ $customer->fullname }}</div>
                                        <div class="w-full">
                                            {{ $secondaryAddress->street . ', ' . $secondaryAddress->number . ($secondaryAddress->complement ? ", {$secondaryAddress->complement}" : '') }}
                                        </div>
                                        <div class="w-full">
                                            {{ $secondaryAddress->neighborhood . ', ' . $secondaryAddress->city . '/' . $secondaryAddress->state }}
                                        </div>
                                        <div class="w-full">
                                            {{ $secondaryAddress->cep }}
                                        </div>
                                    </div>
                                </label>
                            @else
                                <label
                                    class="inline-flex items-center justify-between w-full h-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">Possui outro endereço de entrega?
                                        </div>
                                        <div class="w-full">
                                            Cadastre aqui
                                        </div>
                                    </div>
                                    <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </label>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="shippingList">
                    <div class="relative flex shippingLoad">
                        <svg class="w-5 h-5 mr-3 -ml-1 text-zinc-500 animate-spin" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p>Carregando...</p>
                        <input id="placeShip" type='radio' name='shipping' class='absolute bottom-0 w-0 h-0 opacity-0'
                            required />
                    </div>
                    <div
                        class="shippingInputs [&_ul]:grid [&_ul]:w-full [&_ul]:gap-3 [&_ul]:grid-flow-col-dense [&_li]:relative [&_input]:opacity-0 [&_input]:h-0 [&_input]:w-0 [&_input]:absolute [&_input]:bottom-0 [&_input]:-translate-x-1/2 [&_input]:left-1/2 [&_label]:inline-flex [&_label]:flex-col [&_label]:w-full [&_label]:p-2 [&_label]:text-gray-500 [&_label]:bg-white [&_label]:border [&_label]:border-gray-200 [&_label]:rounded-lg [&_label]:cursor-pointer hover:[&_label]:bg-gray-100 hover:[&_label]:text-gray-600 [&_label]:btn-primary">
                    </div>
                </div>
                <div class="paymentList">
                    @foreach ($paymentMethodList as $keyPM => $logoPM)
                        <div class="relative inline-block">
                            <input type="radio" id="payment_{{ $keyPM }}" name="payment"
                                value="{{ $keyPM }}"
                                class="absolute bottom-0 w-0 h-0 -translate-x-1/2 opacity-0 peer left-1/2" required>
                            <label for="payment_{{ $keyPM }}"
                                class="inline-flex items-center justify-between p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                <div
                                    class="flex items-center justify-center w-24 h-24 text-center border rounded border-gray-150 bg-gray-50">
                                    <img class="max-h-full" src="{{ $logoPM }}" />
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="productList">
                    @foreach ($cartProducts as $cartProduct)
                        <div class="grid items-center grid-cols-12 gap-3">
                            <div class="col-span-7">
                                <div class="flex items-center gap-3">
                                    <div class="flex justify-center flex-shrink-0 align-center">
                                        <div
                                            class="flex items-center justify-center w-24 h-24 text-center border rounded border-gray-150 bg-gray-50">
                                            <img class="max-h-full"
                                                src="{{ $cartProduct->product->filename ? asset('storage/' . $cartProduct->product->filename) : Vite::asset('resources/img/no-image.png') }}" />
                                        </div>
                                    </div>
                                    <div class="flex-shrink">
                                        <p>{{ $cartProduct->product->id_parent ? $cartProduct->product->parent->name : $cartProduct->product->name }}
                                            {!! $cartProduct->product->id_parent
                                                ? "<br/><small>{$cartProduct->product->attribute1->name}:{$cartProduct->product->option1->name}" .
                                                    ($cartProduct->product->product_att2_id
                                                        ? "<br/>{$cartProduct->product->attribute2->name}:{$cartProduct->product->option2->name}"
                                                        : '') .
                                                    '</small>'
                                                : '' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <p>{{ $cartProduct->qtd }}</p>
                            </div>
                            <div class="col-span-2">
                                <p>{{ $cartProduct->product->price }}</p>
                            </div>
                            <div class="col-span-2">
                                <p>{{ number_format($cartProduct->product->getRawOriginal('price') * $cartProduct->qtd, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="focus:outline-none text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Finalizar compra</button>
            </form>
        </x-admin.list-section>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const shippingInputs = document.querySelector(".shippingInputs");
            const shippingLoad = document.querySelector(".shippingLoad");
            const shippingLoadInp = document.querySelector(".shippingLoad input");
            const getShipping = () => {
                let cep = document.querySelector("input[name=address]:checked").dataset.cep;
                shippingLoadInp.disabled = false;
                shippingLoad.style.display = "";
                shippingInputs.innerHTML = "";
                fetch(
                        `{{ route('shipping_calc') }}?cep=${cep}&inputs=true`
                    )
                    .then((response) => response.json())
                    .then((data) => {
                        shippingLoadInp.disabled = true;
                        shippingLoad.style.display = "none";
                        shippingInputs.innerHTML = data.html
                    });
            }
            getShipping();
            const addressInputList = document.querySelectorAll("input[name=address]");
            addressInputList.forEach((el1) => {
                el1.addEventListener("change", () => {
                    getShipping();
                })
            })
        })
    </script>
</x-public-layout>
