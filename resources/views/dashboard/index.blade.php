@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>

    /* ================================
       DASHBOARD SIGECOM
    ================================= */

    .dashboard-titulo {
        color: #174c2b;
        font-weight: 700;
    }

    .dashboard-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        transition: transform .2s ease, box-shadow .2s ease;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,.12);
    }

    .dashboard-icono {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        background-color: #eaf7ee;
        color: #198754;
        flex-shrink: 0;
    }

    .dashboard-numero {
        font-size: 25px;
        font-weight: 700;
        color: #212529;
        margin: 0;
    }

    .dashboard-texto {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }

    .dashboard-seccion {
        color: #174c2b;
        font-weight: 700;
        font-size: 18px;
    }

    /* TABLA */

    .tabla-dashboard {
        width: 100%;
        border-collapse: collapse;
    }

    .tabla-dashboard th,
    .tabla-dashboard td {
        border: 1px solid #d6e2da !important;
        padding: 11px 10px;
        vertical-align: middle;
    }

    .tabla-dashboard thead th {
        background-color: #eaf7ee !important;
        color: #174c2b;
        font-weight: 700;
    }

    .tabla-dashboard tbody td {
        background-color: #ffffff;
    }

    .tabla-dashboard tbody tr:hover td {
        background-color: #f3faf5;
    }

    /* ACCESOS RÁPIDOS */

    .acceso-rapido {
        border: 1px solid #d6e2da;
        border-radius: 10px;
        padding: 15px;
        text-decoration: none;
        color: #174c2b;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: .2s;
        background: #ffffff;
    }

    .acceso-rapido:hover {
        background-color: #eaf7ee;
        color: #174c2b;
        border-color: #a9d5b6;
    }

    .acceso-rapido i {
        font-size: 22px;
        color: #198754;
    }

</style>
@endpush


@section('content')

{{-- ENCABEZADO --}}
<div class="mb-4">

    <h2 class="dashboard-titulo mb-1">
        Dashboard
    </h2>

    <p class="text-muted mb-0">
        Resumen general del Sistema de Gestión y Control de Combustible
    </p>

</div>


{{-- ==========================================
     TARJETAS PRINCIPALES
========================================== --}}

<div class="row g-3 mb-4">

    {{-- VEHÍCULOS --}}
    <div class="col-xl-3 col-md-6">

        <div class="card dashboard-card">

            <div class="card-body d-flex align-items-center gap-3">

                <div class="dashboard-icono">
                    <i class="bi bi-truck"></i>
                </div>

                <div>
                    <p class="dashboard-numero">
                        {{ $vehiculosActivos }}
                    </p>

                    <p class="dashboard-texto">
                        Vehículos activos
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- VALES --}}
    <div class="col-xl-3 col-md-6">

        <div class="card dashboard-card">

            <div class="card-body d-flex align-items-center gap-3">

                <div class="dashboard-icono">
                    <i class="bi bi-receipt"></i>
                </div>

                <div>
                    <p class="dashboard-numero">
                        {{ number_format($totalVales) }}
                    </p>

                    <p class="dashboard-texto">
                        Vales registrados
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- LITROS --}}
    <div class="col-xl-3 col-md-6">

        <div class="card dashboard-card">

            <div class="card-body d-flex align-items-center gap-3">

                <div class="dashboard-icono">
                    <i class="bi bi-fuel-pump-fill"></i>
                </div>

                <div>
                    <p class="dashboard-numero">
                        {{ number_format($totalLitros, 2) }}
                    </p>

                    <p class="dashboard-texto">
                        Litros registrados
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL CONSUMIDO --}}
    <div class="col-xl-3 col-md-6">

        <div class="card dashboard-card">

            <div class="card-body d-flex align-items-center gap-3">

                <div class="dashboard-icono">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div>
                    <p class="dashboard-numero">
                        Bs {{ number_format($totalConsumido, 2) }}
                    </p>

                    <p class="dashboard-texto">
                        Total registrado
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>


{{-- ==========================================
     SEGUNDA FILA
========================================== --}}

<div class="row g-3 mb-4">

    {{-- LOTES ACTIVOS --}}
    <div class="col-md-6">

        <div class="card dashboard-card">

            <div class="card-body d-flex align-items-center gap-3">

                <div class="dashboard-icono">
                    <i class="bi bi-collection"></i>
                </div>

                <div>
                    <p class="dashboard-numero">
                        {{ $lotesActivos }}
                    </p>

                    <p class="dashboard-texto">
                        Lotes de vales activos
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- USUARIOS ACTIVOS --}}
    <div class="col-md-6">

        <div class="card dashboard-card">

            <div class="card-body d-flex align-items-center gap-3">

                <div class="dashboard-icono">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>
                    <p class="dashboard-numero">
                        {{ $usuariosActivos }}
                    </p>

                    <p class="dashboard-texto">
                        Usuarios activos
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>


