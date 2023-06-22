@props(['inpName', 'title', 'update' => false, 'required' => false])
<div>
    <label for="{{ $inpName }}" class="block mb-2 text-sm font-medium text-gray-900 ">
        {{ $update ? 'Alterar' : 'Cadastrar' }} {{ $title }}
    </label>
    <input type="file" id="{{ $inpName }}" name="{{ $inpName }}" @required($required)
        class="block w-full text-sm text-gray-900 file:!bg-blue-700 file:!mr-1  file:hover:!bg-blue-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
    <x-admin.form-error :inpName="$inpName" />
</div>
