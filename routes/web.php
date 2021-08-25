<?php

use App\Http\Controllers\Admin\ControlHorariosMaquinaController;
use App\Http\Controllers\Admin\Datos\PiezaArticuloController;
use App\Http\Controllers\Admin\EgresosYEtiquetas\ListarController;
use App\Http\Controllers\Admin\HorariosMaquinasController;
use App\Http\Controllers\Admin\Ordenes\ConstruccionController;
use App\Http\Controllers\Admin\EgresosYEtiquetas\RegistrarEgresosController;
use App\Http\Controllers\Admin\Ordenes\ReparacionCompletarCancelarController;
use App\Http\Controllers\Admin\Stock\ConfeccionarDespieceController;
use App\Http\Controllers\Admin\Ordenes\ConstruccionListarCancelarController;
use App\Http\Controllers\Admin\Ordenes\EnsambleCompletarCancelarController;
use App\Http\Controllers\Admin\Ordenes\EnsambleController;
use App\Http\Controllers\Admin\Ordenes\EnsambleListarOrden;
use App\Http\Controllers\Admin\Ordenes\ReparacionListarOrden;
use App\Http\Controllers\Admin\Ordenes\ReparacionController;
use App\Http\Controllers\Admin\Proveedores\ListarProveedoresController;
use App\Http\Controllers\Admin\Usuarios\UsuariosController as UsuariosUsuariosController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
    return view('layouts.index');
})->name('index');

Route::get('/admin/construccion', [ConstruccionController::class, 'index'])->middleware('can:construccion.confeccionar')->name('construccion.confeccionar');
Route::post('/admin/construccion', [ConstruccionController::class, 'piezas']);
Route::post('/admin/construccion/material', [ConstruccionController::class, 'material']);
Route::post('/admin/construccion/material/buscar', [ConstruccionController::class, 'buscarMaterial']);
Route::post('/admin/construccion/modificartarea', [ConstruccionController::class, 'modificarTarea']);
Route::post('/admin/construccion/agregarconstruccion', [ConstruccionController::class, 'agregarconstruccion']);

Route::get('/admin/horariosmaquinas',[HorariosMaquinasController::class,'index'])->middleware('can:horarios.maquinas')->name('horarios.maquinas');
Route::get('/admin/confeccionardespiece',[ConfeccionarDespieceController::class,'index'])->middleware('can:confeccionar.despiece')->name('confeccionar.despiece');
Route::get('/admin/construccion', [ConstruccionController::class, 'index'])->name('construccion.confeccionar');
Route::post('/admin/construccion', [ConstruccionController::class, 'piezas']);
Route::post('/admin/construccion/material', [ConstruccionController::class, 'material']);
Route::post('/admin/construccion/material/buscar', [ConstruccionController::class, 'buscarMaterial']);
Route::post('/admin/construccion/modificartarea', [ConstruccionController::class, 'modificarTarea']);
Route::post('/admin/construccion/agregarconstruccion', [ConstruccionController::class, 'agregarconstruccion']);