{{-- ==========================================
     GRÁFICO DE CONSUMO MENSUAL
========================================== --}}

<div class="card shadow-sm mb-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="dashboard-seccion mb-0">

                <i class="bi bi-bar-chart-fill me-1"></i>

                Consumo mensual de combustible

            </h5>

            <span class="badge bg-success">
                {{ $anioActual }}
            </span>

        </div>

    </div>


    <div class="card-body">

        <div style="height: 320px;">

            <canvas id="graficoConsumoMensual"></canvas>

        </div>

    </div>

</div>

<div class="row g-4">

    {{-- ==========================================
         ÚLTIMOS VALES
    ========================================== --}}

    <div class="col-xl-8">

        <div class="card shadow-sm h-100">

            <div class="card-header bg-white py-3">

                <h5 class="dashboard-seccion mb-0">

                    <i class="bi bi-clock-history me-1"></i>

                    Últimos vales registrados

                </h5>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle tabla-dashboard">

                        <thead>

                            <tr>

                                <th>N.º Vale</th>

                                <th>Fecha</th>

                                <th>Vehículo</th>

                                <th>Litros</th>

                                <th>Total</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($ultimosVales as $vale)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $vale->numero_vale }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $vale->fecha?->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        {{ $vale->vehiculo->placa ?? '-' }}
                                    </td>

                                    <td>
                                        {{ number_format($vale->cantidad_litros, 2) }}
                                    </td>

                                    <td>
                                        <strong>
                                            Bs {{ number_format($vale->total, 2) }}
                                        </strong>
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="text-center text-muted py-4">

                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                        No existen vales registrados.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="text-end mt-3">

                    <a href="{{ route('vales-combustible.index') }}"
                       class="btn btn-outline-success btn-sm">

                        Ver todos los vales

                        <i class="bi bi-arrow-right ms-1"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================
         ACCESOS RÁPIDOS
    ========================================== --}}

    <div class="col-xl-4">

        <div class="card shadow-sm h-100">

            <div class="card-header bg-white py-3">

                <h5 class="dashboard-seccion mb-0">

                    <i class="bi bi-lightning-charge-fill me-1"></i>

                    Accesos rápidos

                </h5>

            </div>


            <div class="card-body">

                <div class="d-grid gap-3">


                    {{-- NUEVO VALE --}}

                    <a href="{{ route('vales-combustible.create') }}"
                       class="acceso-rapido">

                        <i class="bi bi-receipt"></i>

                        <div>

                            <strong>Registrar vale</strong>

                            <div class="small text-muted">
                                Registrar consumo de combustible
                            </div>

                        </div>

                    </a>


                    {{-- NUEVO LOTE --}}

                    <a href="{{ route('lotes-vales.create') }}"
                       class="acceso-rapido">

                        <i class="bi bi-collection"></i>

                        <div>

                            <strong>Registrar lote</strong>

                            <div class="small text-muted">
                                Registrar un nuevo lote de vales
                            </div>

                        </div>

                    </a>


                    {{-- NUEVO VEHÍCULO --}}

                    <a href="{{ route('vehiculos.create') }}"
                       class="acceso-rapido">

                        <i class="bi bi-truck"></i>

                        <div>

                            <strong>Registrar vehículo</strong>

                            <div class="small text-muted">
                                Agregar vehículo al parque automotor
                            </div>

                        </div>

                    </a>


                    {{-- VER PERIODOS --}}

                    <a href="{{ route('periodos.index') }}"
                       class="acceso-rapido">

                        <i class="bi bi-calendar3"></i>

                        <div>

                            <strong>Periodos</strong>

                            <div class="small text-muted">
                                Consultar periodos registrados
                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const meses = @json($meses);
    const consumoMensual = @json($consumoMensual);

    const canvasConsumo = document.getElementById('graficoConsumoMensual');

    if (canvasConsumo) {

        new Chart(canvasConsumo, {

            type: 'bar',

            data: {

                labels: meses,

                datasets: [{

                    label: 'Litros consumidos',

                    data: consumoMensual,

                    backgroundColor: 'rgba(25, 135, 84, 0.65)',

                    borderColor: 'rgb(25, 135, 84)',

                    borderWidth: 1,

                    borderRadius: 5

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    y: {

                        beginAtZero: true,

                        title: {
                            display: true,
                            text: 'Litros'
                        }

                    }

                },

                plugins: {

                    legend: {
                        display: true,
                        position: 'top'
                    }

                }

            }

        });

    }

</script>

@endpush

@endsection