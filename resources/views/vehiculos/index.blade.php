@extends('layouts.app')

@section('title', 'Vehículos')


@push('styles')

<style>

    /* ==========================================
       TABLA DE VEHÍCULOS
    ========================================== */

    .tabla-vehiculos {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }


    /* DIVISIONES DE LAS CELDAS */

    .tabla-vehiculos th,
    .tabla-vehiculos td {
        border: 1px solid #d6e2da !important;
        padding: 12px 8px;
        vertical-align: middle;
    }


    /* ENCABEZADO VERDE CLARO */

    .tabla-vehiculos thead th {
        background-color: #eaf7ee !important;
        color: #174c2b;
        font-weight: 700;
    }


    /* FILAS */

    .tabla-vehiculos tbody td {
        background-color: #ffffff;
    }


    /* AL PASAR EL MOUSE */

    .tabla-vehiculos tbody tr:hover td {
        background-color: #f3faf5;
    }


    /* ==========================================
       ANCHO DE LAS 9 COLUMNAS
    ========================================== */

    /* Código */
    .tabla-vehiculos th:nth-child(1),
    .tabla-vehiculos td:nth-child(1) {
        width: 9%;
    }

    /* Placa */
    .tabla-vehiculos th:nth-child(2),
    .tabla-vehiculos td:nth-child(2) {
        width: 10%;
    }

    /* Tipo */
    .tabla-vehiculos th:nth-child(3),
    .tabla-vehiculos td:nth-child(3) {
        width: 10%;
    }

    /* Industria */
    .tabla-vehiculos th:nth-child(4),
    .tabla-vehiculos td:nth-child(4) {
        width: 10%;
    }

    /* Marca */
    .tabla-vehiculos th:nth-child(5),
    .tabla-vehiculos td:nth-child(5) {
        width: 10%;
    }

    /* Color */
    .tabla-vehiculos th:nth-child(6),
    .tabla-vehiculos td:nth-child(6) {
        width: 8%;
    }

    /* Unidad */
    .tabla-vehiculos th:nth-child(7),
    .tabla-vehiculos td:nth-child(7) {
        width: 17%;
    }

    /* Estado */
    .tabla-vehiculos th:nth-child(8),
    .tabla-vehiculos td:nth-child(8) {
        width: 10%;
        text-align: center;
    }

    /* Acciones */
    .tabla-vehiculos th:nth-child(9),
    .tabla-vehiculos td:nth-child(9) {
        width: 16%;
        text-align: center;
    }

</style>

@endpush


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="mb-1">
            Vehículos
        </h2>

        <p class="text-muted mb-0">
            Administración del parque automotor
        </p>

    </div>


    <a href="{{ route('vehiculos.create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle me-1"></i>
        Nuevo vehículo

    </a>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle tabla-vehiculos">


                <!-- ENCABEZADO -->

                <thead>

                    <tr>

                        <th>Código</th>

                        <th>Placa</th>

                        <th>Tipo</th>

                        <th>Industria</th>

                        <th>Marca</th>

                        <th>Color</th>

                        <th>Unidad</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>

                </thead>


                <!-- DATOS -->

                <tbody>

                    @forelse($vehiculos as $vehiculo)

                        <tr>


                            <!-- CÓDIGO -->

                            <td>
                                {{ $vehiculo->codigo }}
                            </td>


                            <!-- PLACA -->

                            <td>

                                <strong>
                                    {{ $vehiculo->placa }}
                                </strong>

                            </td>


                            <!-- TIPO -->

                            <td>
                                {{ $vehiculo->tipo ?? '-' }}
                            </td>


                            <!-- INDUSTRIA -->

                            <td>
                                {{ $vehiculo->industria ?? '-' }}
                            </td>


                            <!-- MARCA -->

                            <td>
                                {{ $vehiculo->marca ?? '-' }}
                            </td>


                            <!-- COLOR -->

                            <td>
                                {{ $vehiculo->color ?? '-' }}
                            </td>


                            <!-- UNIDAD -->

                            <td>
                                {{ $vehiculo->unidad->nombre ?? 'Sin unidad' }}
                            </td>


                            <!-- ESTADO -->

                            <td>

                                @if($vehiculo->estado)

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
                                    href="{{ route('vehiculos.show', $vehiculo) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Ver vehículo">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <a
                                    href="{{ route('vehiculos.edit', $vehiculo) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Editar vehículo">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <form
                                    action="{{ route('vehiculos.destroy', $vehiculo) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar vehículo"
                                        onclick="return confirm('¿Eliminar este vehículo?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center text-muted py-4">

                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                No existen vehículos registrados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection