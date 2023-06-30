@props(['product'])
<a href="{{ route('products.show', [$product->slug]) }}"
    class="flex flex-col items-center justify-between p-3 border rounded-lg shadow-sm gap-y-3">
    <div class="relative w-full h-full m-auto rounded-lg aspect-square bg-gray-50">
        <img class="absolute top-0 bottom-0 left-0 right-0 object-contain object-center w-full h-full border border-gray-300 rounded-lg"
            src="{{ $product->filename ? asset('storage/' . $product->filename) : Vite::asset('resources/img/no-image.png') }}">
    </div>
    <h3 class="font-medium">{{ $product->name }}</h3>
</a>
