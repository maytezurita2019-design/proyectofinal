<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodoController extends Controller
{
    public function index()
    {
        $periodos = Periodo::orderByDesc('anio')
            ->orderByDesc('mes')
            ->get();

        return view('periodos.index', compact('periodos'));
    }

    public function create()
    {
        return view('periodos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:2100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|boolean',
        ]);

        $existe = Periodo::where('mes', $datos['mes'])
            ->where('anio', $datos['anio'])
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['mes' => 'Ya existe un periodo para ese mes y año.'])
                ->withInput();
        }

        Periodo::create($datos);

        return redirect()->route('periodos.index')
            ->with('success', 'Periodo registrado correctamente.');
    }

    public function show(Periodo $periodo)
    {
        return view('periodos.show', compact('periodo'));
    }

    public function edit(Periodo $periodo)
    {
        return view('periodos.edit', compact('periodo'));
    }

    public function update(Request $request, Periodo $periodo)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:2100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|boolean',
        ]);

        $existe = Periodo::where('mes', $datos['mes'])
            ->where('anio', $datos['anio'])
            ->where('id', '!=', $periodo->id)
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['mes' => 'Ya existe un periodo para ese mes y año.'])
                ->withInput();
        }

        $periodo->update($datos);

        return redirect()->route('periodos.index')
            ->with('success', 'Periodo actualizado correctamente.');
    }

    public function destroy(Periodo $periodo)
    {
        if ($periodo->lotesVales()->exists()) {
            return redirect()->route('periodos.index')
                ->with('error', 'No se puede eliminar porque tiene lotes de vales asociados.');
        }

        $periodo->delete();

        return redirect()->route('periodos.index')
            ->with('success', 'Periodo eliminado correctamente.');
    }
}