@props(['active'])

@php
    $classes = 'block w-full pl-3 pr-4 py-2 border-l-4 text-left text-sm font-medium focus:outline-none transition duration-150 ease-in-out whitespace-nowrap ';

    if ($active ?? false) {
        $classes .= 'border-indigo-400 text-indigo-700 bg-indigo-50 focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 ';
    } else {
        $classes .= 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 ';
    }
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
