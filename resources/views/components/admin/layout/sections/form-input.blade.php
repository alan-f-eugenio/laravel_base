@props(['inpName', 'id' => '', 'type' => 'text', 'placeholder' => '', 'inpValue' => '', 'required' => false, 'disabled' => false, 'readonly' => false])
<input
    {{ $attributes->class(['bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 disabled:bg-gray-300 read-only:bg-gray-300']) }}
    type="{{ $type }}" id="{{ $id ?: $inpName }}" name="{{ $inpName }}" placeholder="{{ $placeholder }}"
    value="{{ $inpValue }}" @required($required) @disabled($disabled) @readonly($readonly) {!! $attributes !!} />
