@props(['href', 'hasPhoto' => false, 'title', 'destroy' => false])
@if (!$destroy)
    <a href="{{ $href }}" title="{{ $title }}"
        {{ $attributes->class(['text-xs text-gray-900 bg-white hover:bg-gray-100 hover:text-blue-700', 'px-3 py-2' => !$hasPhoto ]) }}
        {!! $attributes !!}>
        {{ $slot }}
    </a>
@else
    <form action="{{ $href }}" method="post" onsubmit="return confirm('Confirmar ação?');">
        @csrf
        @method('DELETE')
        <button type="submit" title="{{ $title }}"
            class="px-3 py-2 text-xs text-gray-900 bg-white hover:bg-gray-100 hover:text-blue-700">
            {{ $slot }}
        </button>
    </form>
@endif
