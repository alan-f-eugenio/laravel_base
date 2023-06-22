<x-public-layout>
    <div class="space-y-6">
        @if ($banner)
            <img class="w-full" src="{{ asset('storage/' . $banner->filename) }}">
        @endif

        @if ($contentSingle)
            <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
                <a {!! $contentSingle->link ? 'target="_blank"' : '' !!}
                    href="{{ $contentSingle->link ?: route('content_nav', $contentSingle->nav->slug) }}"
                    class="grid items-center gap-6 bg-white sm:grid-cols-2">
                    <div>
                        <img class="mx-auto" src="{{ asset('storage/' . $contentSingle->filename) }}">
                    </div>
                    <div>
                        <h2 class="font-bold">{{ $contentSingle->title }}</h2>
                        {!! $contentSingle->abstract !!}

                        Ver mais
                    </div>
                </a>
            </div>
        @endif

        @if ($contentMultiple)
            <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
                <h2 class="font-bold">
                    <a href="{{ route('content_nav', $contentMultiple['nav']->slug) }}">
                        {{ $contentMultiple['nav']->title }}
                    </a>
                </h2>
                <div class="grid items-center gap-6 bg-white sm:grid-cols-3">
                    @foreach ($contentMultiple['items'] as $content)
                        <div class="flex flex-col items-center justify-between p-3 border rounded-lg shadow-sm">
                            <a {!! $content->link ? 'target="_blank"' : '' !!}
                                href="{{ $content->link ?: route('content', [$contentMultiple['nav']->slug, $content->slug]) }}">
                                <img class="mx-auto" src="{{ asset('storage/' . $content->filename) }}">
                                <h3 class="font-medium">{{ $content->title }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
            @foreach ($categories as $category)
                <h2 class="font-bold">
                    <a href="{{ route('products.index', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </h2>
                <div class="grid items-center gap-6 bg-white sm:grid-cols-6">
                    @forelse ($category->getAllProducts() as $product)
                        <x-product::public.box-product :product="$product" />
                    @empty
                        <p>Nenhum produto cadastrado</p>
                    @endforelse
                </div>
            @endforeach
        </div>


        <form action="{{ route('contacts.store') }}" method="post"
            class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
            <h2>Formulario de Contato</h2>
            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">
                        Nome
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        type="text" id="name" name="name" placeholder="Nome" required
                        value="{{ old('name') }}" />
                    @error('name')
                        <label class="text-red-500">
                            {{ $message }}
                        </label>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">
                        E-mail
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        type="email" id="email" name="email" placeholder="E-mail" required
                        value="{{ old('email') }}" />
                    @error('email')
                        <label class="text-red-500">
                            {{ $message }}
                        </label>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 ">
                        Telefone
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        type="text" id="phone" name="phone" placeholder="(00) 00000-0000" required
                        value="{{ old('phone') }}" />
                    @error('phone')
                        <label class="text-red-500">
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div>
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 ">
                    Mensagem
                </label>
                <textarea
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="message" id="message" rows="5" placeholder="Mensagem" required>{{ old('message') }}</textarea>
                @error('message')
                    <label class="text-red-500">
                        {{ $message }}
                    </label>
                @enderror
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Enviar
            </button>
            @csrf
        </form>

        <form action="{{ route('emails.store') }}" method="post"
            class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
            <h2>Formulario de Newsletter</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">
                        Nome
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        type="text" id="name" name="name" placeholder="Nome" required
                        value="{{ old('name') }}" />
                    @error('name')
                        <label class="text-red-500">
                            {{ $message }}
                        </label>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">
                        E-mail
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        type="email" id="email" name="email" placeholder="E-mail" required
                        value="{{ old('email') }}" />
                    @error('email')
                        <label class="text-red-500">
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Enviar
            </button>
            @csrf
        </form>

        @if (config('defines'))
            <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
                <p>{{ config('defines')->company_name }}</p>
                <p>{{ config('defines')->company_cnpj }}</p>
                <p>{{ config('defines')->company_email }}</p>
                <p>{{ config('defines')->company_phone }}</p>
                <p>{{ config('defines')->company_whats }}</p>

            </div>
        @endif
    </div>
</x-public-layout>
