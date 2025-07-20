@extends('layouts.app')
@section('content')
<div class="row justify-content-center align-items-center" style="min-height:70vh;">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-4">
            @if($product->imagen)
                <img src="{{ asset('storage/'.$product->imagen) }}" class="card-img-top rounded-top-4" style="height:320px;object-fit:cover;">
            @endif
            <div class="card-body bg-light rounded-bottom-4">
                <h2 class="card-title fw-bold mb-2">{{ $product->nombre }}</h2>
                <p class="mb-2"><span class="badge bg-primary">${{ number_format($product->precio,2) }}</span> <span class="badge bg-secondary">Stock: {{ $product->stock }}</span></p>
                <p class="mb-2 text-muted">Artesano: <b>{{ $product->user->name }}</b></p>
                <p class="mb-3">{{ $product->descripcion }}</p>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($puedeComprar)
                    <form method="POST" action="{{ route('carrito.add', $product) }}" class="row g-2 align-items-center mb-3">
                        @csrf
                        <div class="col-auto">
                            <label class="form-label mb-0">Cantidad:</label>
                        </div>
                        <div class="col-auto">
                            <input type="number" name="cantidad" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:90px;">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success">Agregar al carrito</button>
                        </div>
                    </form>
                @endif
                <a href="{{ route('catalogo') }}" class="btn btn-link">&larr; Volver al catálogo</a>
            </div>
        </div>
    </div>
</div>
@endsection 