<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('horario', 'Api\ApiController@setHorarioM');
Route::post('eps', 'Api\ApiController@setEps');
Route::post('especialidades', 'Api\ApiController@setEspecialidades');
Route::post('medicos', 'Api\ApiController@setMedicos');
Route::post('tipos-consultas', 'Api\ApiController@setTipoConsultas');
Route::post('departamentos', 'Api\ApiController@setDepartamentos');
Route::post('municipios', 'Api\ApiController@setMunicipios');


Route::post('citas', 'Api\ApiController@getCitas');
Route::post('estado/cita', 'Api\ApiController@estadoCita');


