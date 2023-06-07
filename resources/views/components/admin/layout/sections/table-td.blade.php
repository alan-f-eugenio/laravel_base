@props(['main' => false, 'classes' => 'px-6 py-4'])
@if ($main)
    <th scope="row" {{ $attributes->class(['px-6 py-4 font-medium text-gray-900 whitespace-nowrap']) }}>
        {{ $slot }}
    </th>
@else
    <td {{ $attributes->class([$classes]) }} {!! $attributes !!}>
        {{ $slot }}
    </td>
@endif
