<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIGECOM')</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>

        body {
            margin: 0;
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }


        /* =====================================================
           MENÚ LATERAL
        ===================================================== */

        .menu-lateral {
            width: 270px;
            height: 100vh;

            position: fixed;
            top: 0;
            left: 0;

            background:
                linear-gradient(
                    180deg,
                    #17211b 0%,
                    #1d2921 50%,
                    #17211b 100%
                );

            overflow-y: auto;
            overflow-x: hidden;

            z-index: 1000;

            box-shadow:
                4px 0 15px rgba(0, 0, 0, .10);
        }


        /* Scroll */

        .menu-lateral::-webkit-scrollbar {
            width: 5px;
        }

        .menu-lateral::-webkit-scrollbar-thumb {
            background: #3c5945;
            border-radius: 10px;
        }


        /* =====================================================
           LOGO / NOMBRE DEL SISTEMA
        ===================================================== */

.logo {
    min-height: 105px;
    padding: 15px 16px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 12px;

    border-bottom: 1px solid rgba(255, 255, 255, .10);

    background: rgba(255, 255, 255, .02);

    text-align: left;
}


/* TEXTO IZQUIERDO */

.logo-texto {
    flex: 1;
    min-width: 0;
}

.logo-texto h5 {
    margin: 0 0 5px;

    color: #ffffff;

    font-size: 20px;
    font-weight: 800;

    letter-spacing: .5px;
}

.logo-texto small {
    display: block;

    color: #d5ded8;

    font-size: 11px;
    line-height: 1.35;
}


/* LOGO DERECHO */

.logo-icono {
    width: 72px;
    height: 72px;

    flex: 0 0 72px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin: 0;

    padding: 3px;

    border-radius: 50%;

    background: #ffffff;

    box-shadow:
        0 5px 15px rgba(0, 0, 0, .30);
}

.logo-alcaldia {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: contain;

    border-radius: 50%;
}


        /* =====================================================
           CONTENEDOR DEL MENÚ
        ===================================================== */

        .menu-navegacion {
            padding: 13px 9px 25px;
        }


        /* =====================================================
           BOTONES DE MÓDULOS
        ===================================================== */

        .boton-modulo {
            width: 100%;

            display: flex;
            align-items: center;

            margin: 4px 0;
            padding: 12px 13px;

            color: #d4ddd7;

            background: transparent;

            border: 0;
            border-radius: 8px;

            text-align: left;

            font-size: 13px;
            font-weight: 700;

            transition: .2s;
        }

        .boton-modulo:hover {
            color: white;

            background:
                rgba(255,255,255,.07);
        }

        .boton-modulo.activo {
            color: white;

            background:
                rgba(8,113,47,.28);
        }

        .boton-modulo .icono-modulo {
            width: 28px;

            color: #58b877;

            font-size: 17px;
        }

        .boton-modulo .texto-modulo {
            flex: 1;
        }

        .flecha {
            font-size: 12px;

            transition:
                transform .25s ease;
        }

        .boton-modulo:not(.collapsed) .flecha {
            transform:
                rotate(90deg);
        }


        /* =====================================================
           SUBMENÚ
        ===================================================== */

        .submenu {
            margin:
                2px 0 7px;

            padding-left: 10px;
        }

        .submenu .nav-link {
            position: relative;

            display: flex;
            align-items: center;

            margin: 2px 0 2px 16px;

            padding: 9px 12px;

            color: #abb8af;

            border-radius: 7px;

            font-size: 13px;

            text-decoration: none;

            transition: .2s;
        }

        .submenu .nav-link::before {
            content: "";

            width: 5px;
            height: 5px;

            margin-right: 11px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #637269;
        }

        .submenu .nav-link:hover {
            color: white;

            background:
                rgba(255,255,255,.06);

            transform:
                translateX(2px);
        }

        .submenu .nav-link.active {
            color: white;

            background: #08712f;

            box-shadow:
                0 4px 10px rgba(0,0,0,.15);
        }

        .submenu .nav-link.active::before {
            background: white;
        }

        .submenu .nav-link i {
            width: 23px;

            margin-right: 5px;

            font-size: 14px;
        }


        /* =====================================================
           SEPARADORES
        ===================================================== */

        .separador-menu {
            height: 1px;

            margin: 9px 13px;

            background:
                rgba(255,255,255,.06);
        }


        /* =====================================================
           PARTE DERECHA
        ===================================================== */

        .pagina {
            margin-left: 270px;

            min-height: 100vh;
        }


        /* =====================================================
           BARRA SUPERIOR
        ===================================================== */

        .barra-superior {
            min-height: 65px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 25px;

            background-color: white;

            border-bottom:
                1px solid #dee2e6;

            box-shadow:
                0 2px 7px rgba(0,0,0,.03);
        }

        .titulo-superior {
            color: #26352b;
        }

        .titulo-superior i {
            color: #08712f;
        }


        /* =====================================================
           CONTENIDO
        ===================================================== */

        .contenido {
            padding: 25px;
        }

        .card {
            border: none;

            border-radius: 10px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .menu-lateral {
                width: 230px;
            }

            .pagina {
                margin-left: 230px;
            }

            .barra-superior {
                padding:
                    10px 15px;

                gap: 15px;
            }
        }

    </style>

    @stack('styles')

