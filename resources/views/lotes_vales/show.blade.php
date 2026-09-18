@extends('layouts.app')

@section('title', 'Detalle del lote')

@section('content')

<h2>Detalle del lote de vales</h2>

<div class="card shadow-sm">
<div class="card-body">

<p>
<strong>Rango de vales:</strong>
{{ $loteVale->numero_inicial }}
-
{{ $loteVale->numero_final }}
</p>

<hr>

<p>
<strong>Fecha de recepción:</strong>
{{ $loteVale->fecha_recepcion?->format('d/m/Y') }}
</p>

<hr>

<p>
<strong>Periodo:</strong>
{{ $loteVale->periodo->nombre ?? '-' }}
</p>

<hr>

<p>
<strong>Tipo de combustible:</strong>
{{ $loteVale->tipoCombustible->nombre ?? '-' }}
</p>

<hr>

<p>
<strong>Estación:</strong>
{{ $loteVale->estacionServicio->nombre ?? '-' }}
</p>

<hr>

<p>
<strong>Estado:</strong>

@if($loteVale->estado)
<span class="badge bg-success">Activo</span>
@else
<span class="badge bg-secondary">Inactivo</span>
@endif
</p>

<a href="{{ route('lotes-vales.edit', $loteVale) }}"
   class="btn btn-warning">
Editar
</a>

<a href="{{ route('lotes-vales.index') }}"
   class="btn btn-secondary">
Volver
</a>

</div>
</div>

@endsection