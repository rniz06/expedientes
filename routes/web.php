<?php

use App\Http\Controllers\ExpedienteController;
use App\Livewire\Expedientes;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/app');
});

// Descargar archivos relacionados al expediente en la tabla expediente_archivos
Route::get('/expediente/descargar-archivo/{record}', [ExpedienteController::class, 'descargarArchivo'])->name('expediente.descargar.archivo');
//Route::get('/', Expedientes::class);