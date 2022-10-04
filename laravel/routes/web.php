<?php


use Illuminate\Support\Facades\Route;

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





Route::group(['middleware' => ['guest']], function () {

    Route::get('/','Auth\LoginController@showLoginForm')->name('view.login');
    Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
    Route::get('/restablecer-clave','Auth\ResetController@index')->name('reset');
    Route::post('/reset','Auth\ResetController@resetPassword')->name('save');
    Route::post('/login', 'Auth\LoginController@login')->name('login');


});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('inicio','ViewController@index')->name('home');
    Route::get('empresa','ViewController@empresa')->name('empresa');
    Route::get('cotizaciones','ViewController@cotizaciones')->name('cotizaciones');
    Route::get('cotizaciones/ver','ViewController@listadoCotizaciones')->name('cotizaciones.listado');
    Route::get('categorias','ViewController@categorias')->name('categorias');
    Route::get('clientes','ViewController@clientes')->name('clientes');
    Route::get('piezas','ViewController@piezas')->name('piezas');
    Route::get('andamios','ViewController@andamios')->name('andamios');
    Route::get('proyectos','ViewController@proyectos')->name('proyectos');
    Route::get('usuarios','ViewController@usuarios')->name('usuarios');
    Route::get('reportes','ViewController@reportes')->name('reportes');
    Route::get('entregas/{id}','ViewController@entregas')->name('entregas');
    Route::get('andamios/crear','ViewController@createAndamios')->name('andamios.create');
    Route::get('importar-inventario', 'ImportarInventarioController@index')->name('importar.index');
    Route::get('soportes/{id}', 'ViewController@soportes')->name('soportes');
    Route::get('detalles-cotizacion/{id}', 'ViewController@detallesCotizaciones')->name('cotizacion.detalles');
    Route::get('registro-entregas/{id}', 'ViewController@registroEntrega')->name('entregas.registro');
    Route::get('ver-cotizacion/{id}', 'ViewController@verCotizacion')->name('cotizacion.ver');
    Route::get('ver-entrega/{id}', 'ViewController@verEntrega')->name('entrega.ver');
    Route::get('reporte-cotizacion/{id}', 'ReporteController@reporteCotizacion')->name('cotizacion.reporte');
    Route::get('reporte-entrega/{id}', 'ReporteController@reporteEntrega')->name('entrega.reporte');


    Route::get('registro-devolucion/{id}', 'ViewController@registroDevolucion')->name('devoluciones.registro');
    Route::get('ver-devolucion/{id}', 'ViewController@verDevolucion')->name('devoluciones.ver');

    //Liquidaciones
    Route::get('registro-liquidacion/{id}', 'ViewController@registroLiquidacion')->name('liquidaciones.registro');
    Route::get('ver-liquidacion/{id}', 'ViewController@verLiquidacion')->name('liquidaciones.ver');

    Route::get('generar-entrega/{id}', 'ViewController@generarEntrega')->name('entregas.generar');

    Route::get('generar-entrega-encofrado/{id}', 'ViewController@generarEntregaEncofrado')->name('entregas-encofrado.generar');



    Route::get('servicios-proyecto/{id}', 'ViewController@serviciosProyectos')->name('proyectos.servicios');

    Route::get('registro-cobros/{id}', 'ViewController@registroCobros')->name('cobros.registro');
    Route::get('ver-cobros/{id}', 'ViewController@verCobros')->name('cobros.ver');
    Route::get('ver-entrega/proyecto/{id}', 'ViewController@verEntregaproyecto')->name('proyectos.ver-entrega');
    Route::get('opciones/proyecto/{id}', 'ViewController@opcionesProyecto')->name('proyectos.opciones');

    //Facturas
    Route::get('factura/proyecto/{id}', 'ViewController@generarFactura')->name('facturas.generar');
    Route::get('impirmir/factura/{id}', 'ReporteController@imprimirFactura')->name('facturas.imprimir');

    //Cobros Material Encofrado
    Route::get('encofrados/proyecto/{id}', 'ViewController@cobrosEncofrados')->name('cobros-encofrado.registro');


    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('perfil','ViewController@perfil')->name('perfil');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('import-inventario', 'ImportarInventarioController@importar')->name('import-inventario');
});
