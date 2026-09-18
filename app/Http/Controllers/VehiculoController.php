<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::with('unidad')
            ->orderBy('codigo')
            ->get();

        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        $unidades = Unidad::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('vehiculos.create', compact('unidades'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => 'required|string|max:30|unique:vehiculos,codigo',
            'placa' => 'required|string|max:20|unique:vehiculos,placa',
            'tipo' => 'nullable|string|max:100',
            'industria' => 'nullable|string|max:100',
            'marca' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'unidad_id' => 'required|exists:unidades,id',
            'estado' => 'required|boolean',
        ]);

        Vehiculo::create($datos);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo registrado correctamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        $vehiculo->load('unidad');

        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        $unidades = Unidad::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('vehiculos.edit', compact('vehiculo', 'unidades'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:30',
                Rule::unique('vehiculos', 'codigo')->ignore($vehiculo->id),
            ],

            'placa' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehiculos', 'placa')->ignore($vehiculo->id),
            ],

            'tipo' => 'nullable|string|max:100',
            'industria' => 'nullable|string|max:100',
            'marca' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'unidad_id' => 'required|exists:unidades,id',
            'estado' => 'required|boolean',
        ]);

        $vehiculo->update($datos);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        if ($vehiculo->valesCombustible()->exists()) {
            return redirect()->route('vehiculos.index')
                ->with('error', 'No se puede eliminar porque tiene vales registrados.');
        }

        $vehiculo->delete();

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }
}