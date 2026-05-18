<?php
/**
 * index.php — Front Controller / Entry Point principal del sistema SmashCode.
 * Inicializa el autoloader, carga las sesiones, configura las rutas y despacha las peticiones.
 */

// 1. Cargar dependencias de Composer (PHPMailer, JWT, etc.)
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// 2. Cargar utilidades procedimentales heredadas (funciones globales y manejo de sesión)
require_once __DIR__ . '/config/sesion.php';
require_once __DIR__ . '/includes/funciones.php';

// 3. Registrar el Autocargador PSR-4 del núcleo MVC
require_once __DIR__ . '/app/Core/Autoloader.php';
\App\Core\Autoloader::registrar();

// 4. Inicializar el enrutador
$app = new \App\Core\App();

// ==================== DEFINICIÓN DE RUTAS ====================

// --- Panel Principal (Aprendiz) ---
$app->get('/', 'HomeController@index');

// --- Autenticación y Registro ---
$app->get('/login', 'AuthController@showLogin');
$app->post('/login/ingresar', 'AuthController@ingresar');
$app->post('/login/registrar', 'AuthController@registrar');
$app->get('/logout', 'AuthController@logout');

// --- Recuperación de Contraseñas ---
$app->get('/recuperar', 'AuthController@showRecuperar');
$app->post('/recuperar/enviar', 'AuthController@enviarEnlace');
$app->get('/restablecer', 'AuthController@showRestablecer');
$app->post('/restablecer/guardar', 'AuthController@guardarClave');

// --- Panel de Administración ---
$app->get('/admin', 'AdminController@index');

// --- Panel del Instructor ---
$app->get('/instructor', 'InstructorController@index');

// ==============================================================

// 5. Ejecutar la aplicación
$app->run();