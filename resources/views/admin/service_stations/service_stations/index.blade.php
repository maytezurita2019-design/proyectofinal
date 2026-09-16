@extends('adminlte::page')

@section('title', 'Estaciones de Servicio')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Estaciones de Servicio</h1>

    <a
        href="{{ route('service-stations.create') }}"
        class="btn btn-primary">

        Nueva Estación

    </a>

</div>

@stop


@section('content')

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


<div class="card">

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Estado</th>
                </tr>

            </thead>

            <tbody>

                @foreach($stations as $station)

                    <tr>

                        <td>
                            {{ $station->name }}
                        </td>

                        <td>
                            {{ $station->address }}
                        </td>

                        <td>
                            {{ $station->latitude }}
                        </td>

                        <td>
                            {{ $station->longitude }}
                        </td>

                        <td>

                            @if($station->status)

                                <span class="badge badge-success">
                                    Activa
                                </span>

                            @else

                                <span class="badge badge-danger">
                                    Inactiva
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@stop