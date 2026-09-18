@extends('layouts.app')

@section('title', 'Organismos financiadores')


@push('styles')

<style>

    /* ==========================================
       TABLA DE ORGANISMOS FINANCIADORES
    ========================================== */

    .tabla-organismos {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }


    /* DIVISIONES DE LAS CELDAS */

    .tabla-organismos th,
    .tabla-organismos td {
        border: 1px solid #d6e2da !important;
        padding: 12px 15px;
        vertical-align: middle;
    }


    /* ENCABEZADO VERDE CLARO */

    .tabla-organismos thead th {
        background-color: #eaf7ee !important;
        color: #174c2b;
        font-weight: 700;
    }


    /* FILAS */

    .tabla-organismos tbody td {
        background-color: #ffffff;
    }


    /* AL PASAR EL MOUSE */

    .tabla-organismos tbody tr:hover td {
        background-color: #f3faf5;
    }


    /* ==========================================
       ANCHO DE LAS 6 COLUMNAS
    ========================================== */

    /* ID */
    .tabla-organismos th:nth-child(1),
    .tabla-organismos td:nth-child(1) {
        width: 7%;
    }

    /* Código */
    .tabla-organismos th:nth-child(2),
    .tabla-organismos td:nth-child(2) {
        width: 15%;
    }

    /* Nombre */
    .tabla-organismos th:nth-child(3),
    .tabla-organismos td:nth-child(3) {
        width: 23%;
    }

    /* Descripción */
    .tabla-organismos th:nth-child(4),
    .tabla-organismos td:nth-child(4) {
        width: 30%;
    }

    /* Estado */
    .tabla-organismos th:nth-child(5),
    .tabla-organismos td:nth-child(5) {
        width: 10%;
        text-align: center;
    }

    /* Acciones */
    .tabla-organismos th:nth-child(6),
    .tabla-organismos td:nth-child(6) {
        width: 15%;
        text-align: center;
    }

</style>

@endpush


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="mb-1">
            Organismos financiadores
        </h2>

        <p class="text-muted mb-0">
            Administración de organismos financiadores
        </p>

    </div>


    <a href="{{ route('organismos-financiadores.create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle me-1"></i>
        Nuevo organismo

    </a>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle tabla-organismos">


                <!-- ENCABEZADO -->

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Código</th>

                        <th>Nombre</th>

                        <th>Descripción</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>

                </thead>


                <!-- DATOS -->

                <tbody>

                    @forelse($organismos as $organismoFinanciador)

                        <tr>


                            <!-- ID -->

                            <td>
                                {{ $organismoFinanciador->id }}
                            </td>


                            <!-- CÓDIGO -->

                            <td>

                                <strong>
                                    {{ $organismoFinanciador->codigo }}
                                </strong>

                            </td>


                            <!-- NOMBRE -->

                            <td>
                                {{ $organismoFinanciador->nombre }}
                            </td>


                            <!-- DESCRIPCIÓN -->

                            <td>
                                {{ $organismoFinanciador->descripcion ?? '-' }}
                            </td>


                            <!-- ESTADO -->

                            <td>

                                @if($organismoFinanciador->estado)

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
                                    href="{{ route('organismos-financiadores.show', $organismoFinanciador) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Ver">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <a
                                    href="{{ route('organismos-financiadores.edit', $organismoFinanciador) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Editar">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <form
                                    action="{{ route('organismos-financiadores.destroy', $organismoFinanciador) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                        onclick="return confirm('¿Eliminar este organismo?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center text-muted py-4">

                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                No existen organismos financiadores registrados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection