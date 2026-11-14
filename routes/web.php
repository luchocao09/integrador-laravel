<?php

use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\MascotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('mascotas.index');
});

Route::resource('mascotas', MascotaController::class);
Route::resource('consultas', ConsultaController::class);
