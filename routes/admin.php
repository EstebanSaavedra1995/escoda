<?php

use App\Http\Controllers\Admin\ControlHorariosMaquinaController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HorariosMaquinasController;
use App\Http\Controllers\Admin\Ordenes\Construccion\ConstruccionController;
use App\Http\Controllers\Admin\Stock\ConfeccionarDespieceController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class,'index']);
Route::get('/ordenes/construccion/confeccionar',[ConstruccionController::class,'index'])->name('construccion.confeccionar');
Route::post('/ordenes/construccion/confeccionar',[ConstruccionController::class,'piezas']);

Route::get('/horariosmaquinas',[HorariosMaquinasController::class,'index'])->name('horarios.maquinas');

Route::get('/horariosmaquinas',[HorariosMaquinasController::class,'index'])->name('horarios.maquinas');
Route::get('/confeccionardespiece',[ConfeccionarDespieceController::class,'index'])->name('confeccionar.despiece');
Route::get('/controlhorariosmaquina',[ControlHorariosMaquinaController::class,'index'])->name('control.horarios.maquina');
