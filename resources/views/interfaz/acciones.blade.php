@php
    $consulta = $modulo === 'reportes' || $seccion === 'auditoria';
    $policia = $modulo === 'combustible' && $seccion === 'policia';
    $campos = config('prototipo.campos.'.($policia ? 'vales' : $seccion), ['codigo' => ['Código', 'text'], 'nombre' => ['Descripción', 'text']]);
    if ($consulta) $campos = ['fecha' => ['Fecha', 'date'], 'vehiculo' => ['Vehículo', 'vehiculo'], 'combustible' => ['Tipo de combustible', 'combustible'], 'litros' => ['Litros', 'number']];
    if ($seccion === 'auditoria') $campos = ['fecha' => ['Fecha', 'date'], 'usuario' => ['Usuario', 'text'], 'accion' => ['Acción', 'text']];
@endphp
<div id="prototipo" data-consulta="{{ $consulta ? '1' : '0' }}" data-anulable="{{ $modulo === 'combustible' ? '1' : '0' }}">
    <script type="application/json" id="datos-prototipo">{!! json_encode(['campos' => $campos, 'opciones' => config('prototipo.opciones'), 'ejemplos' => config('prototipo.ejemplos.'.$seccion, []), 'policia' => $policia], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    <p class="small text-secondary">Campos provisionales para revisión. Los cambios se reinician al salir o recargar esta pantalla.</p>
    <div id="mensaje" class="alert alert-info" role="status" hidden></div>
    @if($policia)
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" data-nuevo>Asignar vale</button>
        <a class="btn btn-outline-primary" href="{{ route('interfaz.seccion', ['combustible', 'cargas-combustible']) }}">Registrar carga</a>
        <a class="btn btn-outline-primary" href="{{ route('interfaz.seccion', ['reportes', 'policia']) }}">Consultar consumos</a>
    </div>
    @endif
    <section class="card mb-3"><div class="card-body">
        <form id="filtros" class="row g-3 align-items-end">
            <div class="col-12 col-md-4"><label for="buscar" class="form-label">Buscar en el listado</label><input id="buscar" class="form-control" type="search" placeholder="Escriba un código o descripción"></div>
            @if($consulta || $policia)
            <div class="col-6 col-md-2"><label for="fecha-inicial" class="form-label">Fecha inicial</label><input id="fecha-inicial" name="desde" type="date" class="form-control"></div>
            <div class="col-6 col-md-2"><label for="fecha-final" class="form-label">Fecha final</label><input id="fecha-final" name="hasta" type="date" class="form-control"></div>
            @foreach(['vehiculo' => 'Vehículo', 'apertura' => 'Apertura Programática', 'fuente' => 'Fuente de Financiamiento', 'organismo' => 'Organismo Financiador', 'combustible' => 'Tipo de combustible'] as $clave => $etiqueta)
            <div class="col-12 col-md-4"><label for="filtro-{{ $clave }}" class="form-label">{{ $etiqueta }}</label><select id="filtro-{{ $clave }}" name="{{ $clave }}" class="form-select"><option value="">Todos</option>@foreach(config('prototipo.opciones.'.$clave) as $opcion)<option>{{ $opcion }}</option>@endforeach</select></div>
            @endforeach
            @endif
            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-primary" type="submit">{{ $consulta ? 'Consultar' : 'Buscar' }}</button>
                <button class="btn btn-outline-secondary" type="reset">Limpiar filtros</button>
                @unless($consulta || $policia)<button class="btn btn-primary ms-sm-auto" type="button" data-nuevo><i class="bi bi-plus-lg" aria-hidden="true"></i> Nuevo</button>@endunless
                @if($modulo === 'reportes')
                <button class="btn btn-outline-danger" type="button" data-salida="PDF">Generar PDF</button>
                <button class="btn btn-outline-success" type="button" data-salida="Excel">Exportar Excel</button>
                <button class="btn btn-outline-secondary" type="button" data-salida="impresión">Imprimir</button>
                @endif
            </div>
        </form>
    </div></section>
    <section id="editor" class="card mb-3" hidden aria-labelledby="titulo-editor">
        <div class="card-header"><h2 id="titulo-editor" class="card-title">Nuevo registro</h2></div>
        <div class="card-body"><form id="formulario" class="row g-3" lang="es">
            @foreach($campos as $clave => [$etiqueta, $tipo])
            <div class="col-12 col-md-6"><label for="campo-{{ $clave }}" class="form-label">{{ $etiqueta }} <span aria-hidden="true">*</span></label>
                @if(config('prototipo.opciones.'.$tipo))
                <select id="campo-{{ $clave }}" name="{{ $clave }}" class="form-select" required><option value="">Seleccione una opción</option>@foreach(config('prototipo.opciones.'.$tipo) as $opcion)<option>{{ $opcion }}</option>@endforeach</select>
                @else
                <input id="campo-{{ $clave }}" name="{{ $clave }}" class="form-control" type="{{ $tipo }}" required @if($tipo === 'number') min="0.01" step="0.01" @endif maxlength="160">
                @endif
            </div>
            @endforeach

            @if($seccion === 'estaciones-servicio')

<div class="col-12">
    <hr>

    <h5>Ubicación de la estación</h5>

    <div class="row g-3">

        <div class="col-12 col-md-8">
            <label for="buscar-ubicacion" class="form-label">
                Buscar ubicación
            </label>

            <input
                type="text"
                id="buscar-ubicacion"
                class="form-control"
                placeholder="Ej: estación de servicio Sacaba, Cochabamba"
            >
        </div>

        <div class="col-12 col-md-4 d-flex align-items-end">
            <button
                type="button"
                id="btn-buscar-ubicacion"
                class="btn btn-primary w-100"
            >
                Buscar ubicación
            </button>
        </div>

        <div class="col-12">
            <div id="resultados-ubicacion"></div>
        </div>

        <div class="col-12">
           
            <div
                id="mapa-estacion"
                style="height: 420px; width: 100%; border-radius: 8px;"
            ></div>
        </div>

        <div class="col-12 col-md-6">
            <label class="form-label">Latitud</label>

            <input
                type="text"
                id="latitude"
                name="latitude"
                class="form-control"
                readonly
            >
        </div>

        <div class="col-12 col-md-6">
            <label class="form-label">Longitud</label>

            <input
                type="text"
                id="longitude"
                name="longitude"
                class="form-control"
                readonly
            >
        </div>

    </div>

</div>

@endif

            @if(isset($campos['vehiculo']))<div class="col-12"><div id="datos-vehiculo" class="aviso-demo" aria-live="polite">Seleccione un vehículo para ver sus datos relacionados.</div></div>@endif
            <div class="col-12 small text-secondary">* Campos obligatorios del formulario de ejemplo.</div>
            <div class="col-12 d-flex gap-2"><button class="btn btn-primary" type="submit">Guardar</button><button id="cancelar" class="btn btn-outline-secondary" type="button">Cancelar</button></div>
        </form></div>
    </section>
    <section class="card"><div class="card-header"><h2 class="card-title">{{ $consulta ? 'Resultados de ejemplo' : 'Listado de registros' }}</h2></div>
        <div class="table-responsive"><table class="table table-hover align-middle mb-0"><caption class="px-3">{{ $titulo }} · datos ficticios</caption><thead><tr>@foreach($campos as [$etiqueta])<th scope="col">{{ $etiqueta }}</th>@endforeach<th scope="col">Estado</th><th scope="col">Acciones</th></tr></thead><tbody id="filas"></tbody></table></div>
        <div class="card-footer d-flex flex-wrap align-items-center justify-content-between gap-2"><span id="resumen" role="status" class="small"></span><nav aria-label="Paginación del listado" class="d-flex gap-2"><button id="anterior" type="button" class="btn btn-sm btn-outline-secondary">Anterior</button><button id="siguiente" type="button" class="btn btn-sm btn-outline-secondary">Siguiente</button></nav></div>
    </section>
    <dialog id="confirmacion" aria-labelledby="titulo-confirmacion"><h2 id="titulo-confirmacion" class="h5">Confirmar cambio de estado</h2><p id="texto-confirmacion"></p><div class="d-flex gap-2"><button id="confirmar" type="button" class="btn btn-primary">Confirmar</button><button id="cerrar-confirmacion" type="button" class="btn btn-outline-secondary">Cancelar</button></div></dialog>
    <dialog id="detalle" aria-labelledby="titulo-detalle"><h2 id="titulo-detalle" class="h5">Detalle del registro</h2><dl id="contenido-detalle"></dl><button id="cerrar-detalle" class="btn btn-secondary" type="button">Cerrar</button></dialog>
</div>


@if($seccion === 'estaciones-servicio')

@push('js')

<script>
    let mapaGoogle;
    let marcadorGoogle;

    function iniciarGoogleMaps() {

        const contenedor = document.getElementById('mapa-estacion');

        if (!contenedor) {
            return;
        }

        const centroInicial = {
            lat: -17.40,
            lng: -66.04
        };

        mapaGoogle = new google.maps.Map(contenedor, {
            center: centroInicial,
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
        });

        mapaGoogle.addListener('click', function(evento) {

            const lat = evento.latLng.lat();
            const lng = evento.latLng.lng();

            colocarMarcadorGoogle(lat, lng);
        });
    }

    function colocarMarcadorGoogle(lat, lng) {

        const posicion = {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        };

        document.getElementById('latitude').value =
            posicion.lat.toFixed(7);

        document.getElementById('longitude').value =
            posicion.lng.toFixed(7);

        if (marcadorGoogle) {
            marcadorGoogle.setPosition(posicion);
        } else {
            marcadorGoogle = new google.maps.Marker({
                position: posicion,
                map: mapaGoogle,
                draggable: true
            });

            marcadorGoogle.addListener('dragend', function(evento) {

                document.getElementById('latitude').value =
                    evento.latLng.lat().toFixed(7);

                document.getElementById('longitude').value =
                    evento.latLng.lng().toFixed(7);
            });
        }

        mapaGoogle.setCenter(posicion);
        mapaGoogle.setZoom(17);
    }
</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=iniciarGoogleMaps"
    async
    defer>
</script>

@endpush

@endif

@push('js')
<script src="{{ asset('js/prototipo.js') }}" defer></script>
@endpush
