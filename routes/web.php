<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\TipoCombustibleController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\FuenteFinanciamientoController;
use App\Http\Controllers\OrganismoFinanciadorController;
use App\Http\Controllers\AperturaProgramaticaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\EstacionServicioController;
use App\Http\Controllers\LoteValeController;
use App\Http\Controllers\ValeCombustibleController;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SolicitudContrasenaController;
use App\Http\Controllers\ReporteController;


/*
|--------------------------------------------------------------------------
| Inicio
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AutenticacionController::class, 'mostrarLogin'])
    ->name('login');

Route::post('/login', [AutenticacionController::class, 'login'])
    ->name('login.procesar');

// Cerrar sesión
Route::post('/logout', [AutenticacionController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Registro
|--------------------------------------------------------------------------
*/

Route::get('/registro', [RegistroController::class, 'mostrarRegistro'])
    ->name('registro');

Route::post('/registro', [RegistroController::class, 'registrar'])
    ->name('registro.procesar');


/*
|--------------------------------------------------------------------------
| Olvidé mi contraseña
|--------------------------------------------------------------------------
*/

Route::get(
    '/olvide-contrasena',
    [SolicitudContrasenaController::class, 'mostrarFormulario']
)->name('password.request');

Route::post(
    '/olvide-contrasena',
    [SolicitudContrasenaController::class, 'enviarSolicitud']
)->name('password.solicitar');



/*
|--------------------------------------------------------------------------
| Módulos protegidos
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
        /*
    |--------------------------------------------------------------------------
    | dashboard
    |--------------------------------------------------------------------------
    */

  
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    Route::resource('roles', RolController::class)
        ->parameters(['roles' => 'rol']);


    /*
    |--------------------------------------------------------------------------
    | Usuarios
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/usuarios/{usuario}/restablecer-contrasena',
        [UsuarioController::class, 'mostrarRestablecerContrasena']
    )->name('usuarios.restablecer-contrasena');

    Route::put(
        '/usuarios/{usuario}/restablecer-contrasena',
        [UsuarioController::class, 'restablecerContrasena']
    )->name('usuarios.actualizar-contrasena');

    Route::resource('usuarios', UsuarioController::class)
        ->parameters(['usuarios' => 'usuario']);


    /*
    |--------------------------------------------------------------------------
    | Vehículos y unidades
    |--------------------------------------------------------------------------
    */

    Route::resource('vehiculos', VehiculoController::class)
        ->parameters(['vehiculos' => 'vehiculo']);

    Route::resource('unidades', UnidadController::class)
        ->parameters(['unidades' => 'unidad']);


    /*
    |--------------------------------------------------------------------------
    | Gestión de vales
    |--------------------------------------------------------------------------
    */

    Route::resource('lotes-vales', LoteValeController::class)
        ->parameters(['lotes-vales' => 'loteVale']);

    Route::resource('vales-combustible', ValeCombustibleController::class)
        ->parameters(['vales-combustible' => 'valeCombustible']);


    /*
    |--------------------------------------------------------------------------
    | Configuración de combustible
    |--------------------------------------------------------------------------
    */

    Route::resource('periodos', PeriodoController::class)
        ->parameters(['periodos' => 'periodo']);

    Route::resource('tipos-combustible', TipoCombustibleController::class)
        ->parameters(['tipos-combustible' => 'tipoCombustible']);

    Route::resource('estaciones-servicio', EstacionServicioController::class)
        ->parameters(['estaciones-servicio' => 'estacionServicio']);


    /*
    |--------------------------------------------------------------------------
    | Aperturas y financiamiento
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'aperturas-programaticas',
        AperturaProgramaticaController::class
    )->parameters([
        'aperturas-programaticas' => 'aperturaProgramatica'
    ]);

    Route::resource(
        'fuentes-financiamiento',
        FuenteFinanciamientoController::class
    )->parameters([
        'fuentes-financiamiento' => 'fuenteFinanciamiento'
    ]);

    Route::resource(
        'organismos-financiadores',
        OrganismoFinanciadorController::class
    )->parameters([
        'organismos-financiadores' => 'organismoFinanciador'
    ]);

    Route::get(
    '/solicitudes-contrasena',
    [SolicitudContrasenaController::class, 'index']
)->name('solicitudes-contrasena.index');

Route::get('/reportes/consumo', [ReporteController::class, 'consumo'])
    ->name('reportes.consumo');


});