@extends('layouts.app')

@section('title', 'Nuevo periodo')

@section('content')

<h2>Nuevo periodo</h2>

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

<form action="{{ route('periodos.store') }}" method="POST">
@csrf

<div class="row">

<div class="col-md-6 mb-3">
    <label class="form-label">Nombre *</label>
    <input type="text"
           name="nombre"
           class="form-control"
           value="{{ old('nombre') }}"
           required>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label">Mes *</label>

    <select name="mes" class="form-select" required>
        <option value="">Seleccione...</option>

        @for($mes = 1; $mes <= 12; $mes++)
            <option value="{{ $mes }}"
                {{ old('mes') == $mes ? 'selected' : '' }}>
                {{ $mes }}
            </option>
        @endfor
    </select>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label">Año *</label>

    <input type="number"
           name="anio"
           class="form-control"
           value="{{ old('anio', date('Y')) }}"
           required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Fecha inicio *</label>

    <input type="date"
           name="fecha_inicio"
           class="form-control"
           value="{{ old('fecha_inicio') }}"
           required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Fecha fin *</label>

    <input type="date"
           name="fecha_fin"
           class="form-control"
           value="{{ old('fecha_fin') }}"
           required>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Estado *</label>

    <select name="estado" class="form-select">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select>
</div>

</div>

<button class="btn btn-primary">Guardar</button>

<a href="{{ route('periodos.index') }}"
   class="btn btn-secondary">
    Cancelar
</a>

</form>

</div>
</div>

@endsection