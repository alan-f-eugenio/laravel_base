<x-public-layout>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <h2 class="font-bold">
            {{ $category?->name ?? 'Produtos' }}
        </h2>
        <div class="grid items-center gap-6 bg-white sm:grid-cols-6">
            @forelse ($products as $product)
                <x-product::public.box-product :product="$product" />
            @empty
                <p>Nenhum produto cadastrado</p>
            @endforelse
        </div>
    </div>
</x-public-layout>
