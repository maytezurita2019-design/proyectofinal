<?php

namespace App\Http\Controllers;

use App\Models\ValeCombustible;
use App\Models\Vehiculo;
use App\Models\Unidad;
use App\Models\Periodo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function consumo(Request $request)
    {
        $consulta = ValeCombustible::with([
            'vehiculo.unidad',
            'loteVale.tipoCombustible',
            'loteVale.estacionServicio',
            'aperturaProgramatica',
            'usuario'
        ]);

        // Filtro por fecha inicial
        if ($request->filled('fecha_inicio')) {
            $consulta->whereDate(
                'fecha',
                '>=',
                $request->fecha_inicio
            );
        }

        // Filtro por fecha final
        if ($request->filled('fecha_fin')) {
            $consulta->whereDate(
                'fecha',
                '<=',
                $request->fecha_fin
            );
        }

        // Filtro por vehículo
        if ($request->filled('vehiculo_id')) {
            $consulta->where(
                'vehiculo_id',
                $request->vehiculo_id
            );
        }

        // Filtro por unidad
        if ($request->filled('unidad_id')) {
            $consulta->whereHas('vehiculo', function ($query) use ($request) {
                $query->where(
                    'unidad_id',
                    $request->unidad_id
                );
            });
        }

        // Filtro por período
        if ($request->filled('periodo_id')) {
            $consulta->whereHas('loteVale', function ($query) use ($request) {
                $query->where(
                    'periodo_id',
                    $request->periodo_id
                );
            });
        }

        $vales = $consulta
            ->orderByDesc('fecha')
            ->orderByDesc('numero_vale')
            ->get();

        // Totales del resultado filtrado
        $totalVales = $vales->count();
        $totalLitros = $vales->sum('cantidad_litros');
        $totalMonto = $vales->sum('total');

        // Datos para los desplegables
        $vehiculos = Vehiculo::orderBy('codigo')->get();
        $unidades = Unidad::orderBy('nombre')->get();
        $periodos = Periodo::orderByDesc('anio')
            ->orderByDesc('mes')
            ->get();

        return view('reportes.consumo', compact(
            'vales',
            'vehiculos',
            'unidades',
            'periodos',
            'totalVales',
            'totalLitros',
            'totalMonto'
        ));
    }
}