<x-public-layout>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <x-admin.list-section>
            <div class="addresses">
                <ul class="grid w-full gap-6 md:grid-cols-2">
                    @foreach ($addresses as $address)
                        <li>
                            <a href="{{ route('customer_address.edit', $address->id) }}"
                                class="inline-flex items-center justify-between w-full h-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">{{ $address->recipient }}</div>
                                    <div class="w-full">
                                        {{ $address->street . ', ' . $address->number . ($address->complement ? ", {$address->complement}" : '') }}
                                    </div>
                                    <div class="w-full">
                                        {{ $address->neighborhood . ', ' . $address->city . '/' . $address->state }}
                                    </div>
                                    <div class="w-full">
                                        {{ $address->cep }}
                                    </div>
                                    <div class="w-full text-sm font-semibold">
                                        {{ $address->type->texto() }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    @if ($addresses->count() < 2)
                        <a href="{{ route('customer_address.create') }}"
                            class="inline-flex items-center justify-between w-full h-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100">
                            <div class="block">
                                <div class="w-full text-lg font-semibold">Possui outro endereço de entrega?</div>
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
                        </a>
                    @endif
                </ul>
            </div>
        </x-admin.list-section>
    </div>
</x-public-layout>
