<?php

namespace App\Http\Controllers;

use App\Models\ValeCombustible;
use App\Models\LoteVale;
use App\Models\Vehiculo;
use App\Models\AperturaProgramatica;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ValeCombustibleController extends Controller
{
    public function index()
    {
        $vales = ValeCombustible::with([
            'loteVale.tipoCombustible',
            'vehiculo.unidad',
            'aperturaProgramatica',
            'usuario'
        ])
        ->orderByDesc('fecha')
        ->orderByDesc('numero_vale')
        ->get();

        return view('vales_combustible.index', compact('vales'));
    }

    public function create()
    {
        $lotes = LoteVale::where('estado', true)
            ->orderByDesc('fecha_recepcion')
            ->get();

        $vehiculos = Vehiculo::where('estado', true)
            ->orderBy('codigo')
            ->get();

        $aperturas = AperturaProgramatica::where('estado', true)
            ->orderBy('codigo')
            ->get();

        return view(
            'vales_combustible.create',
            compact('lotes', 'vehiculos', 'aperturas')
        );
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'numero_vale' => 'required|integer|min:1|unique:vales_combustible,numero_vale',
            'fecha' => 'required|date',
            'lote_vale_id' => 'required|exists:lotes_vales,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'apertura_programatica_id' => 'required|exists:aperturas_programaticas,id',
            'numero_factura' => 'nullable|string|max:50',
            'cantidad_litros' => 'required|numeric|min:0.0001',
            'precio_unitario' => 'required|numeric|min:0',
            'kilometraje' => 'nullable|integer|min:0',
            'observacion' => 'nullable|string',
        ]);

        $lote = LoteVale::findOrFail($datos['lote_vale_id']);

        if (
            $datos['numero_vale'] < $lote->numero_inicial ||
            $datos['numero_vale'] > $lote->numero_final
        ) {
            return back()
                ->withErrors([
                    'numero_vale' =>
                        'El número de vale no pertenece al rango del lote seleccionado.'
                ])
                ->withInput();
        }

        $datos['total'] = round(
            $datos['cantidad_litros'] * $datos['precio_unitario'],
            2
        );

        $datos['usuario_id'] = auth()->id();

        ValeCombustible::create($datos);

        return redirect()->route('vales-combustible.index')
            ->with('success', 'Vale de combustible registrado correctamente.');
    }

    public function show(ValeCombustible $valeCombustible)
    {
        $valeCombustible->load([
            'loteVale.tipoCombustible',
            'vehiculo.unidad',
            'aperturaProgramatica.fuenteFinanciamiento',
            'aperturaProgramatica.organismoFinanciador',
            'usuario'
        ]);

        return view(
            'vales_combustible.show',
            compact('valeCombustible')
        );
    }

    public function edit(ValeCombustible $valeCombustible)
    {
        $lotes = LoteVale::where('estado', true)->get();
        $vehiculos = Vehiculo::where('estado', true)->get();
        $aperturas = AperturaProgramatica::where('estado', true)->get();

        return view(
            'vales_combustible.edit',
            compact(
                'valeCombustible',
                'lotes',
                'vehiculos',
                'aperturas'
            )
        );
    }

    public function update(
        Request $request,
        ValeCombustible $valeCombustible
    ) {
        $datos = $request->validate([
            'numero_vale' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('vales_combustible', 'numero_vale')
                    ->ignore($valeCombustible->id),
            ],

            'fecha' => 'required|date',
            'lote_vale_id' => 'required|exists:lotes_vales,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'apertura_programatica_id' => 'required|exists:aperturas_programaticas,id',
            'numero_factura' => 'nullable|string|max:50',
            'cantidad_litros' => 'required|numeric|min:0.0001',
            'precio_unitario' => 'required|numeric|min:0',
            'kilometraje' => 'nullable|integer|min:0',
            'observacion' => 'nullable|string',
        ]);

        $lote = LoteVale::findOrFail($datos['lote_vale_id']);

        if (
            $datos['numero_vale'] < $lote->numero_inicial ||
            $datos['numero_vale'] > $lote->numero_final
        ) {
            return back()
                ->withErrors([
                    'numero_vale' =>
                        'El número de vale no pertenece al rango del lote seleccionado.'
                ])
                ->withInput();
        }

        $datos['total'] = round(
            $datos['cantidad_litros'] * $datos['precio_unitario'],
            2
        );

        $valeCombustible->update($datos);

        return redirect()->route('vales-combustible.index')
            ->with('success', 'Vale de combustible actualizado correctamente.');
    }

    public function destroy(ValeCombustible $valeCombustible)
    {
        $valeCombustible->delete();

        return redirect()->route('vales-combustible.index')
            ->with('success', 'Vale de combustible eliminado correctamente.');
    }
}