@props(['filename'])
<div class="p-3 mb-6 border border-gray-300 rounded-lg bg-gray-50 sm:h-96">
    <div class="h-full mx-auto">
        <img class="object-contain object-center w-full h-full" src="{{ asset('storage/' . $filename) }}">
    </div>
</div>
