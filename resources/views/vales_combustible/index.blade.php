@extends('layouts.app')

@section('title', 'Vales de combustible')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h2>Vales de combustible</h2>
<p class="text-muted mb-0">
Registro y control del consumo de combustible
</p>
</div>

<a href="{{ route('vales-combustible.create') }}"
   class="btn btn-primary">

<i class="bi bi-plus-circle me-1"></i>
Nuevo vale

</a>

</div>

<div class="card shadow-sm">
<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-light">

<tr>
<th>N.º Vale</th>
<th>Fecha</th>
<th>Vehículo</th>
<th>Litros</th>
<th>Precio</th>
<th>Total</th>
<th>Factura</th>
<th>Acciones</th>
</tr>

</thead>

<tbody>

@forelse($vales as $valeCombustible)

<tr>

<td>
<strong>{{ $valeCombustible->numero_vale }}</strong>
</td>

<td>
{{ $valeCombustible->fecha?->format('d/m/Y') }}
</td>

<td>
{{ $valeCombustible->vehiculo->placa ?? '-' }}
</td>

<td>
{{ number_format($valeCombustible->cantidad_litros, 4) }}
</td>

<td>
Bs {{ number_format($valeCombustible->precio_unitario, 4) }}
</td>

<td>
<strong>
Bs {{ number_format($valeCombustible->total, 2) }}
</strong>
</td>

<td>
{{ $valeCombustible->numero_factura ?? '-' }}
</td>

<td>

<a href="{{ route('vales-combustible.show', $valeCombustible) }}"
   class="btn btn-sm btn-info text-white">
<i class="bi bi-eye"></i>
</a>

<a href="{{ route('vales-combustible.edit', $valeCombustible) }}"
   class="btn btn-sm btn-warning">
<i class="bi bi-pencil"></i>
</a>

<form action="{{ route('vales-combustible.destroy', $valeCombustible) }}"
      method="POST"
      class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger"
        onclick="return confirm('¿Eliminar este vale?')">

<i class="bi bi-trash"></i>

</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center text-muted py-4">
No existen vales registrados.
</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>
</div>

@endsection