@props(['action', 'editing' => false, 'hasFile' => false])
<form action="{{ $action }}" method="post" class="p-6 space-y-5 bg-white shadow-sm sm:rounded-lg"
    {!! $hasFile ? 'enctype="multipart/form-data"' : '' !!} {!! $attributes !!}>
    {{ $slot }}
    <button type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
        {{ $editing ? 'Salvar' : 'Cadastrar' }}
    </button>
    @csrf
    @if ($editing)
        @method('PUT')
    @endif
</form>
