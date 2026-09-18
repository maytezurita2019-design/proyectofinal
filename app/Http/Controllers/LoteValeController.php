<?php

namespace App\Http\Controllers;

use App\Models\LoteVale;
use App\Models\Periodo;
use App\Models\TipoCombustible;
use App\Models\EstacionServicio;
use Illuminate\Http\Request;

class LoteValeController extends Controller
{
    public function index()
    {
        $lotes = LoteVale::with([
            'periodo',
            'tipoCombustible',
            'estacionServicio'
        ])->orderByDesc('fecha_recepcion')->get();

        return view('lotes_vales.index', compact('lotes'));
    }

    public function create()
    {
        $periodos = Periodo::where('estado', true)->get();
        $tiposCombustible = TipoCombustible::where('estado', true)->get();
        $estaciones = EstacionServicio::where('estado', true)->get();

        return view(
            'lotes_vales.create',
            compact('periodos', 'tiposCombustible', 'estaciones')
        );
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'numero_inicial' => 'required|integer|min:1',
            'numero_final' => 'required|integer|gte:numero_inicial',
            'fecha_recepcion' => 'required|date',
            'periodo_id' => 'required|exists:periodos,id',
            'tipo_combustible_id' => 'required|exists:tipos_combustible,id',
            'estacion_servicio_id' => 'required|exists:estaciones_servicio,id',
            'estado' => 'required|boolean',
        ]);

        LoteVale::create($datos);

        return redirect()->route('lotes-vales.index')
            ->with('success', 'Lote de vales registrado correctamente.');
    }

    public function show(LoteVale $loteVale)
    {
        $loteVale->load([
            'periodo',
            'tipoCombustible',
            'estacionServicio'
        ]);

        return view('lotes_vales.show', compact('loteVale'));
    }

    public function edit(LoteVale $loteVale)
    {
        $periodos = Periodo::where('estado', true)->get();
        $tiposCombustible = TipoCombustible::where('estado', true)->get();
        $estaciones = EstacionServicio::where('estado', true)->get();

        return view(
            'lotes_vales.edit',
            compact(
                'loteVale',
                'periodos',
                'tiposCombustible',
                'estaciones'
            )
        );
    }

    public function update(Request $request, LoteVale $loteVale)
    {
        $datos = $request->validate([
            'numero_inicial' => 'required|integer|min:1',
            'numero_final' => 'required|integer|gte:numero_inicial',
            'fecha_recepcion' => 'required|date',
            'periodo_id' => 'required|exists:periodos,id',
            'tipo_combustible_id' => 'required|exists:tipos_combustible,id',
            'estacion_servicio_id' => 'required|exists:estaciones_servicio,id',
            'estado' => 'required|boolean',
        ]);

        $loteVale->update($datos);

        return redirect()->route('lotes-vales.index')
            ->with('success', 'Lote de vales actualizado correctamente.');
    }

    public function destroy(LoteVale $loteVale)
    {
        if ($loteVale->valesCombustible()->exists()) {
            return redirect()->route('lotes-vales.index')
                ->with('error', 'No se puede eliminar porque contiene vales registrados.');
        }

        $loteVale->delete();

        return redirect()->route('lotes-vales.index')
            ->with('success', 'Lote de vales eliminado correctamente.');
    }
}