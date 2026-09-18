<?php

namespace App\Http\Controllers;

use App\Models\FuenteFinanciamiento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FuenteFinanciamientoController extends Controller
{
    public function index()
    {
        $fuentes = FuenteFinanciamiento::orderBy('codigo')->get();

        return view('fuentes_financiamiento.index', compact('fuentes'));
    }

    public function create()
    {
        return view('fuentes_financiamiento.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => 'required|string|max:20|unique:fuentes_financiamiento,codigo',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
        ]);

        FuenteFinanciamiento::create($datos);

        return redirect()
            ->route('fuentes-financiamiento.index')
            ->with(
                'success',
                'Fuente de financiamiento registrada correctamente.'
            );
    }

    public function show(FuenteFinanciamiento $fuenteFinanciamiento)
    {
        return view(
            'fuentes_financiamiento.show',
            compact('fuenteFinanciamiento')
        );
    }

    public function edit(FuenteFinanciamiento $fuenteFinanciamiento)
    {
        return view(
            'fuentes_financiamiento.edit',
            compact('fuenteFinanciamiento')
        );
    }

    public function update(
        Request $request,
        FuenteFinanciamiento $fuenteFinanciamiento
    ) {
        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('fuentes_financiamiento', 'codigo')
                    ->ignore($fuenteFinanciamiento->id),
            ],

            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $fuenteFinanciamiento->update($datos);

        return redirect()
            ->route('fuentes-financiamiento.index')
            ->with(
                'success',
                'Fuente de financiamiento actualizada correctamente.'
            );
    }

    public function destroy(FuenteFinanciamiento $fuenteFinanciamiento)
    {
        if ($fuenteFinanciamiento->aperturasProgramaticas()->exists()) {
            return redirect()
                ->route('fuentes-financiamiento.index')
                ->with(
                    'error',
                    'No se puede eliminar porque está siendo utilizada.'
                );
        }

        $fuenteFinanciamiento->delete();

        return redirect()
            ->route('fuentes-financiamiento.index')
            ->with(
                'success',
                'Fuente de financiamiento eliminada correctamente.'
            );
    }
}