</head>


<body>


@php
    $solicitudesPendientes = 0;

    if (\Illuminate\Support\Facades\Schema::hasTable('solicitudes_contrasena')) {
        $solicitudesPendientes = \App\Models\SolicitudContrasena::where(
            'estado',
            'pendiente'
        )->count();
    }
@endphp


<!-- =========================================================
     MENÚ LATERAL
========================================================== -->

<aside class="menu-lateral">

    <!-- LOGO -->

<div class="logo">

    <div class="logo-icono">

        <img
            src="{{ asset('images/logo-gam-sacaba.png') }}"
            alt="GAM Sacaba"
            class="logo-alcaldia">

    </div>

    <div class="logo-texto">

        <h5>
            SIGECOM
        </h5>

        <small>
            Gestión y Control de Combustible
        </small>

    </div>

</div>


    <nav class="menu-navegacion">


        <!-- =================================================
             1. PRINCIPAL
        ================================================== -->

       <!-- =================================================
     1. PRINCIPAL
================================================== -->

<button
    class="boton-modulo {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#menuPrincipal"
    aria-expanded="{{ request()->routeIs('dashboard') ? 'true' : 'false' }}">

    <i class="bi bi-house-door icono-modulo"></i>

    <span class="texto-modulo">
        PRINCIPAL
    </span>

    <i class="bi bi-chevron-right flecha"></i>

</button>


<div
    class="collapse {{ request()->routeIs('dashboard') ? 'show' : '' }}"
    id="menuPrincipal">

    <div class="submenu">

        <a
            href="{{ route('dashboard') }}"
            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <i class="bi bi-speedometer2"></i>

            Dashboard

        </a>

    </div>

</div>


