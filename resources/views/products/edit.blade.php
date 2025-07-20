@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Editar producto</h2>
    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $product->nombre) }}" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion" required>{{ old('descripcion', $product->descripcion) }}</textarea>
        </div>
        <div>
            <label>Precio</label>
            <input type="number" name="precio" step="0.01" value="{{ old('precio', $product->precio) }}" required>
        </div>
        <div>
            <label>Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>
        <div>
            <label>Imagen actual:</label>
            @if($product->imagen)
                <img src="{{ asset('storage/'.$product->imagen) }}" width="60">
            @else
                No hay imagen
            @endif
        </div>
        <div>
            <label>Cambiar imagen</label>
            <input type="file" name="imagen">
        </div>
        @if ($errors->any())
            <div style="color:red;">{{ $errors->first() }}</div>
        @endif
        <button type="submit">Actualizar</button>
    </form>
    <a href="{{ route('products.index') }}">Volver</a>
</div>
@endsection 