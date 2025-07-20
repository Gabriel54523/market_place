<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artesanos Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <nav class="bg-white shadow sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between">
            <a href="{{ route('catalogo') }}" class="text-2xl font-bold text-blue-600">Artesanos</a>
            <div class="flex items-center space-x-4">
                <a href="{{ route('catalogo') }}" class="text-gray-700 hover:text-blue-600 font-medium">Catálogo</a>
                @auth
                    @if(Auth::user()->role === 'cliente')
                        <a href="{{ route('carrito') }}" class="text-gray-700 hover:text-blue-600 font-medium">Carrito</a>
                        <a href="{{ route('pedidos') }}" class="text-gray-700 hover:text-blue-600 font-medium">Mis pedidos</a>
                    @elseif(Auth::user()->role === 'artesano')
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Mis productos</a>
                        <a href="{{ route('pedidos.artesano') }}" class="text-gray-700 hover:text-blue-600 font-medium">Pedidos de mis productos</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                @endauth
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-gray-600">Hola, <b>{{ Auth::user()->name }}</b> ({{ Auth::user()->role }})</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 transition" type="submit">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>
</body>
</html> 