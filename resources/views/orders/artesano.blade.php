@extends('layouts.app')
@section('content')
<div class="row justify-content-center align-items-center" style="min-height:70vh;">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-gradient bg-primary text-white rounded-top-4 d-flex align-items-center justify-content-between">
                <h2 class="mb-0 fw-bold">Pedidos de mis productos</h2>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">&larr; Dashboard</a>
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
                        <table class="table table-hover align-middle bg-white rounded-3 overflow-hidden">
                            <thead class="table-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th class="text-center">Estado</th>
                                    <th>Productos vendidos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center fw-bold">{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill 
                                                @if($order->estado=='pendiente') bg-warning text-dark
                                                @elseif($order->estado=='enviado') bg-info text-dark
                                                @elseif($order->estado=='entregado') bg-success
                                                @endif">
                                                {{ ucfirst($order->estado) }}
                                            </span>
                                            <form method="POST" action="{{ route('pedidos.artesano.estado', $order) }}" class="d-inline ms-2">
                                                @csrf
                                                <select name="estado" class="form-select form-select-sm d-inline-block w-auto">
                                                    <option value="pendiente" @if($order->estado=='pendiente') selected @endif>Pendiente</option>
                                                    <option value="enviado" @if($order->estado=='enviado') selected @endif>Enviado</option>
                                                    <option value="entregado" @if($order->estado=='entregado') selected @endif>Entregado</option>
                                                </select>
                                                <button type="submit" class="btn btn-outline-primary btn-sm">Actualizar</button>
                                            </form>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                @foreach($order->products as $product)
                                                    <li class="mb-1">
                                                        <span class="fw-semibold">{{ $product->nombre }}</span>
                                                        <span class="badge bg-secondary">x{{ $product->pivot->cantidad }}</span>
                                                        <span class="text-muted">- ${{ number_format($product->pivot->precio,2) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">No hay pedidos para tus productos.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 