<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"> --}}

    <!-- Scripts And Styles -->
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('stylesAndScript')
</head>

<body x-data="{ openSideMenu: false }" :class="{ 'overflow-hidden': openSideMenu }" class="font-sans antialiased">
    <div class="flex flex-col min-h-screen bg-gray-100 xl:flex-row">
        <x-admin.navigation />
        <div class="flex-1 py-6 space-y-6">
            @if (isset($header))
                <header>
                    <div
                        class="container flex flex-col items-center justify-between px-6 mx-auto space-y-4 sm:space-y-0 sm:flex-row">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <main class="container px-6">
                {{-- @if (old())
                    @dump(session()->getOldInput())
                @endif --}}
                {{-- @if ($errors->any())
                    @foreach ($errors->getMessages() as $key => $message)
                        @dump($key . ': ' . json_encode($message))
                    @endforeach
                @endif --}}
                {{ $slot }}
            </main>
            @if (session('message'))
                <x-admin.notification />
            @endif
        </div>
    </div>
</body>

</html>
