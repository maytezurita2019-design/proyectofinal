@props(['titulo', 'datos', 'unidad' => 'L'])
<article class="card h-100"><div class="card-header"><h3 class="card-title">{{ $titulo }}</h3><span class="small text-secondary">Datos de ejemplo · {{ $unidad }}</span></div><div class="card-body">
@foreach($datos as $etiqueta => $valor)
<div class="mb-3"><div class="d-flex justify-content-between small mb-1 gap-2"><span>{{ $etiqueta }}</span><strong>{{ number_format($valor, 0, ',', '.') }} {{ $unidad }}</strong></div><div class="barra-fondo" aria-hidden="true"><div class="barra-valor" style="width: {{ $valor / max($datos) * 100 }}%"></div></div></div>
@endforeach
</div></article>
