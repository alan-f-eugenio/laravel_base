@props(['inpName', 'inpError' => null, 'title', 'xCloak' => false])
<div {{ $xCloak ? 'x-cloak' : '' }} {!! $attributes !!}>
    <label for="{{ $inpName }}" class="block mb-2 text-sm font-medium text-gray-900 ">
        {{ $title }}
    </label>
    {{ $slot }}
    <x-admin.form-error :inpName="$inpError ?: $inpName" />
</div>