Route::get('/admin/horariosmaquinas', [HorariosMaquinasController::class, 'index'])->name('horarios.maquinas');
Route::get('/admin/confeccionardespiece', [ConfeccionarDespieceController::class, 'index'])->name('confeccionar.despiece');
Route::post('/admin/confeccionardespiecepiezas', [ConfeccionarDespieceController::class, 'piezas']);
Route::post('/admin/confeccionardespiecetabla', [ConfeccionarDespieceController::class, 'tabla']);
Route::post('/admin/confeccionardespiecepredeterminar', [ConfeccionarDespieceController::class, 'predeterminar']);
Route::get('/admin/registraregreso', [RegistrarEgresosController::class, 'index'])->name('registrar.egresos');
Route::post('/admin/registraregresopiezas', [RegistrarEgresosController::class, 'piezas']);
Route::post('/admin/registraregresotabla', [RegistrarEgresosController::class, 'tabla']);
Route::post('/admin/registraregresoguardar', [RegistrarEgresosController::class, 'guardar']);
Route::post('/admin/registraregresoguardar', [RegistrarEgresosController::class, 'guardar']);
Route::get('/admin/listar', [ListarController::class, 'index'])->name('listar');
Route::post('/admin/listartabla', [ListarController::class, 'tabla']);
Route::post('/admin/listarpiezas', [ListarController::class, 'piezas']);
Route::get('/admin/controlhorariosmaquina', [ControlHorariosMaquinaController::class, 'index'])->name('control.horarios.maquina');
Route::get('/admin/horariosmaquinas',[HorariosMaquinasController::class,'index'])->name('horarios.maquinas');
Route::get('/admin/confeccionardespiece',[ConfeccionarDespieceController::class,'index'])->name('confeccionar.despiece');
Route::post('/admin/confeccionardespiecepiezas',[ConfeccionarDespieceController::class,'piezas']);
Route::post('/admin/confeccionardespiecetabla',[ConfeccionarDespieceController::class,'tabla']);
Route::post('/admin/confeccionardespiecepredeterminar',[ConfeccionarDespieceController::class,'predeterminar']);
Route::get('/admin/registraregreso',[RegistrarEgresosController::class,'index'])->middleware('can:registrar.egresos')->name('registrar.egresos');
Route::post('/admin/registraregresopiezas',[RegistrarEgresosController::class,'piezas']);
Route::post('/admin/registraregresotabla',[RegistrarEgresosController::class,'tabla']);
Route::post('/admin/registraregresoguardar',[RegistrarEgresosController::class,'guardar']);
Route::get('/admin/listar',[ListarController::class,'index'])->middleware('can:listar')->name('listar');
Route::post('/admin/listartabla',[ListarController::class,'tabla']);
Route::post('/admin/listarpiezas',[ListarController::class,'piezas']);
Route::post('/admin/listarmodificar',[ListarController::class,'modificar']);
Route::post('/admin/listareliminar',[ListarController::class,'eliminar']);
Route::post('/admin/listartablaEtiqueta',[ListarController::class,'tablaEtiqueta']);
Route::get('/admin/controlhorariosmaquina',[ControlHorariosMaquinaController::class,'index'])->middleware('can:control.horarios.maquina')->name('control.horarios.maquina');
Route::get('/admin/controlmaquina',[ControlHorariosMaquinaController::class,'indexControl'])->name('control.maquina');
Route::get('/admin/tiemposmaquina',[ControlHorariosMaquinaController::class,'indexTiempos'])->name('tiempos.maquina');
Route::get('/admin/pdf/{id}', [ListarController::class,'PDF'])->name('descargarPDF');
Route::post('/admin/etchicaspdf', [ListarController::class,'etChicasPDF'])->name('etChicasPDF');
Route::post('/admin/etgrandespdf', [ListarController::class,'etGrandesPDF'])->name('etGrandesPDF');
Route::post('/admin/imprimirtodo', [ListarController::class,'imprimirTodo'])->name('todoPDF');


Route::get('/admin/listarcancelar', [ListarCancelarController::class, 'index'])->middleware('can:construccion.listarcancelar')->name('construccion.listarcancelar');
Route::post('/admin/listarcancelar/piezas', [ListarCancelarController::class, 'piezas']);
Route::post('/admin/listarcancelar/ordenes', [ListarCancelarController::class, 'ordenes']);
Route::post('/admin/listarcancelar/detalles', [ListarCancelarController::class, 'detalles']);
Route::post('/admin/listarcancelar/cancelar', [ListarCancelarController::class, 'cancelar']);
Route::post('/admin/listarcancelar/excel', [ListarCancelarController::class, 'excel']);
Route::get('/admin/listarcancelar/exportExcel', [ListarCancelarController::class, 'exportExcel']);

Route::get('/admin/reparacion/confeccionar', [ReparacionController::class, 'index'])->middleware('can:reparacion.confeccionar')->name('reparacion.confeccionar');
Route::get('/admin/listarcancelar', [ConstruccionListarCancelarController::class, 'index'])->name('construccion.listarcancelar');
Route::post('/admin/listarcancelar/piezas', [ConstruccionListarCancelarController::class, 'piezas']);
Route::post('/admin/listarcancelar/ordenes', [ConstruccionListarCancelarController::class, 'ordenes']);
Route::post('/admin/listarcancelar/detalles', [ConstruccionListarCancelarController::class, 'detalles']);
Route::post('/admin/listarcancelar/cancelar', [ConstruccionListarCancelarController::class, 'cancelar']);
Route::post('/admin/listarcancelar/exportExcel', [ConstruccionListarCancelarController::class, 'exportExcel'])->name('piezaExcel');
Route::post('/admin/listarcancelar/exportExcelFechas', [ConstruccionListarCancelarController::class, 'exportExcelFechas'])->name('fechaExcel');
Route::post('/admin/listarcancelar/exportExcelNumero', [ConstruccionListarCancelarController::class, 'exportExcelNumero'])->name('numeroExcel');

