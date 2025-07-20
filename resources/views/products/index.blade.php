@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h3 class="mb-0 fw-bold">Mis productos</h3>
                <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">Crear nuevo producto</a>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle bg-white rounded-3 overflow-hidden">
                        <thead class="table-primary">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->nombre }}</td>
                                    <td>{{ $product->descripcion }}</td>
                                    <td><span class="badge bg-primary">${{ number_format($product->precio, 2) }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $product->stock }}</span></td>
                                    <td>
                                        @if($product->imagen)
                                            <img src="{{ asset('storage/'.$product->imagen) }}" width="60" class="rounded shadow-sm">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">Editar</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 