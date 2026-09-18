<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\ValeCombustible;
use App\Models\LoteVale;
use App\Models\Usuario;

class DashboardController extends Controller
{
    public function index()
    {
        // VEHÍCULOS ACTIVOS
        $vehiculosActivos = Vehiculo::where('estado', true)->count();


        // TOTAL DE VALES REGISTRADOS
        $totalVales = ValeCombustible::count();


        // TOTAL DE LITROS REGISTRADOS
        $totalLitros = ValeCombustible::sum('cantidad_litros');


        // TOTAL CONSUMIDO EN BOLIVIANOS
        $totalConsumido = ValeCombustible::sum('total');


        // LOTES ACTIVOS
        $lotesActivos = LoteVale::where('estado', true)->count();


        // USUARIOS ACTIVOS
        $usuariosActivos = Usuario::where('estado', true)->count();


        // ==========================================
        // ÚLTIMOS 5 VALES REGISTRADOS
        // ==========================================

        $ultimosVales = ValeCombustible::with('vehiculo')
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->limit(5)
            ->get();


        // ==========================================
        // CONSUMO MENSUAL DEL AÑO ACTUAL
        // ==========================================

        $anioActual = now()->year;


        $consumoMensualBD = ValeCombustible::selectRaw(
            'EXTRACT(MONTH FROM fecha)::integer AS mes,
             SUM(cantidad_litros) AS litros'
        )
            ->whereYear('fecha', $anioActual)
            ->groupByRaw('EXTRACT(MONTH FROM fecha)')
            ->orderByRaw('EXTRACT(MONTH FROM fecha)')
            ->get()
            ->keyBy('mes');


        // MESES PARA EL GRÁFICO

        $meses = [
            'Ene',
            'Feb',
            'Mar',
            'Abr',
            'May',
            'Jun',
            'Jul',
            'Ago',
            'Sep',
            'Oct',
            'Nov',
            'Dic',
        ];


        // CONSUMO DE CADA MES

        $consumoMensual = [];

        for ($mes = 1; $mes <= 12; $mes++) {

            $consumoMensual[] = isset($consumoMensualBD[$mes])
                ? (float) $consumoMensualBD[$mes]->litros
                : 0;
        }


        // ==========================================
        // ENVIAR DATOS AL DASHBOARD
        // ==========================================

        return view('dashboard.index', compact(
            'vehiculosActivos',
            'totalVales',
            'totalLitros',
            'totalConsumido',
            'lotesActivos',
            'usuariosActivos',
            'ultimosVales',
            'anioActual',
            'meses',
            'consumoMensual'
        ));
    }
}