<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VectorController;
use App\Http\Controllers\UnitConversionController;

Route::get('/', [VectorController::class, 'index']);

// Rutas de Vectores
Route::get('/simulador-vectores', [VectorController::class, 'index']);
Route::post('/simulador-vectores/calcular', [VectorController::class, 'calculate']);

// Rutas de Conversor de Unidades
Route::get('/conversor-unidades', [UnitConversionController::class, 'index']);
Route::post('/conversor-unidades/convertir', [UnitConversionController::class, 'convert']);
Route::get('/actividades', function() {
    return view('simulators.activities');
});