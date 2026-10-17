<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudSoporte;

class SolicitudController extends Controller
{
    // 1. Mostrar el listado de solicitudes[cite: 2]
    public function index()
    {
        $solicitudes = SolicitudSoporte::all();
        return view('solicitudes.index', compact('solicitudes')); 
        // Nota: Si prefieres retornar JSON para API, puedes usar: return response()->json($solicitudes);
    }

    // 2. Guardar una nueva solicitud de soporte[cite: 2, 3]
    public function store(Request $request)
    {
        // Validar campos obligatorios
        $request->validate([
            'solicitante' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:baja,media,alta',
        ]);

        // Crear la solicitud con estado inicial 'Pendiente' por defecto[cite: 2]
        SolicitudSoporte::create([
            'solicitante' => $request->solicitante,
            'departamento' => $request->departamento,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'estado' => 'Pendiente',
        ]);

        return redirect()->back()->with('success', 'Solicitud registrada exitosamente.');
    }

    // 3. Actualizar el estado de una solicitud (Pendiente, En proceso, Resuelta)[cite: 2, 3]
    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,En proceso,Resuelta',
        ]);

        $solicitud = SolicitudSoporte::findOrFail($id);
        $solicitud->estado = $request->estado;
        $solicitud->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
}