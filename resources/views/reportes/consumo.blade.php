@extends('layouts.app')

@section('title', 'Reportes de consumo')

@push('styles')
<style>
    .reporte-card {
        border: 1px solid #d6e2da;
        border-radius: 12px;
        background: #ffffff;
    }

    .reporte-titulo {
        color: #174c2b;
        font-weight: 700;
    }

    .resumen-card {
        border: 1px solid #d6e2da;
        border-radius: 10px;
        background: #f8fbf9;
        padding: 16px;
        height: 100%;
    }

    .resumen-card small {
        color: #6c757d;
    }

    .resumen-card h4 {
        color: #174c2b;
        margin: 5px 0 0;
        font-weight: 700;
    }

    .tabla-reporte {
        width: 100%;
        border-collapse: collapse;
    }

    .tabla-reporte th {
        background: #eaf7ee;
        color: #174c2b;
        font-weight: 700;
        border: 1px solid #d6e2da;
        vertical-align: middle;
    }

    .tabla-reporte td {
        background: #ffffff;
        border: 1px solid #d6e2da;
        vertical-align: middle;
    }

    .tabla-reporte tbody tr:hover td {
        background: #f3faf5;
    }

    .btn-verde {
        background: #198754;
        border-color: #198754;
        color: white;
    }

    .btn-verde:hover {
        background: #157347;
        border-color: #146c43;
        color: white;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="reporte-titulo mb-1">
                <i class="bi bi-bar-chart-line me-2"></i>
                Reporte de consumo
            </h3>

            <p class="text-muted mb-0">
                Consulta y análisis del consumo de combustible.
            </p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card reporte-card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="reporte-titulo mb-3">
                <i class="bi bi-funnel me-2"></i>
                Filtros
            </h5>

            <form method="GET"
                  action="{{ route('reportes.consumo') }}">

                <div class="row g-3">

                    {{-- Fecha inicial --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Fecha inicial
                        </label>

                        <input
                            type="date"
                            name="fecha_inicio"
                            class="form-control"
                            value="{{ request('fecha_inicio') }}">
                    </div>

                    {{-- Fecha final --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Fecha final
                        </label>

                        <input
                            type="date"
                            name="fecha_fin"
                            class="form-control"
                            value="{{ request('fecha_fin') }}">
                    </div>

                    {{-- Vehículo --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Vehículo
                        </label>

                        <select
                            name="vehiculo_id"
                            class="form-select">

                            <option value="">
                                Todos los vehículos
                            </option>

                            @foreach($vehiculos as $vehiculo)
                                <option
                                    value="{{ $vehiculo->id }}"
                                    {{ request('vehiculo_id') == $vehiculo->id
                                        ? 'selected'
                                        : '' }}>

                                    {{ $vehiculo->codigo }}
                                    - {{ $vehiculo->placa }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Unidad --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Unidad
                        </label>

                        <select
                            name="unidad_id"
                            class="form-select">

                            <option value="">
                                Todas las unidades
                            </option>

                            @foreach($unidades as $unidad)
                                <option
                                    value="{{ $unidad->id }}"
                                    {{ request('unidad_id') == $unidad->id
                                        ? 'selected'
                                        : '' }}>

                                    {{ $unidad->nombre }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Período --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Período
                        </label>

                        <select
                            name="periodo_id"
                            class="form-select">

                            <option value="">
                                Todos
                            </option>

                            @foreach($periodos as $periodo)
                                <option
                                    value="{{ $periodo->id }}"
                                    {{ request('periodo_id') == $periodo->id
                                        ? 'selected'
                                        : '' }}>

                                    {{ $periodo->nombre }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="mt-3 d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-verde">

                        <i class="bi bi-search me-1"></i>
                        Consultar
                    </button>

                    <a
                        href="{{ route('reportes.consumo') }}"
                        class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Limpiar
                    </a>

                </div>

            </form>

        </div>
    </div>

    {{-- Resumen --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="resumen-card">
                <small>Vales encontrados</small>
                <h4>{{ number_format($totalVales, 0, ',', '.') }}</h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="resumen-card">
                <small>Total de litros</small>
                <h4>
                    {{ number_format($totalLitros, 2, ',', '.') }} L
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="resumen-card">
                <small>Monto total</small>
                <h4>
                    Bs {{ number_format($totalMonto, 2, ',', '.') }}
                </h4>
            </div>
        </div>

    </div>

    {{-- Tabla --}}
    <div class="card reporte-card shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between
                        align-items-center mb-3">

                <h5 class="reporte-titulo mb-0">
                    Detalle del consumo
                </h5>

                <span class="text-muted">
                    {{ $totalVales }} registro(s)
                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover
                              align-middle tabla-reporte">

                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>N.º Vale</th>
                            <th>Código</th>
                            <th>Placa</th>
                            <th>Unidad</th>
                            <th>Combustible</th>
                            <th>Litros</th>
                            <th>P. Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($vales as $vale)

                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($vale->fecha)
                                        ->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $vale->numero_vale }}
                                </td>

                                <td>
                                    {{ $vale->vehiculo->codigo ?? '-' }}
                                </td>

                                <td>
                                    {{ $vale->vehiculo->placa ?? '-' }}
                                </td>

                                <td>
                                    {{ $vale->vehiculo->unidad->nombre ?? '-' }}
                                </td>

                                <td>
                                    {{ $vale->loteVale
                                        ->tipoCombustible
                                        ->nombre ?? '-' }}
                                </td>

                                <td>
                                    {{ number_format(
                                        $vale->cantidad_litros,
                                        2,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td>
                                    Bs {{ number_format(
                                        $vale->precio_unitario,
                                        2,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="fw-semibold">
                                    Bs {{ number_format(
                                        $vale->total,
                                        2,
                                        ',',
                                        '.'
                                    ) }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="9"
                                    class="text-center text-muted py-4">

                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>

                                    No existen registros de consumo
                                    para los filtros seleccionados.

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection