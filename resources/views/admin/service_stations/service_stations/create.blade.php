@extends('adminlte::page')

@section('title', 'Nueva Estación')

@section('content_header')
    <h1>Nueva Estación de Servicio</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('service-stations.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre de la estación</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Buscar ubicación</label>

                <div class="input-group">

                    <input
                        type="text"
                        id="search"
                        class="form-control"
                        placeholder="Ej: estación de servicio Sacaba"
                    >

                    <div class="input-group-append">
                        <button
                            type="button"
                            id="btnSearch"
                            class="btn btn-primary">
                            Buscar
                        </button>
                    </div>

                </div>
            </div>

            <div id="results" class="mb-3"></div>

            <div class="form-group">
                <label>Dirección</label>

                <input
                    type="text"
                    id="address"
                    name="address"
                    class="form-control"
                    value="{{ old('address') }}"
                >
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Latitud</label>

                        <input
                            type="text"
                            id="latitude"
                            name="latitude"
                            class="form-control"
                            readonly
                            required
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Longitud</label>

                        <input
                            type="text"
                            id="longitude"
                            name="longitude"
                            class="form-control"
                            readonly
                            required
                        >
                    </div>
                </div>

            </div>

            <div id="map" style="height: 420px;"></div>

            <br>

            <button type="submit" class="btn btn-success">
                Guardar Estación
            </button>

            <a
                href="{{ route('service-stations.index') }}"
                class="btn btn-secondary">
                Cancelar
            </a>

        </form>

    </div>
</div>

@stop


@section('css')

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

@stop


@section('js')

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

<script>

const map = L.map('map').setView(
    [-17.40, -66.04],
    13
);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }
).addTo(map);


let marker = null;


function selectLocation(lat, lon, address)
{
    lat = parseFloat(lat);
    lon = parseFloat(lon);

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lon;
    document.getElementById('address').value = address;

    if (marker) {
        map.removeLayer(marker);
    }

    marker = L.marker(
        [lat, lon],
        {
            draggable: true
        }
    ).addTo(map);

    map.setView([lat, lon], 17);

    marker.on('dragend', function () {

        const position = marker.getLatLng();

        document.getElementById('latitude').value =
            position.lat.toFixed(7);

        document.getElementById('longitude').value =
            position.lng.toFixed(7);
    });
}


document
    .getElementById('btnSearch')
    .addEventListener('click', async function () {

        const query =
            document.getElementById('search').value.trim();

        if (!query) {
            alert('Escriba una ubicación.');
            return;
        }

        const button = this;

        button.disabled = true;
        button.innerText = 'Buscando...';

        try {

            const url =
                "{{ route('service-stations.search-location') }}"
                + "?query="
                + encodeURIComponent(query);

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Error al consultar ubicación');
            }

            const data = await response.json();

            const results =
                document.getElementById('results');

            results.innerHTML = '';

            if (!data.length) {

                results.innerHTML =
                    '<div class="alert alert-warning">'
                    + 'No se encontraron ubicaciones.'
                    + '</div>';

                return;
            }

            data.forEach(function (place) {

                const item =
                    document.createElement('button');

                item.type = 'button';

                item.className =
                    'btn btn-outline-secondary btn-block text-left mb-1';

                item.textContent =
                    place.display_name;

                item.addEventListener(
                    'click',
                    function () {

                        selectLocation(
                            place.lat,
                            place.lon,
                            place.display_name
                        );

                        results.innerHTML = '';
                    }
                );

                results.appendChild(item);
            });

        } catch (error) {

            alert(
                'No se pudo consultar el servicio de geolocalización.'
            );

        } finally {

            button.disabled = false;
            button.innerText = 'Buscar';
        }

    });


map.on('click', function (event) {

    selectLocation(
        event.latlng.lat,
        event.latlng.lng,
        document.getElementById('address').value
    );

});

</script>

@stop