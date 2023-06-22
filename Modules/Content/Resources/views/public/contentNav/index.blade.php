<x-public-layout>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <h2 class="font-bold">{{ $nav->title }}</h2>
        <div class="grid items-center gap-6 bg-white sm:grid-cols-3">
            @forelse ($collection as $content)
                <div class="flex flex-col items-center justify-between p-3 border rounded-lg shadow-sm">
                    <a {!! $content->link ? 'target="_blank"' : '' !!}
                        href="{{ $content->link ?: route('content', [$nav->slug, $content->slug]) }}">
                        <img class="mx-auto" src="{{ $content->filename ? asset('storage/' . $content->filename) : Vite::asset('resources/img/no-image.png') }}">
                        <h3 class="font-medium">{{ $content->title }}</h3>
                    </a>
                </div>
            @empty
                <div class="col-span-full">
                    <p>Nenhum conteúdo encontrado.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-public-layout>
