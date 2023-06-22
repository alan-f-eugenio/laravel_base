@props(['inpName', 'id' => '', 'title', 'required' => false, 'placehName' => '', 'placehDisabled' => false, 'disabled' => false, 'xCloak' => '', 'xShow' => ''])
<div {{ $xCloak ? 'x-cloak' : '' }} {!! $xShow ? "x-show='" . $xShow . "'" : '' !!}>
    <label for="{{ $inpName }}" class="block mb-2 text-sm font-medium text-gray-900 ">
        {{ $title }}
    </label>
    <select id="{{ $id ?: $inpName }}" name="{{ $inpName }}" @required($required) @disabled($disabled)
        {{ $attributes->class(['bg-gray-50  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full disabled:bg-gray-300', !$attributes->has('multiple') ? 'border p-2.5' : '[&>.ts-control]:bg-gray-50 [&>.ts-control]:rounded-lg [&>.ts-control]:border [&>.ts-control]:text-sm [&>.ts-control]:leading-6 placeholder:[&>.ts-control>input]:text-sm [&>.ts-control>.item]:!bg-gray-200 [&>.ts-control>.item]:rounded']) }}
        {!! $attributes !!}>
        @if ($placehName)
            <option {{ $placehDisabled ? 'selected disabled' : '' }} value="">{{ $placehName }}</option>
        @endif
        {{ $slot }}
    </select>
    <x-admin.form-error :inpName="$inpName" />
</div>
