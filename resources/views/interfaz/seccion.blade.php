@extends('layouts.institucional')
@section('contenido')
@if($modulo !== 'api-consulta')
@include('interfaz.acciones')
@else
<section class="card"><div class="card-body p-4 p-lg-5"><div class="icono-seccion mb-3"><i class="{{ $icono }}" aria-hidden="true"></i></div><span class="badge prototipo mb-3">Pendiente de diseño</span><h2 class="h4">{{ $titulo }}</h2><p class="text-secondary">Esta sección forma parte de {{ $grupo }}. Su ubicación en el menú está disponible para revisar la navegación.</p><p class="text-secondary">@if($modulo === 'api-consulta')La API REST de consulta se desarrollará en una fase posterior.@elseif($modulo === 'reportes')Los filtros, reportes y exportaciones se diseñarán en una fase posterior.@else Los listados y formularios se diseñarán después de aprobar la estructura inicial.@endif</p><a class="btn btn-primary mt-2" href="{{ route('dashboard') }}">Volver al resumen</a></div></section>
@endif
@stop
