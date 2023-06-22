@props(['condition', 'trueTitle', 'falseTitle'])
<span
    class="{{ $condition ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }} text-xs font-medium px-2.5 py-0.5 rounded whitespace-nowrap">
    {{ $condition ? $trueTitle : $falseTitle }}
</span>
