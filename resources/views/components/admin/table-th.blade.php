@props(['hidden' => false])

<th scope="col" {{ $attributes->class(["px-6 py-3"]) }} {{ $attributes }} {!! $hidden ? "style='padding-top: 0 !important;padding-bottom: 0 !important;line-height: 0;visibility: hidden;'" : "" !!}>
    {{ $slot }}
</th>
