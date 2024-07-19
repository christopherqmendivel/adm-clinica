<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta para obtener los empleados
Route::get('/empleados', [EmpleadoController::class, 'index']);


// Rutas para Clínicas
Route::get('/clinicas', [ClinicaController::class, 'index']);
Route::post('/clinicas', [ClinicaController::class, 'store']);
Route::get('/clinicas/{clinica}', [ClinicaController::class, 'show']);
Route::put('/clinicas/{clinica}', [ClinicaController::class, 'update']);
Route::delete('/clinicas/{clinica}', [ClinicaController::class, 'destroy']);

Route::get('/clinicas/{id}/empleados', [ClinicaController::class, 'empleadosPorClinica']);


// Rutas para Empleados
Route::get('/empleados', [EmpleadoController::class, 'index']);
Route::post('/empleados', [EmpleadoController::class, 'store']);
Route::get('/empleados/{id}', [EmpleadoController::class, 'show']);
Route::put('/empleados/{id}', [EmpleadoController::class, 'update']);
Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy']);

// Ruta para crear empleados dentro de una clínica específica
Route::post('/clinicas/{clinica}/empleados', [EmpleadoController::class, 'store']);
