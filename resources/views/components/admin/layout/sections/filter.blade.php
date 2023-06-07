@props(['gridCols'])
<div class="p-6 space-y-6 text-gray-900 bg-white shadow-sm sm:rounded-lg">
    <h2 class="text-lg font-semibold leading-tight text-gray-800">
        Filtros
    </h2>
    <form action="" method="get" class="space-y-6">
        <div class="grid gap-6 {{ $gridCols }}">
            {{ $slot }}
            <div class="flex items-end justify-between md:space-x-6 md:justify-start">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-auto px-5 py-2.5 text-center">
                    Filtrar
                </button>
                <a href="{{ url()->current() }}"
                    class="focus:ring-4 hover:bg-gray-100 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-auto px-5 py-2.5 text-center">
                    Limpar
                </a>
            </div>
        </div>
    </form>
</div>
