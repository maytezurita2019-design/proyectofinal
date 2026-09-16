<?php

namespace App\Http\Controllers;

use App\Models\ServiceStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceStationController extends Controller
{
    public function index()
    {
        $stations = ServiceStation::orderBy('name')->get();

        return view('admin.service_stations.index', compact('stations'));
    }

    public function create()
    {
        return view('admin.service_stations.create');
    }

    public function searchLocation(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $response = Http::withHeaders([
            'User-Agent' => 'CombustibleGAM/1.0',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $request->query('query'),
            'format' => 'jsonv2',
            'limit' => 5,
            'countrycodes' => 'bo',
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'No se pudo consultar el servicio de ubicación.'
            ], 502);
        }

        return response()->json($response->json());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'address' => 'nullable|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $data['status'] = true;

        ServiceStation::create($data);

        return redirect()
            ->route('service-stations.index')
            ->with('success', 'Estación de servicio registrada correctamente.');
    }
}