<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artesanos Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans min-h-screen">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-md flex flex-col px-4 py-6 space-y-4">
            <h1 class="text-2xl font-bold text-blue-600 mb-4">Artesanos</h1>

            <nav class="flex flex-col space-y-2">
                <a href="{{ route('catalogo') }}" class="hover:bg-blue-100 dark:hover:bg-gray-700 px-3 py-2 rounded transition">📦 Catálogo</a>
                
                @auth
                    @if(Auth::user()->role === 'cliente')
                        <a href="{{ route('carrito') }}" class="hover:bg-blue-100 dark:hover:bg-gray-700 px-3 py-2 rounded transition">🛒 Carrito</a>
                        <a href="{{ route('pedidos') }}" class="hover:bg-blue-100 dark:hover:bg-gray-700 px-3 py-2 rounded transition">📬 Mis pedidos</a>
                    @elseif(Auth::user()->role === 'artesano')
                        <a href="{{ route('products.index') }}" class="hover:bg-blue-100 dark:hover:bg-gray-700 px-3 py-2 rounded transition">🧵 Mis productos</a>
                        <a href="{{ route('pedidos.artesano') }}" class="hover:bg-blue-100 dark:hover:bg-gray-700 px-3 py-2 rounded transition">📦 Pedidos recibidos</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="hover:bg-blue-100 dark:hover:bg-gray-700 px-3 py-2 rounded transition">📊 Dashboard</a>
                @endauth
            </nav>

            <div class="mt-auto">
                @auth
                    <div class="text-sm mb-2">
                        👤 <b>{{ Auth::user()->name }}</b><br>
                        Rol: {{ Auth::user()->role }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded transition">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center px-3 py-2 rounded transition mb-2">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="block bg-gray-200 hover:bg-gray-300 text-center px-3 py-2 rounded transition">Registrarse</a>
                @endauth
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>

    </div>
</body>
</html>
