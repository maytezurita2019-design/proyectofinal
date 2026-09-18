@extends('layouts.app')

@section('title', 'Lotes de vales')


@push('styles')

<style>

    /* ==========================================
       TABLA DE LOTES DE VALES
    ========================================== */

    .tabla-lotes {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }


    /* DIVISIONES DE LAS CELDAS */

    .tabla-lotes th,
    .tabla-lotes td {
        border: 1px solid #d6e2da !important;
        padding: 12px 15px;
        vertical-align: middle;
    }


    /* ENCABEZADO VERDE CLARO */

    .tabla-lotes thead th {
        background-color: #eaf7ee !important;
        color: #174c2b;
        font-weight: 700;
    }


    /* FILAS */

    .tabla-lotes tbody td {
        background-color: #ffffff;
    }


    /* AL PASAR EL MOUSE */

    .tabla-lotes tbody tr:hover td {
        background-color: #f3faf5;
    }


    /* ==========================================
       ANCHO DE LAS 7 COLUMNAS
    ========================================== */

    /* Rango */
    .tabla-lotes th:nth-child(1),
    .tabla-lotes td:nth-child(1) {
        width: 15%;
    }

    /* Fecha recepción */
    .tabla-lotes th:nth-child(2),
    .tabla-lotes td:nth-child(2) {
        width: 14%;
    }

    /* Periodo */
    .tabla-lotes th:nth-child(3),
    .tabla-lotes td:nth-child(3) {
        width: 13%;
    }

    /* Combustible */
    .tabla-lotes th:nth-child(4),
    .tabla-lotes td:nth-child(4) {
        width: 14%;
    }

    /* Estación */
    .tabla-lotes th:nth-child(5),
    .tabla-lotes td:nth-child(5) {
        width: 19%;
    }

    /* Estado */
    .tabla-lotes th:nth-child(6),
    .tabla-lotes td:nth-child(6) {
        width: 10%;
        text-align: center;
    }

    /* Acciones */
    .tabla-lotes th:nth-child(7),
    .tabla-lotes td:nth-child(7) {
        width: 15%;
        text-align: center;
    }

</style>

@endpush


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="mb-1">
            Lotes de vales
        </h2>

        <p class="text-muted mb-0">
            Administración de rangos de vales de combustible
        </p>

    </div>


    <a href="{{ route('lotes-vales.create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle me-1"></i>
        Nuevo lote

    </a>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle tabla-lotes">


                <!-- ENCABEZADO -->

                <thead>

                    <tr>

                        <th>Rango</th>

                        <th>Fecha recepción</th>

                        <th>Periodo</th>

                        <th>Combustible</th>

                        <th>Estación</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>

                </thead>


                <!-- DATOS -->

                <tbody>

                    @forelse($lotes as $loteVale)

                        <tr>


                            <!-- RANGO -->

                            <td>

                                <strong>
                                    {{ $loteVale->numero_inicial }}
                                    -
                                    {{ $loteVale->numero_final }}
                                </strong>

                            </td>


                            <!-- FECHA DE RECEPCIÓN -->

                            <td>
                                {{ $loteVale->fecha_recepcion?->format('d/m/Y') }}
                            </td>


                            <!-- PERIODO -->

                            <td>
                                {{ $loteVale->periodo->nombre ?? '-' }}
                            </td>


                            <!-- TIPO DE COMBUSTIBLE -->

                            <td>
                                {{ $loteVale->tipoCombustible->nombre ?? '-' }}
                            </td>


                            <!-- ESTACIÓN -->

                            <td>
                                {{ $loteVale->estacionServicio->nombre ?? '-' }}
                            </td>


                            <!-- ESTADO -->

                            <td>

                                @if($loteVale->estado)

                                    <span class="badge bg-success">
                                        Activo
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Inactivo
                                    </span>

                                @endif

                            </td>


                            <!-- ACCIONES -->

                            <td>

                                <a
                                    href="{{ route('lotes-vales.show', $loteVale) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Ver">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <a
                                    href="{{ route('lotes-vales.edit', $loteVale) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Editar">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <form
                                    action="{{ route('lotes-vales.destroy', $loteVale) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                        onclick="return confirm('¿Eliminar este lote?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted py-4">

                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                No existen lotes registrados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection