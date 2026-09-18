@extends('layouts.app')

@section('title', 'Fuentes de financiamiento')


@push('styles')

<style>

    /* ==========================================
       TABLA DE FUENTES DE FINANCIAMIENTO
    ========================================== */

    .tabla-fuentes {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }

    /* DIVISIONES */

    .tabla-fuentes th,
    .tabla-fuentes td {
        border: 1px solid #d6e2da !important;
        padding: 12px 15px;
        vertical-align: middle;
    }

    /* ENCABEZADO VERDE CLARO */

    .tabla-fuentes thead th {
        background-color: #eaf7ee !important;
        color: #174c2b;
        font-weight: 700;
    }

    /* FILAS */

    .tabla-fuentes tbody td {
        background-color: #ffffff;
    }

    /* AL PASAR EL MOUSE */

    .tabla-fuentes tbody tr:hover td {
        background-color: #f3faf5;
    }


    /* ==========================================
       ANCHO DE LAS 6 COLUMNAS
    ========================================== */

    /* ID */
    .tabla-fuentes th:nth-child(1),
    .tabla-fuentes td:nth-child(1) {
        width: 7%;
    }

    /* Código */
    .tabla-fuentes th:nth-child(2),
    .tabla-fuentes td:nth-child(2) {
        width: 15%;
    }

    /* Nombre */
    .tabla-fuentes th:nth-child(3),
    .tabla-fuentes td:nth-child(3) {
        width: 23%;
    }

    /* Descripción */
    .tabla-fuentes th:nth-child(4),
    .tabla-fuentes td:nth-child(4) {
        width: 30%;
    }

    /* Estado */
    .tabla-fuentes th:nth-child(5),
    .tabla-fuentes td:nth-child(5) {
        width: 10%;
        text-align: center;
    }

    /* Acciones */
    .tabla-fuentes th:nth-child(6),
    .tabla-fuentes td:nth-child(6) {
        width: 15%;
        text-align: center;
    }

</style>

@endpush


@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="mb-1">
            Fuentes de financiamiento
        </h2>

        <p class="text-muted mb-0">
            Administración de fuentes de financiamiento
        </p>

    </div>


    <a href="{{ route('fuentes-financiamiento.create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle me-1"></i>
        Nueva fuente

    </a>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle tabla-fuentes">


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

                    @forelse($fuentes as $fuenteFinanciamiento)

                        <tr>


                            <!-- ID -->

                            <td>
                                {{ $fuenteFinanciamiento->id }}
                            </td>


                            <!-- CÓDIGO -->

                            <td>

                                <strong>
                                    {{ $fuenteFinanciamiento->codigo }}
                                </strong>

                            </td>


                            <!-- NOMBRE -->

                            <td>
                                {{ $fuenteFinanciamiento->nombre }}
                            </td>


                            <!-- DESCRIPCIÓN -->

                            <td>
                                {{ $fuenteFinanciamiento->descripcion ?? '-' }}
                            </td>


                            <!-- ESTADO -->

                            <td>

                                @if($fuenteFinanciamiento->estado)

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
                                    href="{{ route('fuentes-financiamiento.show', $fuenteFinanciamiento) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Ver">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <a
                                    href="{{ route('fuentes-financiamiento.edit', $fuenteFinanciamiento) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Editar">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <form
                                    action="{{ route('fuentes-financiamiento.destroy', $fuenteFinanciamiento) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                        onclick="return confirm('¿Eliminar esta fuente?')">

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

                                No existen fuentes registradas.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


@endsection