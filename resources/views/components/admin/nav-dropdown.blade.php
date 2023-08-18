@props(['active', 'trigger', 'content', 'subContent', 'subTitle', 'hasSub', 'sub'])

@php
    // $classes = $active ?? false ? '  ' : '  ';

    $classes = 'block w-full px-3  border-l-4 text-left text-sm font-medium focus:outline-none transition duration-75 ease-in-out ';
    if (!($active ?? false)) {
        $classes .= 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 ';
    } else {
        // if (isset($active)) {
        $classes .= 'text-indigo-700 bg-indigo-50 border-indigo-400 focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 ';
        // } else {
        // $classes .= 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300  ';
        // }
    }

    $dataOpen = !isset($sub) ? 'open' : 'openSide';
@endphp

<div x-data="{ {{ $dataOpen }}: {{ $active ?? false ? 'true' : 'false' }} }" @click.outside="$event.target.closest('aside') ? {{ $dataOpen }} = false : false;"
    @close.stop="{{ $dataOpen }} = false"
    :class="{{ $dataOpen }} ? 'bg-gray-50 border-gray-300' :
        '{{ $active ?? false ? 'border-indigo-400' : 'border-transparent' }}'"
    {{ $attributes->merge(['class' => $classes]) }}>
    <button class="flex items-center justify-between w-full py-2 text-left" type="button"
        @click.debounce.150ms="{{ $dataOpen }}= !{{ $dataOpen }}">
        {{ $trigger }} <i class="align-middle icon-[tabler--chevron-down]"></i>
    </button>


    <div x-show="{{ $dataOpen }}" x-transition:enter="transition ease-out"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="inline-block w-full mb-3 space-y-2 origin-top-left rounded-md {{ !isset($subContent) ? 'shadow-lg' : '' }}"
        {!! !($active ?? false) ? 'style="display: none;"' : '' !!} {!! !isset($sub) && !isset($hasSub) ? '@click="open = false"' : '' !!}>
        <div class="py-1 bg-white rounded-md ring-1 ring-black ring-opacity-5">
            @if (isset($content))
                {{ $content }}
            @elseif(isset($subContent))
                {{ $subContent }}
            @endif
        </div>
        @if (isset($content) && isset($subContent))
            @if (isset($subTitle))
                <h3>{{ $subTitle }}</h3>
            @endif
            <div class="py-1 bg-white rounded-md ring-1 ring-black ring-opacity-5">
                {{ $subContent }}
            </div>
        @endif
    </div>
</div>
