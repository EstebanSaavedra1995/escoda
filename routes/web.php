<?php

use App\Http\Controllers\Admin\ControlHorariosMaquinaController;
use App\Http\Controllers\Admin\HorariosMaquinasController;
use App\Http\Controllers\Admin\Ordenes\ConstruccionController;
use App\Http\Controllers\Admin\RegistrarEgresosController;
use App\Http\Controllers\Admin\Stock\ConfeccionarDespieceController;
use App\Http\Controllers\Admin\Ordenes\ListarCancelarController;
use App\Http\Controllers\Admin\Ordenes\ReparacionController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
    return view('layouts.index');
})->name('index');

Route::get('/admin/construccion', [ConstruccionController::class, 'index'])->name('construccion.confeccionar');
Route::post('/admin/construccion', [ConstruccionController::class, 'piezas']);
Route::post('/admin/construccion/material', [ConstruccionController::class, 'material']);
Route::post('/admin/construccion/material/buscar', [ConstruccionController::class, 'buscarMaterial']);
Route::post('/admin/construccion/modificartarea', [ConstruccionController::class, 'modificarTarea']);
Route::post('/admin/construccion/agregarconstruccion', [ConstruccionController::class, 'agregarconstruccion']);

Route::get('/admin/listarcancelar', [ListarCancelarController::class, 'index'])->name('construccion.listarcancelar');
Route::post('/admin/listarcancelar/piezas', [ListarCancelarController::class, 'piezas']);
Route::post('/admin/listarcancelar/ordenes', [ListarCancelarController::class, 'ordenes']);
Route::post('/admin/listarcancelar/detalles', [ListarCancelarController::class, 'detalles']);
Route::post('/admin/listarcancelar/cancelar', [ListarCancelarController::class, 'cancelar']);
Route::post('/admin/listarcancelar/excel', [ListarCancelarController::class, 'excel']);
Route::get('/admin/listarcancelar/exportExcel', [ListarCancelarController::class, 'exportExcel']);

Route::get('/admin/reparacion/confeccionar', [ReparacionController::class, 'index'])->name('reparacion.confeccionar');



Route::get('/admin/horariosmaquinas', [HorariosMaquinasController::class, 'index'])->name('horarios.maquinas');
Route::get('/admin/confeccionardespiece', [ConfeccionarDespieceController::class, 'index'])->name('confeccionar.despiece');
Route::post('/admin/confeccionardespiecepiezas', [ConfeccionarDespieceController::class, 'piezas']);
Route::post('/admin/confeccionardespiecetabla', [ConfeccionarDespieceController::class, 'tabla']);
Route::post('/admin/confeccionardespiecepredeterminar', [ConfeccionarDespieceController::class, 'predeterminar']);
Route::get('/admin/registraregreso', [RegistrarEgresosController::class, 'index'])->name('registrar.egresos');
Route::post('/admin/registraregresopiezas', [RegistrarEgresosController::class, 'piezas']);
Route::post('/admin/registraregresotabla', [RegistrarEgresosController::class, 'tabla']);
Route::get('/admin/controlhorariosmaquina', [ControlHorariosMaquinaController::class, 'index'])->name('control.horarios.maquina');
