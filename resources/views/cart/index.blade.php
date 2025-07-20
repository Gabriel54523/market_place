@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-gradient bg-primary text-white rounded-top-4">
                <h3 class="mb-0 fw-bold">Mi carrito</h3>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($products->count())
                    <form method="POST" action="{{ route('carrito.confirmar') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle bg-white rounded-3 overflow-hidden">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Artesano</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($products as $product)
                                        @php $subtotal = $product->precio * $product->pivot->cantidad; $total += $subtotal; @endphp
                                        <tr>
                                            <td>{{ $product->nombre }}</td>
                                            <td>{{ $product->user->name }}</td>
                                            <td><span class="badge bg-primary">${{ number_format($product->precio,2) }}</span></td>
                                            <td>
                                                <form method="POST" action="{{ route('carrito.update', $product) }}" class="d-inline">
                                                    @csrf
                                                    <input type="number" name="cantidad" value="{{ $product->pivot->cantidad }}" min="1" class="form-control d-inline-block" style="width:70px;">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Actualizar</button>
                                                </form>
                                            </td>
                                            <td><span class="badge bg-success">${{ number_format($subtotal,2) }}</span></td>
                                            <td>
                                                <form method="POST" action="{{ route('carrito.remove', $product) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h4 class="text-end">Total: <span class="text-success">${{ number_format($total,2) }}</span></h4>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-lg">Confirmar pedido</button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">Tu carrito está vacío.</div>
                @endif
                <a href="{{ route('catalogo') }}" class="btn btn-link mt-3">&larr; Seguir comprando</a>
            </div>
        </div>
    </div>
</div>
@endsection 