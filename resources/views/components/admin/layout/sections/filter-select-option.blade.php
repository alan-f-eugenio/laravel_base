@props(['inpName', 'inpValue', 'title'])
<option @selected(request()->filled($inpName) && request()->$inpName == $inpValue) value="{{ $inpValue }}">
    {{ $title }}
</option>
