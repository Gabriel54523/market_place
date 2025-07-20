@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:60vh;">
    <div class="card shadow-lg p-4 border-0 rounded-4" style="max-width: 500px; width:100%;">
        <div class="text-center mb-3">
            <span style="font-size:3rem; color:#0d6efd;">
                <i class="bi bi-person-circle"></i>
            </span>
            <h1 class="fw-bold mb-2">Bienvenido al Dashboard</h1>
        </div>
        <p class="fs-5">Hola, <b>{{ Auth::user()->name }}</b>. Tu rol es <span class="badge bg-primary text-capitalize">{{ Auth::user()->role }}</span>.</p>
        <p class="text-muted">Aquí podrás gestionar tus productos, pedidos o compras según tu rol.</p>
    </div>
</div>
@endsection 