@extends('layouts.app')

@section('title', 'Nuevo vale')

@section('content')

<h2>Nuevo vale de combustible</h2>
<p class="text-muted">Registrar consumo de combustible</p>

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

<form action="{{ route('vales-combustible.store') }}"
      method="POST">

@csrf

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">Número de vale *</label>

<input type="number"
       name="numero_vale"
       class="form-control"
       value="{{ old('numero_vale') }}"
       required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Fecha *</label>

<input type="date"
       name="fecha"
       class="form-control"
       value="{{ old('fecha', date('Y-m-d')) }}"
       required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Lote de vales *</label>

<select name="lote_vale_id"
        class="form-select"
        required>

<option value="">Seleccione...</option>

@foreach($lotes as $lote)

<option value="{{ $lote->id }}"
{{ old('lote_vale_id') == $lote->id ? 'selected' : '' }}>

{{ $lote->numero_inicial }}
-
{{ $lote->numero_final }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Vehículo *</label>

<select name="vehiculo_id"
        class="form-select"
        required>

<option value="">Seleccione...</option>

@foreach($vehiculos as $vehiculo)

<option value="{{ $vehiculo->id }}"
{{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>

{{ $vehiculo->codigo }}
-
{{ $vehiculo->placa }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Apertura programática *</label>

<select name="apertura_programatica_id"
        class="form-select"
        required>

<option value="">Seleccione...</option>

@foreach($aperturas as $apertura)

<option value="{{ $apertura->id }}"
{{ old('apertura_programatica_id') == $apertura->id ? 'selected' : '' }}>

{{ $apertura->codigo }}
-
{{ $apertura->descripcion }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Número de factura</label>

<input type="text"
       name="numero_factura"
       class="form-control"
       value="{{ old('numero_factura') }}">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Cantidad de litros *</label>

<input type="number"
       step="0.0001"
       min="0"
       id="cantidad_litros"
       name="cantidad_litros"
       class="form-control"
       value="{{ old('cantidad_litros') }}"
       required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">Precio unitario (Bs) *</label>

<input type="number"
       step="0.0001"
       min="0"
       id="precio_unitario"
       name="precio_unitario"
       class="form-control"
       value="{{ old('precio_unitario') }}"
       required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Total calculado (Bs)</label>

<input type="text"
       id="total_visual"
       class="form-control"
       value="0.00"
       readonly>

<small class="text-muted">
El total será calculado nuevamente por el sistema al guardar.
</small>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Kilometraje</label>

<input type="number"
       name="kilometraje"
       min="0"
       class="form-control"
       value="{{ old('kilometraje') }}">

</div>

<div class="col-12 mb-3">

<label class="form-label">Observación</label>

<textarea name="observacion"
          class="form-control"
          rows="3">{{ old('observacion') }}</textarea>

</div>

</div>

<button type="submit" class="btn btn-primary">
<i class="bi bi-save me-1"></i>
Guardar
</button>

<a href="{{ route('vales-combustible.index') }}"
   class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const litros = document.getElementById('cantidad_litros');
    const precio = document.getElementById('precio_unitario');
    const total = document.getElementById('total_visual');

    function calcularTotal() {

        const cantidad = parseFloat(litros.value) || 0;
        const precioUnitario = parseFloat(precio.value) || 0;

        total.value = (cantidad * precioUnitario).toFixed(2);
    }

    litros.addEventListener('input', calcularTotal);
    precio.addEventListener('input', calcularTotal);

    calcularTotal();
});
</script>

@endsection