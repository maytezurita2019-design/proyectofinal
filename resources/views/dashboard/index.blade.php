@extends('layouts.institucional')

@section('contenido')
<section class="card mb-4" aria-labelledby="titulo-filtros">
    <div class="card-header"><h2 class="card-title" id="titulo-filtros">Periodo y criterios de consulta</h2></div>
    <div class="card-body">
        <p class="small text-secondary">Filtros de referencia visual. Los indicadores muestran un ejemplo fijo de enero a junio de 2026.</p>
        <form id="filtros-dashboard" class="row g-3">
            <div class="col-6 col-lg-2"><label for="desde" class="form-label">Desde</label><input id="desde" type="date" class="form-control" value="2026-01-01"></div>
            <div class="col-6 col-lg-2"><label for="hasta" class="form-label">Hasta</label><input id="hasta" type="date" class="form-control" value="2026-06-30"></div>
            <div class="col-12 col-lg-3"><label for="vehiculo" class="form-label">Vehículo</label><select id="vehiculo" class="form-select"><option>Todos los vehículos</option><option>C-29 | 3992NII</option><option>C-30 | 4821ABC</option><option>M-12 | 2536XYZ</option></select></div>
            <div class="col-12 col-lg-2"><label for="combustible" class="form-label">Tipo de combustible</label><select id="combustible" class="form-select"><option>Todos los tipos</option><option>Gasolina</option><option>Diésel</option></select></div>
            <div class="col-12 col-lg-3"><label for="apertura" class="form-label">Apertura Programática</label><select id="apertura" class="form-select"><option>Todas las aperturas</option><option>Administración central</option><option>Mantenimiento vial</option><option>Seguridad ciudadana</option></select></div>
            <div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-primary">Aplicar filtros</button><button type="reset" class="btn btn-outline-secondary">Limpiar filtros</button></div>
            <div id="mensaje-dashboard" class="col-12 small text-secondary" role="status"></div>
        </form>
    </div>
</section>
<section id="indicadores" aria-labelledby="titulo-indicadores" class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3"><h2 id="titulo-indicadores" class="h5 mb-0">Indicadores generales</h2><span class="small text-secondary">Enero – junio 2026</span></div>
    <div class="row g-3">
        <x-indicador titulo="Vales emitidos" valor="360" icono="bi bi-ticket-perforated" detalle="Total del periodo de ejemplo" />
        <x-indicador titulo="Cargas registradas" valor="280" icono="bi bi-fuel-pump" detalle="Movimientos de provisión de ejemplo" />
        <x-indicador titulo="Litros consumidos" valor="12.480 L" icono="bi bi-droplet" detalle="Gasolina y diésel" />
        <x-indicador titulo="Monto total de combustible" valor="Bs 46.550,40" icono="bi bi-cash-stack" detalle="Importe ficticio para revisión visual" />
        <x-indicador titulo="Vehículos registrados" valor="48" icono="bi bi-truck" detalle="Parque automotor de ejemplo" />
        <x-indicador titulo="Estado de vales" valor="360 vales" icono="bi bi-check2-square" detalle="60 disponibles · 20 anulados · 280 utilizados" />
    </div>
</section>
<section id="graficos" aria-labelledby="titulo-graficos" class="pb-4">
    <h2 id="titulo-graficos" class="h5 mb-3">Distribución del consumo</h2>
    <div class="row g-4">
        <div class="col-12 col-xl-6"><x-grafico-barras titulo="Consumo mensual" :datos="['Enero' => 1800, 'Febrero' => 1920, 'Marzo' => 2160, 'Abril' => 2040, 'Mayo' => 2280, 'Junio' => 2280]" /></div>
        <div class="col-12 col-xl-6"><x-grafico-barras titulo="Consumo por tipo de combustible" :datos="['Diésel' => 7800, 'Gasolina' => 4680]" /></div>
        <div class="col-12 col-xl-6"><x-grafico-barras titulo="Consumo por vehículo" :datos="['C-29 | 3992NII' => 2400, 'C-30 | 4821ABC' => 1920, 'M-12 | 2536XYZ' => 1560, 'Otros vehículos' => 6600]" /></div>
        <div class="col-12 col-xl-6"><x-grafico-barras titulo="Consumo por Apertura Programática" :datos="['Administración central' => 3480, 'Mantenimiento vial' => 6240, 'Seguridad ciudadana' => 2760]" /></div>
    </div>
</section>
@stop
@push('js')
<script>
document.getElementById('filtros-dashboard').addEventListener('submit', function (event) {
    event.preventDefault();
    const desde = document.getElementById('desde').value;
    const hasta = document.getElementById('hasta').value;
    document.getElementById('mensaje-dashboard').textContent = desde && hasta && desde > hasta
        ? 'La fecha inicial no puede ser posterior a la fecha final.'
        : 'Criterios seleccionados para revisión. Los indicadores y gráficos conservan los datos fijos de ejemplo; el cálculo se incorporará en una fase posterior.';
});
document.getElementById('filtros-dashboard').addEventListener('reset', function () {
    document.getElementById('mensaje-dashboard').textContent = 'Filtros restablecidos al periodo de ejemplo.';
});
</script>
@endpush
