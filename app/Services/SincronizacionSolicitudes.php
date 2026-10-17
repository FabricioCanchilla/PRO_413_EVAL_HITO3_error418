<?php

namespace App\Services;

use App\Models\SolicitudSoporte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SincronizacionSolicitudes
{
    public function ejecutar(): array
    {
        try {
            $solicitudes = SolicitudSoporte::query()
                ->get([
                    'id',
                    'solicitante',
                    'departamento',
                    'descripcion',
                    'prioridad',
                    'estado',
                    'created_at',
                    'updated_at',
                ]);

            if ($solicitudes->isEmpty()) {
                return [
                    'exito' => true,
                    'cantidad' => 0,
                    'mensaje' => 'No hay solicitudes para sincronizar.',
                ];
            }

            $datos = $solicitudes->map(function ($solicitud) {
                return $solicitud->toArray();
            })->all();

            DB::connection('destino')
                ->table('solicitudes_soporte')
                ->upsert(
                    $datos,
                    ['id'],
                    [
                        'solicitante',
                        'departamento',
                        'descripcion',
                        'prioridad',
                        'estado',
                        'updated_at',
                    ]
                );

            return [
                'exito' => true,
                'cantidad' => count($datos),
                'mensaje' => 'Solicitudes sincronizadas correctamente.',
            ];

        } catch (Throwable $error) {
            Log::error('Error de sincronizacion MySQL', [
                'tipo' => get_class($error),
                'codigo' => $error->getCode(),
            ]);

            return [
                'exito' => false,
                'cantidad' => 0,
                'mensaje' => 'No se pudo completar la sincronizacion.',
            ];
        }
    }
}