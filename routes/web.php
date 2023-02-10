<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesoresController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\AsignaturasProfesoresController;
use App\Http\Controllers\AsignaturasEstudianteController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('Asignaturas')->group(function () {
    Route::get('', [AsignaturasController::class, 'index'])->name('Asignaturas');
    Route::post('Crear', [AsignaturasController::class, 'create']);
    Route::post('Listar', [AsignaturasController::class, 'store']);
    Route::post('Editar', [AsignaturasController::class, 'update']);
    Route::post('Eliminar', [AsignaturasController::class, 'destroy']);
});

Route::prefix('Profesores')->group(function () {
    Route::get('', [ProfesoresController::class, 'index'])->name('Profesores');
    Route::post('Crear', [ProfesoresController::class, 'create']);
    Route::post('Listar', [ProfesoresController::class, 'store']);
    Route::post('Editar', [ProfesoresController::class, 'update']);
    Route::post('Eliminar', [ProfesoresController::class, 'destroy']);
});

Route::prefix('Estudiantes')->group(function () {
    Route::get('', [EstudiantesController::class, 'index'])->name('Estudiantes');
    Route::post('Crear', [EstudiantesController::class, 'create']);
    Route::post('Listar', [EstudiantesController::class, 'store']);
    Route::post('Editar', [EstudiantesController::class, 'update']);
    Route::post('Eliminar', [EstudiantesController::class, 'destroy']);
});

Route::prefix('AsignaturasProfesor')->group(function () {
    Route::post('Listar', [AsignaturasProfesoresController::class, 'store']);
    Route::post('Guardar', [AsignaturasProfesoresController::class, 'create']);
    Route::post('Profesores', [AsignaturasProfesoresController::class, 'show']);
});

Route::prefix('AsignaturasEstudiante')->group(function () {
    Route::post('Listar', [AsignaturasEstudianteController::class, 'store']);
    Route::post('Guardar', [AsignaturasEstudianteController::class, 'create']);
});

Route::prefix('Reporte')->group(function () {
    Route::get('', [ReporteController::class, 'index'])->name('Reporte');
    Route::post('Listar', [ReporteController::class, 'store']);
});

Route::any('{url}', function(){
    return redirect('Asignaturas');
})->where('url', '.*');