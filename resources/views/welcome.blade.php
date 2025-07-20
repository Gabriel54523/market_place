@extends('layouts.app')
@section('content')
<div class="fixed inset-0 z-0">
    <img src="{{ asset('img/Captura de pantalla_7-7-2025_184124_www.design.com.jpeg') }}" alt="Fondo" class="w-full h-full object-cover object-center min-h-screen min-w-full">
    <div class="absolute inset-0 bg-black/70"></div>
</div>
<div class="relative z-20 flex items-center justify-center min-h-screen">
    <div class="max-w-xl w-full text-center p-10 bg-white/80 rounded-2xl shadow-xl backdrop-blur-md">
        <h1 class="text-4xl md:text-5xl font-extrabold text-green-400 mb-4 drop-shadow">Bienvenido a Artesanos Marketplace</h1>
        <p class="text-lg text-gray-800 mb-8">Compra y vende productos artesanales de manera fácil, rápida y segura.<br>Regístrate o inicia sesión para comenzar a explorar el catálogo.</p>
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}" class="px-8 py-3 bg-green-600 text-white rounded-lg text-lg font-semibold shadow hover:bg-green-700 transition">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="px-8 py-3 bg-white border border-green-600 text-green-600 rounded-lg text-lg font-semibold shadow hover:bg-green-50 transition">Registrarse</a>
        </div>
    </div>
</div>
@endsection
