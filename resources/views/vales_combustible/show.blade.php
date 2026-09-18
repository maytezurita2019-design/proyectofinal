@extends('layouts.app')

@section('title', 'Detalle del vale')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h2>Vale N.º {{ $valeCombustible->numero_vale }}</h2>
<p class="text-muted mb-0">
Detalle del consumo de combustible
</p>
</div>

<a href="{{ route('vales-combustible.index') }}"
   class="btn btn-secondary">
<i class="bi bi-arrow-left"></i>
Volver
</a>

</div>

<div class="card shadow-sm">
<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">
<strong>Número de vale</strong>
<div>{{ $valeCombustible->numero_vale }}</div>
</div>

<div class="col-md-6 mb-3">
<strong>Fecha</strong>
<div>{{ $valeCombustible->fecha?->format('d/m/Y') }}</div>
</div>

<div class="col-md-6 mb-3">
<strong>Lote</strong>
<div>
{{ $valeCombustible->loteVale->numero_inicial ?? '-' }}
-
{{ $valeCombustible->loteVale->numero_final ?? '-' }}
</div>
</div>

<div class="col-md-6 mb-3">
<strong>Vehículo</strong>
<div>
{{ $valeCombustible->vehiculo->codigo ?? '' }}
-
{{ $valeCombustible->vehiculo->placa ?? '-' }}
</div>
</div>

<div class="col-md-6 mb-3">
<strong>Apertura programática</strong>
<div>
{{ $valeCombustible->aperturaProgramatica->codigo ?? '-' }}
</div>
</div>

<div class="col-md-6 mb-3">
<strong>Factura</strong>
<div>
{{ $valeCombustible->numero_factura ?? 'Sin factura' }}
</div>
</div>

<div class="col-md-4 mb-3">
<strong>Cantidad de litros</strong>
<div>
{{ number_format($valeCombustible->cantidad_litros, 4) }}
</div>
</div>

<div class="col-md-4 mb-3">
<strong>Precio unitario</strong>
<div>
Bs {{ number_format($valeCombustible->precio_unitario, 4) }}
</div>
</div>

<div class="col-md-4 mb-3">
<strong>Total</strong>
<div class="fs-5">
<strong>
Bs {{ number_format($valeCombustible->total, 2) }}
</strong>
</div>
</div>

<div class="col-md-6 mb-3">
<strong>Kilometraje</strong>
<div>
{{ $valeCombustible->kilometraje ?? '-' }}
</div>
</div>

<div class="col-md-6 mb-3">
<strong>Registrado por</strong>
<div>
{{ $valeCombustible->usuario->nombre ?? '-' }}
{{ $valeCombustible->usuario->apellido ?? '' }}
</div>
</div>

<div class="col-12 mb-3">
<strong>Observación</strong>
<div>
{{ $valeCombustible->observacion ?? 'Sin observación' }}
</div>
</div>

</div>

<hr>

<a href="{{ route('vales-combustible.edit', $valeCombustible) }}"
   class="btn btn-warning">
<i class="bi bi-pencil me-1"></i>
Editar
</a>

</div>
</div>

@endsection