<div class="separador-menu"></div>

        <div class="separador-menu"></div>


        <!-- =================================================
             2. SEGURIDAD Y ADMINISTRACIÓN
        ================================================== -->

        <button
            class="boton-modulo {{ request()->routeIs('usuarios.*', 'roles.*') ? '' : 'collapsed' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuSeguridad"
            aria-expanded="{{ request()->routeIs('usuarios.*', 'roles.*') ? 'true' : 'false' }}">

            <i class="bi bi-shield-lock icono-modulo"></i>

            <span class="texto-modulo">
                SEGURIDAD
            </span>

            <i class="bi bi-chevron-right flecha"></i>

        </button>


        <div
            class="collapse {{ request()->routeIs('usuarios.*', 'roles.*') ? 'show' : '' }}"
            id="menuSeguridad">

            <div class="submenu">

                <a
                    href="{{ route('usuarios.index') }}"
                    class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">

                    <i class="bi bi-people"></i>

                    Usuarios

                </a>


                <a
                    href="{{ route('roles.index') }}"
                    class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">

                    <i class="bi bi-person-badge"></i>

                    Roles

                </a>

            </div>

        </div>


        <div class="separador-menu"></div>


        <!-- =================================================
             3. PARQUE AUTOMOTOR
        ================================================== -->

        <button
            class="boton-modulo {{ request()->routeIs('vehiculos.*', 'unidades.*') ? '' : 'collapsed' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuParque"
            aria-expanded="{{ request()->routeIs('vehiculos.*', 'unidades.*') ? 'true' : 'false' }}">

            <i class="bi bi-car-front-fill icono-modulo"></i>

            <span class="texto-modulo">
                PARQUE AUTOMOTOR
            </span>

            <i class="bi bi-chevron-right flecha"></i>

        </button>


        <div
            class="collapse {{ request()->routeIs('vehiculos.*', 'unidades.*') ? 'show' : '' }}"
            id="menuParque">

            <div class="submenu">

                <a
                    href="{{ route('vehiculos.index') }}"
                    class="nav-link {{ request()->routeIs('vehiculos.*') ? 'active' : '' }}">

                    <i class="bi bi-car-front"></i>

                    Vehículos

                </a>


                <a
                    href="{{ route('unidades.index') }}"
                    class="nav-link {{ request()->routeIs('unidades.*') ? 'active' : '' }}">

                    <i class="bi bi-building"></i>

                    Unidades

                </a>

            </div>

        </div>


        <div class="separador-menu"></div>


        <!-- =================================================
             4. GESTIÓN DE COMBUSTIBLE
        ================================================== -->

        <button
            class="boton-modulo {{ request()->routeIs('lotes-vales.*', 'vales-combustible.*') ? '' : 'collapsed' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuCombustible"
            aria-expanded="{{ request()->routeIs('lotes-vales.*', 'vales-combustible.*') ? 'true' : 'false' }}">

            <i class="bi bi-fuel-pump-fill icono-modulo"></i>

            <span class="texto-modulo">
                COMBUSTIBLE
            </span>

            <i class="bi bi-chevron-right flecha"></i>

        </button>


        <div
            class="collapse {{ request()->routeIs('lotes-vales.*', 'vales-combustible.*') ? 'show' : '' }}"
            id="menuCombustible">

            <div class="submenu">

                <a
                    href="{{ route('lotes-vales.index') }}"
                    class="nav-link {{ request()->routeIs('lotes-vales.*') ? 'active' : '' }}">

                    <i class="bi bi-collection"></i>

                    Lotes de vales

                </a>


                <a
                    href="{{ route('vales-combustible.index') }}"
                    class="nav-link {{ request()->routeIs('vales-combustible.*') ? 'active' : '' }}">

                    <i class="bi bi-ticket-perforated"></i>

                    Vales de combustible

                </a>

            </div>

        </div>


        <div class="separador-menu"></div>


        <!-- =================================================
             5. CONFIGURACIÓN
        ================================================== -->

        <button
            class="boton-modulo {{
                request()->routeIs(
                    'periodos.*',
                    'tipos-combustible.*',
                    'estaciones-servicio.*',
                    'aperturas-programaticas.*',
                    'fuentes-financiamiento.*',
                    'organismos-financiadores.*'
                ) ? '' : 'collapsed'
            }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuConfiguracion">

            <i class="bi bi-gear-fill icono-modulo"></i>

            <span class="texto-modulo">
                CONFIGURACIÓN
            </span>

            <i class="bi bi-chevron-right flecha"></i>

        </button>


        <div
            class="collapse {{
                request()->routeIs(
                    'periodos.*',
                    'tipos-combustible.*',
                    'estaciones-servicio.*',
                    'aperturas-programaticas.*',
                    'fuentes-financiamiento.*',
                    'organismos-financiadores.*'
                ) ? 'show' : ''
            }}"
            id="menuConfiguracion">

            <div class="submenu">

                <a
                    href="{{ route('periodos.index') }}"
                    class="nav-link {{ request()->routeIs('periodos.*') ? 'active' : '' }}">

                    <i class="bi bi-calendar3"></i>

                    Periodos

                </a>


                <a
                    href="{{ route('tipos-combustible.index') }}"
                    class="nav-link {{ request()->routeIs('tipos-combustible.*') ? 'active' : '' }}">

                    <i class="bi bi-droplet-fill"></i>

                    Tipos de combustible

                </a>


                <a
                    href="{{ route('estaciones-servicio.index') }}"
                    class="nav-link {{ request()->routeIs('estaciones-servicio.*') ? 'active' : '' }}">

                    <i class="bi bi-geo-alt"></i>

                    Estaciones de servicio

                </a>


                <a
                    href="{{ route('aperturas-programaticas.index') }}"
                    class="nav-link {{ request()->routeIs('aperturas-programaticas.*') ? 'active' : '' }}">

                    <i class="bi bi-diagram-3"></i>

                    Aperturas programáticas

                </a>


                <a
                    href="{{ route('fuentes-financiamiento.index') }}"
                    class="nav-link {{ request()->routeIs('fuentes-financiamiento.*') ? 'active' : '' }}">

                    <i class="bi bi-cash-stack"></i>

                    Fuentes de financiamiento

                </a>


                <a
                    href="{{ route('organismos-financiadores.index') }}"
                    class="nav-link {{ request()->routeIs('organismos-financiadores.*') ? 'active' : '' }}">

                    <i class="bi bi-bank"></i>

                    Organismos financiadores

                </a>

            </div>

        </div>


        <div class="separador-menu"></div>


        <!-- =================================================
             6. REPORTES
             Visual por ahora. No inventamos rutas.
        ================================================== -->

        <button
            class="boton-modulo collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuReportes"
            aria-expanded="false">

            <i class="bi bi-bar-chart-fill icono-modulo"></i>

            <span class="texto-modulo">
                REPORTES
            </span>

            <i class="bi bi-chevron-right flecha"></i>

        </button>


        <div
            class="collapse"
            id="menuReportes">

            <div class="submenu">

                <a
                     href="{{ route('reportes.consumo') }}">

                    <i class="bi bi-file-earmark-bar-graph"></i>

                    Reportes de consumo

                </a>

            </div>

        </div>


        <div class="separador-menu"></div>


        <!-- =================================================
             7. AUDITORÍA
             Visual por ahora. No inventamos rutas.
        ================================================== -->

        <button
            class="boton-modulo collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuAuditoria"
            aria-expanded="false">

            <i class="bi bi-shield-check icono-modulo"></i>

            <span class="texto-modulo">
                AUDITORÍA
            </span>

            <i class="bi bi-chevron-right flecha"></i>

        </button>


        <div
            class="collapse"
            id="menuAuditoria">

            <div class="submenu">

                <a
                    href="#"
                    class="nav-link">

                    <i class="bi bi-clock-history"></i>

                    Registro de actividades

                </a>

            </div>

        </div>


    </nav>