Route::get('/admin/reparacion/confeccionar', [ReparacionController::class, 'index'])->name('reparacion.confeccionar');
Route::post('/admin/reparacion/conjuntos', [ReparacionController::class, 'conjuntos']);
Route::post('/admin/reparacion/guardar', [ReparacionController::class, 'guardar']);

Route::get('/admin/reparacion/completarcancelar', [ReparacionCompletarCancelarController::class, 'index'])->name('reparacion.completarcancelar');
Route::post('/admin/reparacion/ordenpendiente', [ReparacionCompletarCancelarController::class, 'ordenpendiente']);
Route::post('/admin/reparacion/ordenpieza', [ReparacionCompletarCancelarController::class, 'ordenpieza']);
Route::post('/admin/reparacion/cancelarorden', [ReparacionCompletarCancelarController::class, 'cancelarorden']);

Route::get('/admin/reparacion/listar', [ReparacionListarOrden::class, 'index'])->name('reparacion.listar');
Route::post('/admin/reparacion/listarherramientas', [ReparacionListarOrden::class, 'listarherramientas']);
Route::post('/admin/reparacion/listarordenes', [ReparacionListarOrden::class, 'listarordenes']);
Route::post('/admin/reparacion/listardetalles', [ReparacionListarOrden::class, 'listardetalles']);
/* Route::post('/admin/reparacion/exportExcel', [ReparacionListarOrden::class, 'exportExcel'])->name('reparacionPiezaExcel');
Route::post('/admin/reparacion/exportExcelFechas', [ReparacionListarOrden::class, 'exportExcelFechas'])->name('reparacionFechaExcel');
Route::post('/admin/reparacion/exportExcelNumero', [ReparacionListarOrden::class, 'exportExcelNumero'])->name('reparacionNumeroExcel'); */
Route::post('/admin/reparacion/modificarorden', [ReparacionListarOrden::class, 'modificarorden']);

Route::get('/admin/ensamble/confeccionar', [EnsambleController::class, 'index'])->name('ensamble.confeccionar');
Route::post('/admin/ensamble/conjuntos', [EnsambleController::class, 'conjuntos']);
Route::post('/admin/ensamble/guardar', [EnsambleController::class, 'guardar']);

Route::get('/admin/ensamble/completarcancelar', [EnsambleCompletarCancelarController::class, 'index'])->name('ensamble.completarcancelar');
Route::post('/admin/ensamble/ordenpendiente', [EnsambleCompletarCancelarController::class, 'ordenpendiente']);
Route::post('/admin/ensamble/cancelarorden', [EnsambleCompletarCancelarController::class, 'cancelarorden']);

Route::get('/admin/ensamble/listar', [EnsambleListarOrden::class, 'index'])->name('ensamble.listar');
Route::post('/admin/ensamble/listarordenes', [EnsambleListarOrden::class, 'listarordenes']);

Route::post('/admin/confeccionardespiecepiezas', [ConfeccionarDespieceController::class, 'piezas']);
Route::post('/admin/confeccionardespiecetabla', [ConfeccionarDespieceController::class, 'tabla']);
Route::post('/admin/confeccionardespiecepredeterminar', [ConfeccionarDespieceController::class, 'predeterminar']);
Route::post('/admin/registraregresopiezas', [RegistrarEgresosController::class, 'piezas']);
Route::post('/admin/registraregresotabla', [RegistrarEgresosController::class, 'tabla']);
Route::get('/admin/controlhorariosmaquina', [ControlHorariosMaquinaController::class, 'index'])->name('control.horarios.maquina');

Route::get('/admin/datos/piezasconjuntos', [PiezaArticuloController::class, 'index'])->name('datos.piezasconjuntos');
Route::post('/admin/datos/buscarpiezas', [PiezaArticuloController::class, 'buscarpiezas']);
Route::post('/admin/datos/enviardatos', [PiezaArticuloController::class, 'enviardatos']);

Route::get('/admin/listarproveedores', [ListarProveedoresController::class, 'index'])->name('listar.proveedores');
Route::post('/admin/listarproveedoreslistar', [ListarProveedoresController::class, 'listar']);
Route::post('/admin/listarproveedoresarticulos', [ListarProveedoresController::class, 'listarArticulos']);

Route::resource('usuarios', UsuariosUsuariosController::class)->names('usuarios');
