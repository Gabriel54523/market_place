@extends('layouts.app')
@section('content')
<div class="flex items-center justify-center min-h-[70vh] bg-gray-50">
    <div class="w-full max-w-lg p-8 bg-white rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-8">Crear producto</h2>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                <label class="block text-blue-700 font-semibold mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full px-4 py-2 bg-white border-2 border-blue-400 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none font-bold text-blue-900 placeholder-blue-300" required placeholder="Ej: Pulsera artesanal">
            </div>
            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                <label class="block text-green-700 font-semibold mb-1">Descripción</label>
                <textarea name="descripcion" class="w-full px-4 py-2 bg-white border-2 border-green-400 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none font-bold text-green-900 placeholder-green-300" required placeholder="Describe el producto...">{{ old('descripcion') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4">
                    <label class="block text-yellow-700 font-semibold mb-1">Precio</label>
                    <input type="number" name="precio" step="0.01" value="{{ old('precio') }}" class="w-full px-4 py-2 bg-white border-2 border-yellow-400 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none font-bold text-yellow-900 placeholder-yellow-300" required placeholder="$0.00">
                </div>
                <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-4">
                    <label class="block text-purple-700 font-semibold mb-1">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full px-4 py-2 bg-white border-2 border-purple-400 rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none font-bold text-purple-900 placeholder-purple-300" required placeholder="0">
                </div>
            </div>
            <div class="flex items-center justify-center">
                <label class="relative cursor-pointer px-8 py-3 bg-gradient-to-r from-blue-600 to-green-500 text-white font-bold rounded-full shadow-lg border-4 border-blue-400 hover:from-blue-700 hover:to-green-600 transition-all duration-300 text-lg focus:outline-none">
                    <span id="fileLabel">Subir imagen</span>
                    <input type="file" name="imagen" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="document.getElementById('fileLabel').innerText = this.files[0] ? this.files[0].name : 'Subir imagen'">
                </label>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded">{{ $errors->first() }}</div>
            @endif
            <div class="flex justify-between items-center mt-6">
                <button type="submit" class="px-8 py-2 bg-blue-600 text-white rounded-lg font-bold shadow hover:bg-blue-700 transition text-lg">Guardar</button>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">&larr; Volver</a>
            </div>
        </form>
    </div>
</div>
@endsection 