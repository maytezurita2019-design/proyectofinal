@extends('adminlte::page')
@section('title', $titulo)
@section('css')
<link rel="stylesheet" href="{{ asset('css/institucional.css') }}">
@stop
@section('content_top_nav_left')
<li class="nav-item d-none d-md-flex align-items-center"><span class="text-secondary small">Gestión de provisión de combustible</span></li>
@stop
@section('content_top_nav_right')
<li class="nav-item d-flex align-items-center"><span class="badge prototipo">Prototipo · Fase 1</span></li>
<li class="nav-item d-flex align-items-center ms-3"><span class="small me-3">{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn btn-sm btn-outline-secondary">Cerrar sesión</button></form></li>
@stop
@section('content_header')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2"><div><div class="institucion">GOBIERNO AUTÓNOMO MUNICIPAL DE SACABA</div><h1 class="h3 mb-0">{{ $titulo }}</h1></div><nav aria-label="Ruta de navegación"><ol class="breadcrumb mb-0 small"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>@isset($grupo)<li class="breadcrumb-item">{{ $grupo }}</li>@endisset<li class="breadcrumb-item active" aria-current="page">{{ $titulo }}</li></ol></nav></div>
@stop
@section('content')
<div class="aviso-demo mb-4">Vista de demostración. Los datos son ficticios y no se guardan registros.</div>
@yield('contenido')
@stop
@section('footer')
<strong>GAM Sacaba</strong> · Parque automotor y combustible <span class="float-end d-none d-sm-inline">Interfaz en revisión</span>
@stop
