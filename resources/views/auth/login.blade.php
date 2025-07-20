@extends('layouts.app')
@section('content')
<div class="flex items-center justify-center min-h-[70vh] bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">Iniciar sesión</h2>
        <form method="POST" action="{{ url('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" required autofocus>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">Entrar</button>
        </form>
        <div class="text-center mt-4">
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">¿No tienes cuenta? <b>Regístrate</b></a>
        </div>
    </div>
</div>
@endsection 