@props(['inpName', 'checked', 'required' => false])
<input id="{{ $inpName }}" name="{{ $inpName }}" type="checkbox" @checked($checked) @required($required)
    {!! $attributes !!} class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 ">
