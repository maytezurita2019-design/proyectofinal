@extends('layouts.app')

@section('title', 'Nuevo vehículo')

@section('content')

<h2>Nuevo vehículo</h2>
<p class="text-muted">Registrar vehículo del parque automotor</p>

<div class="card shadow-sm">
<div class="card-body">

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('vehiculos.store') }}" method="POST">
@csrf

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Código *</label>
        <input type="text"
               name="codigo"
               class="form-control"
               value="{{ old('codigo') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Placa *</label>
        <input type="text"
               name="placa"
               class="form-control"
               value="{{ old('placa') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Tipo</label>
        <input type="text"
               name="tipo"
               class="form-control"
               value="{{ old('tipo') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Industria</label>
        <input type="text"
               name="industria"
               class="form-control"
               value="{{ old('industria') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Marca</label>
        <input type="text"
               name="marca"
               class="form-control"
               value="{{ old('marca') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Color</label>
        <input type="text"
               name="color"
               class="form-control"
               value="{{ old('color') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Unidad *</label>

        <select name="unidad_id" class="form-select" required>
            <option value="">Seleccione...</option>

            @foreach($unidades as $unidad)
                <option value="{{ $unidad->id }}"
                    {{ old('unidad_id') == $unidad->id ? 'selected' : '' }}>
                    {{ $unidad->nombre }}
                    @if($unidad->sigla)
                        - {{ $unidad->sigla }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Estado *</label>

        <select name="estado" class="form-select" required>
            <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>
                Activo
            </option>
            <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>
                Inactivo
            </option>
        </select>
    </div>

</div>

<button class="btn btn-primary">
    <i class="bi bi-save me-1"></i> Guardar
</button>

<a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
    Cancelar
</a>

</form>

</div>
</div>

@endsection