</aside>


<!-- =========================================================
     CONTENIDO PRINCIPAL
========================================================== -->

<div class="pagina">


    <!-- BARRA SUPERIOR -->

    <header class="barra-superior">

        <div class="titulo-superior">

            <i class="bi bi-fuel-pump-fill me-2"></i>

            <strong>
                Gestión de Provisión de Combustible
            </strong>

        </div>


        <div class="d-flex align-items-center gap-3">

    {{-- SOLICITUDES DE CONTRASEÑA --}}
    <a
        href="{{ route('solicitudes-contrasena.index') }}"
        class="position-relative text-decoration-none text-dark"
        title="Solicitudes de contraseña">

        <i class="bi bi-bell-fill fs-5"></i>

        @if($solicitudesPendientes > 0)

            <span
                class="position-absolute top-0 start-100 translate-middle
                       badge rounded-pill bg-danger">

                {{ $solicitudesPendientes }}

            </span>

        @endif

    </a>


    {{-- USUARIO AUTENTICADO --}}
    <div>

        <i class="bi bi-person-circle me-1"></i>

        {{ auth()->user()->nombre }}
        {{ auth()->user()->apellido }}

    </div>


    {{-- CERRAR SESIÓN --}}
    <form
        action="{{ route('logout') }}"
        method="POST"
        class="m-0">

        @csrf

        <button
            type="submit"
            class="btn btn-outline-danger btn-sm">

            <i class="bi bi-box-arrow-right me-1"></i>

            Cerrar sesión

        </button>

    </form>

</div>

    </header>


    <!-- =====================================================
         CONTENIDO
    ====================================================== -->

    <main class="contenido">


        <!-- MENSAJE CORRECTO -->

        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle me-1"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- MENSAJE ERROR -->

        @if(session('error'))

            <div
                class="alert alert-danger alert-dismissible fade show">

                <i class="bi bi-exclamation-circle me-1"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- AQUÍ ENTRA CADA VISTA -->

        @yield('content')


    </main>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

@stack('scripts')


</body>

</html>