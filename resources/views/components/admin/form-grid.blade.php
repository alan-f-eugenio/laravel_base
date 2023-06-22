@props(['gridCols'])
<div {{ $attributes->merge(['class' => 'grid gap-x-6 gap-y-5 ' . $gridCols]) }} {!! $attributes !!}>
    {{ $slot }}
</div>
