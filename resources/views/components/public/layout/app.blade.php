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

    <!-- Scripts -->
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex flex-col min-h-screen bg-gray-100">
        <div class="flex items-center justify-end p-2 space-x-6 bg-white border-2 border-gray-900">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('products.index') }}">Produtos</a>
            <a href="{{ route('cart_product.index') }}">Carrinho</a>
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('customer.create') }}">Cadastrar</a>
            @else
                <a href="{{ route('customer.edit') }}">Minha Conta</a>
                <a href="{{ route('customer_address.index') }}">Meus Endereços</a>
                <a href="{{ route('customer_password.edit') }}">Alterar Senha</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Deslogar
                    </a>
                </form>
            @endguest
        </div>
        <div class="flex-1 py-6 space-y-6">
            <main class="container px-6">
                {{ $slot }}
            </main>
            @if (session('message'))
                <x-admin.layout.sections.notification />
            @endif
        </div>
    </div>
    @stack('scripts')
</body>

</html>
