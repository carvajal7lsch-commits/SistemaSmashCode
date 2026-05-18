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

// --- Gestión de Usuarios (HU04) ---
$app->get('/admin/usuarios', 'AdminController@usuarios');
$app->get('/admin/usuarios/crear', 'AdminController@crearUsuario');
$app->post('/admin/usuarios/guardar', 'AdminController@guardarUsuario');
$app->get('/admin/usuarios/editar', 'AdminController@editarUsuario');
$app->post('/admin/usuarios/actualizar', 'AdminController@actualizarUsuario');
$app->post('/admin/usuarios/suspender', 'AdminController@suspenderUsuario');
$app->post('/admin/usuarios/eliminar', 'AdminController@eliminarUsuario');
$app->get('/admin/usuarios/actividad', 'AdminController@actividadUsuario');

// --- Alta de Instructores (HU09) ---
$app->get('/admin/usuarios/instructor', 'AdminController@crearInstructor');
$app->post('/admin/usuarios/instructor/guardar', 'AdminController@guardarInstructor');

// --- Cambio de Contraseña Forzado (primer login instructor) ---
$app->get('/cambiar-clave', 'AuthController@showCambiarClave');
$app->post('/cambiar-clave/guardar', 'AuthController@guardarCambiarClave');

// ==============================================================

// 5. Ejecutar la aplicación
$app->run();