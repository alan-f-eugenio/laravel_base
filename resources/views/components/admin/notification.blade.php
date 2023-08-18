@php
    $messageA = session('message');
    $bgClass = 'bg-green-300';
    $textColor = 'text-green-500';
    $icon = 'icon-[tabler--check]';

    if ($messageA['type'] == 'error') {
        $bgClass = 'bg-red-300';
        $textColor = 'text-red-500';
        $icon = 'icon-[tabler--x]';
    } elseif ($messageA['type'] == 'warning') {
        $bgClass = 'bg-red-300';
        $textColor = 'text-red-500';
        $icon = 'icon-[tabler--alert-triangle]';
    }
@endphp

<div id="toast-message" x-data="{ show: false }" x-show="show" x-init="$nextTick(() => { show = true }); setTimeout(() => {show = false}, 5000)" x-transition x-cloak
    class="fixed left-0 right-0 z-10 flex items-center w-11/12 sm:w-auto p-4 mx-auto text-gray-900 border rounded-lg shadow-md bottom-2 sm:bottom-4 sm:right-4 sm:left-auto
    {{ $bgClass }}"
    role="alert">
    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 {{ $textColor }} bg-white rounded-lg">
        <i class="align-middle {{ $icon }}"></i>
    </div>
    <div class="mx-3 text-sm font-normal">
        {{ session('message')['text'] }}
    </div>
    <button type="button"
        class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
        data-dismiss-target="#toast-message" aria-label="Close">
        <i class="text-xl leading-5 align-middle icon-[tabler--x]"></i>
    </button>
</div>
