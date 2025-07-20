@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">Catálogo de productos</h2>
    <form method="GET" action="{{ route('catalogo') }}" class="mb-4 row g-2">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar producto...">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-lg border-0 rounded-4">
                    @if($product->imagen)
                        <img src="{{ asset('storage/'.$product->imagen) }}" class="card-img-top rounded-top-4" style="height:200px;object-fit:cover;">
                    @endif
                    <div class="card-body d-flex flex-column bg-light rounded-bottom-4">
                        <h5 class="card-title fw-bold">{{ $product->nombre }}</h5>
                        <p class="card-text text-truncate">{{ $product->descripcion }}</p>
                        <p class="mb-1"><span class="badge bg-primary">${{ number_format($product->precio,2) }}</span></p>
                        <p class="mb-1"><span class="badge bg-secondary">Artesano: {{ $product->user->name }}</span></p>
                        <a href="{{ route('catalogo.show', $product) }}" class="btn btn-outline-primary mt-auto">Ver detalle</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No hay productos disponibles.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection 