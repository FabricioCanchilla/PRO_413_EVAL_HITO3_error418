<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;

// Corrección aquí (agregar Route:: antes de get)
Route::get('/', [SolicitudController::class, 'index'])->name('solicitudes.index');

// Ruta para guardar una nueva solicitud de soporte (formulario POST)
Route::post('/solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');

// Ruta para actualizar el estado de una solicitud específica
Route::put('/solicitudes/{id}/estado', [SolicitudController::class, 'updateEstado'])->name('solicitudes.updateEstado');