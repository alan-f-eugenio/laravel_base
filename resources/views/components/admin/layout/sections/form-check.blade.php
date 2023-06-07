@props(['inpName', 'title'])
<div {{ $attributes->class(['flex items-start']) }} {!! $attributes !!}>
    <div class="flex items-center h-5">
        {{ $slot }}
    </div>
    <label for="{{ $inpName }}" class="ml-2 text-sm font-medium text-gray-900">
        {{ $title }}
    </label>
</div>
