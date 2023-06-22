<x-public-layout>
    <div class="space-y-6">
        <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
            @if ($item)
                <div class="grid items-center gap-6 bg-white sm:grid-cols-2">
                    @if ($item->filename)
                        <div>
                            <img class="mx-auto" src="{{ asset('storage/' . $item->filename) }}">
                        </div>
                    @endif
                    <div class="{{ $item->filename ?: 'col-span-full' }}">
                        <h2 class="font-bold">{{ $item->title }}</h2>
                        {!! $item->text !!}
                    </div>
                </div>
            @else
                <h2 class="font-bold">{{ $nav->title }}</h2>
                Nenhum conteúdo encontrado.
            @endif
        </div>
    </div>
</x-public-layout>
