@props(['justifyEnd' => false])
<td {{ $attributes->class(['px-6 py-4']) }}>
    @if ($justifyEnd)
        <div class="flex justify-end">
    @endif
    <div class="inline-flex overflow-hidden border border-gray-200 divide-x rounded-md shadow-sm">
        {{ $slot }}
    </div>
    @if ($justifyEnd)
        </div>
    @endif
</td>
