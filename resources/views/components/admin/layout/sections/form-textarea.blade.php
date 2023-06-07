@props(['inpName', 'title', 'placeholder' => '', 'inpValue' => '', 'required' => false, 'readonly' => false])
<div {!! $attributes !!}>
    <label for="{{ $inpName }}" class="block mb-2 text-sm font-medium text-gray-900 ">
        {{ $title }}
    </label>
    <textarea
        class="textEditor bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        name="{{ $inpName }}" id="{{ $inpName }}" rows="5" placeholder="{{ $placeholder }}" @required($required)
        @readonly($readonly)>{{ $inpValue }}</textarea>
    <x-admin.layout.sections.form-error :inpName="$inpName" />
</div>
