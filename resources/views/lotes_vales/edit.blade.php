@extends('layouts.app')

@section('title', 'Editar lote')

@section('content')

<h2>Editar lote de vales</h2>

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

<form action="{{ route('lotes-vales.update', $loteVale) }}"
      method="POST">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Número inicial *</label>

<input type="number"
       name="numero_inicial"
       class="form-control"
       value="{{ old('numero_inicial', $loteVale->numero_inicial) }}"
       required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Número final *</label>

<input type="number"
       name="numero_final"
       class="form-control"
       value="{{ old('numero_final', $loteVale->numero_final) }}"
       required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Fecha recepción *</label>

<input type="date"
       name="fecha_recepcion"
       class="form-control"
       value="{{ old('fecha_recepcion', $loteVale->fecha_recepcion?->format('Y-m-d')) }}"
       required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Periodo *</label>

<select name="periodo_id" class="form-select" required>

@foreach($periodos as $periodo)

<option value="{{ $periodo->id }}"
{{ old('periodo_id', $loteVale->periodo_id) == $periodo->id ? 'selected' : '' }}>
{{ $periodo->nombre }}
</option>

@endforeach

</select>
</div>

<div class="col-md-6 mb-3">

<label class="form-label">Tipo de combustible *</label>

<select name="tipo_combustible_id"
        class="form-select"
        required>

@foreach($tiposCombustible as $tipo)

<option value="{{ $tipo->id }}"
{{ old('tipo_combustible_id', $loteVale->tipo_combustible_id) == $tipo->id ? 'selected' : '' }}>
{{ $tipo->nombre }}
</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Estación de servicio *</label>

<select name="estacion_servicio_id"
        class="form-select"
        required>

@foreach($estaciones as $estacion)

<option value="{{ $estacion->id }}"
{{ old('estacion_servicio_id', $loteVale->estacion_servicio_id) == $estacion->id ? 'selected' : '' }}>
{{ $estacion->nombre }}
</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Estado *</label>

<select name="estado" class="form-select">

<option value="1"
{{ old('estado', $loteVale->estado) == 1 ? 'selected' : '' }}>
Activo
</option>

<option value="0"
{{ old('estado', $loteVale->estado) == 0 ? 'selected' : '' }}>
Inactivo
</option>

</select>

</div>

</div>

<button class="btn btn-primary">Actualizar</button>

<a href="{{ route('lotes-vales.index') }}"
   class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

@endsection