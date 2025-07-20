@extends('layouts.app')
@section('content')
<div class="row justify-content-center align-items-center" style="min-height:70vh;">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body bg-light rounded-4">
                <h2 class="fw-bold mb-4 text-center">Registro</h2>
                <form method="POST" action="{{ url('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="role" class="form-select" required>
                            <option value="cliente">Cliente</option>
                            <option value="artesano">Artesano</option>
                        </select>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <button type="submit" class="btn btn-success w-100">Registrarse</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">¿Ya tienes cuenta? <b>Inicia sesión</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 