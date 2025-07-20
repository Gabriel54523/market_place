@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-gradient bg-primary text-white rounded-top-4">
                <h3 class="mb-0 fw-bold">Mis pedidos</h3>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($orders->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle bg-white rounded-3 overflow-hidden">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Productos</th>
                                    <th>Factura</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td><span class="badge bg-primary">${{ number_format($order->total,2) }}</span></td>
                                        <td><span class="badge rounded-pill 
                                            @if($order->estado=='pendiente') bg-warning text-dark
                                            @elseif($order->estado=='enviado') bg-info text-dark
                                            @elseif($order->estado=='entregado') bg-success
                                            @endif">{{ ucfirst($order->estado) }}</span></td>
                                        <td>
                                            <ul class="mb-0 list-unstyled">
                                                @foreach($order->products as $product)
                                                    <li class="mb-1">
                                                        <span class="fw-semibold">{{ $product->nombre }}</span>
                                                        <span class="badge bg-secondary">x{{ $product->pivot->cantidad }}</span>
                                                        <span class="text-muted">- ${{ number_format($product->pivot->precio,2) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('factura.pdf', $order) }}" class="px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm font-semibold" target="_blank">Descargar factura</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">No tienes pedidos realizados.</div>
                @endif
                <a href="{{ route('catalogo') }}" class="btn btn-link mt-3">&larr; Volver al catálogo</a>
            </div>
        </div>
    </div>
</div>
@endsection 