<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Programa;
use Firebase\JWT\JWT;
use Exception;

/**
 * AuthController.php
 * Controlador que gestiona toda la autenticación, registro, cierre de sesión,
 * y recuperación/restablecimiento de contraseñas.
 */
class AuthController extends Controller {

    private User $userModel;
    private Programa $programaModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->programaModel = new Programa();
        iniciarSesion();
    }

    /**
     * Muestra la pantalla de inicio de sesión o registro.
     */
    public function showLogin(): void {
        if (estaAutenticado()) {
            $this->redirigirPorRol(obtenerRolSesion());
        }

        $accion = limpiar($_GET['accion'] ?? 'ingresar');
        $error = '';
        $exito = '';
        $programas = $this->programaModel->obtenerTodos();
        $csrf = generarTokenCSRF();

        $this->render('auth/login', [
            'accion' => $accion,
            'error' => $error,
            'exito' => $exito,
            'programas' => $programas,
            'csrf' => $csrf
        ]);
    }

    /**
     * Procesa el inicio de sesión.
     */
    public function ingresar(): void {
        if (estaAutenticado()) {
            $this->redirigirPorRol(obtenerRolSesion());
        }

        $error = '';
        $exito = '';
        $programas = $this->programaModel->obtenerTodos();
        $csrf = generarTokenCSRF();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('login');
        }

        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $error = 'Solicitud inválida. Recarga la página.';
        } else {
            $correo = limpiar($_POST['correo'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';

            if (empty($correo) || empty($contrasena)) {
                $error = 'Completa todos los campos.';
            } else {
                $usuario = $this->userModel->obtenerPorCorreo($correo);

                if (!$usuario) {
                    $error = 'Correo o contraseña incorrectos.';
                } elseif ($usuario['bloqueado']) {
                    $error = 'Cuenta bloqueada. Revisa tu correo.';
                } elseif (!$usuario['activo']) {
                    $error = 'Cuenta suspendida. Contacta al administrador.';
                } elseif (!password_verify($contrasena, $usuario['contrasena'])) {
                    // Contraseña incorrecta
                    $intentos = $usuario['intentos_fallidos'] + 1;
                    $bloquear = $intentos >= 5 ? 1 : 0;
                    $this->userModel->actualizarIntentosFallidos($usuario['id'], $intentos, $bloquear);

                    if ($bloquear) {
                        $error = 'Cuenta bloqueada por demasiados intentos.';
                        // Importar la función de envío de correos desde includes
                        if (file_exists(dirname(__DIR__, 2) . '/includes/correo.php')) {
                            require_once dirname(__DIR__, 2) . '/includes/correo.php';
                            enviarCorreo(
                                $correo,
                                'Alerta de Seguridad - Cuenta Bloqueada',
                                '<h1>Cuenta Bloqueada</h1><p>Tu cuenta ha sido bloqueada tras 5 intentos fallidos de inicio de sesión. Por favor, restablece tu contraseña para recuperar el acceso.</p>'
                            );
                        }
                    } else {
                        $error = 'Contraseña incorrecta. Intento ' . $intentos . ' de 5.';
                    }
                } else {
                    // Autenticación exitosa
                    $this->userModel->resetearIntentosFallidos($usuario['id']);
                    session_regenerate_id(true);
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['nombre'] = $usuario['nombre_completo'];
                    $_SESSION['rol'] = $usuario['rol'];
                    $_SESSION['ultima_actividad'] = time();

                    // Generar token JWT para la sesión
                    if (!defined('JWT_SECRET')) {
                        $rutaCredenciales = dirname(__DIR__, 2) . '/config/credenciales.php';
                        if (file_exists($rutaCredenciales)) {
                            require_once $rutaCredenciales;
                        }
                    }
                    
                    $secret_key = defined('JWT_SECRET') ? JWT_SECRET : 'AQUI_COLOCA_UNA_CLAVE_DE_MINIMO_32_CARACTERES';
                    $payload = [
                        'iss' => 'smashcode',
                        'aud' => 'smashcode_users',
                        'iat' => time(),
                        'nbf' => time(),
                        'exp' => time() + 1800, // 30 min
                        'data' => [
                            'id' => $usuario['id'],
                            'rol' => $usuario['rol']
                        ]
                    ];
                    $jwt = JWT::encode($payload, $secret_key, 'HS256');
                    $_SESSION['jwt_token'] = $jwt;

                    // HU09: Si el instructor debe cambiar su clave en el primer login
                    if (!empty($usuario['debe_cambiar_clave'])) {
                        $this->redirect('cambiar-clave');
                        return;
                    }

                    $this->redirigirPorRol($usuario['rol']);
                }
            }
        }

        $this->render('auth/login', [
            'accion' => 'ingresar',
            'error' => $error,
            'exito' => $exito,
            'programas' => $programas,
            'csrf' => $csrf
        ]);
    }

    /**
     * Procesa el registro de un nuevo aprendiz.
     */
    public function registrar(): void {
        if (estaAutenticado()) {
            $this->redirigirPorRol(obtenerRolSesion());
        }

        $error = '';
        $exito = '';
        $programas = $this->programaModel->obtenerTodos();
        $csrf = generarTokenCSRF();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('login');
        }

        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $error = 'Solicitud inválida. Recarga la página.';
        } else {
            $nombre = limpiar($_POST['nombre_completo'] ?? '');
            $correo = limpiar($_POST['correo'] ?? '');
            $ficha = limpiar($_POST['ficha_sena'] ?? '');
            $programa = limpiar($_POST['programa_id'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';

            if (empty($nombre) || empty($correo) || empty($contrasena)) {
                $error = 'Nombre, correo y contraseña son obligatorios.';
            } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $error = 'El correo no tiene un formato válido.';
            } elseif (strlen($contrasena) < 8 || !preg_match('/[A-Z]/', $contrasena) || !preg_match('/[0-9]/', $contrasena)) {
                $error = 'La contraseña debe tener mínimo 8 caracteres, 1 mayúscula y 1 número.';
            } else {
                if ($this->userModel->existeCorreo($correo)) {
                    $error = 'Este correo ya está registrado.';
                } else {
                    $hash = password_hash($contrasena, PASSWORD_BCRYPT, ['cost' => 12]);
                    $id = generarUUID();
                    
                    if ($this->userModel->registrar($id, $nombre, $correo, $hash, $ficha ?: null, $programa ?: null)) {
                        $exito = '¡Cuenta creada! Ya puedes iniciar sesión.';
                        $accion = 'ingresar';
                        
                        $this->render('auth/login', [
                            'accion' => 'ingresar',
                            'error' => '',
                            'exito' => $exito,
                            'programas' => $programas,
                            'csrf' => $csrf
                        ]);
                        return;
                    } else {
                        $error = 'Error interno al registrar la cuenta. Intenta más tarde.';
                    }
                }
            }
        }

        $this->render('auth/login', [
            'accion' => 'registrar',
            'error' => $error,
            'exito' => $exito,
            'programas' => $programas,
            'csrf' => $csrf
        ]);
    }

    /**
     * Procesa el cierre seguro de sesión.
     */
    public function logout(): void {
        cerrarSesion();
        $this->redirect('login');
    }

    /**
     * Muestra la pantalla de recuperar contraseña.
     */
    public function showRecuperar(): void {
        if (estaAutenticado()) {
            $this->redirect('');
        }

        $error = '';
        $exito = '';
        $csrf = generarTokenCSRF();

        $this->render('auth/recuperar', [
            'error' => $error,
            'exito' => $exito,
            'csrf' => $csrf
        ]);
    }

    /**
     * Procesa la solicitud y el envío del correo de recuperación.
     */
    public function enviarEnlace(): void {
        if (estaAutenticado()) {
            $this->redirect('');
        }

        $error = '';
        $exito = '';
        $csrf = generarTokenCSRF();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('recuperar');
        }

        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $error = 'Solicitud inválida. Recarga la página.';
        } else {
            $correo = limpiar($_POST['correo'] ?? '');
            if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $error = 'Ingresa un correo electrónico válido.';
            } else {
                $usuario = $this->userModel->obtenerPorCorreo($correo);

                if ($usuario) {
                    // Invalida tokens anteriores
                    $this->userModel->invalidarTokensRecuperacion($usuario['id']);

                    // Genera nuevo token seguro de 64 bytes
                    $token_string = bin2hex(random_bytes(32));
                    $expira = date('Y-m-d H:i:s', strtotime('+24 hours'));
                    
                    $this->userModel->crearTokenRecuperacion($usuario['id'], $token_string, $expira);

                    // Construcción dinámica de la URI
                    $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
                    $enlace = $protocolo . $_SERVER['HTTP_HOST'] . PROYECTO_PATH . "/restablecer?token=" . $token_string;

                    $cuerpo = "<h1>Recuperación de Contraseña</h1>";
                    $cuerpo .= "<p>Hola " . limpiar($usuario['nombre_completo']) . ",</p>";
                    $cuerpo .= "<p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace. Este enlace expira en 24 horas.</p>";
                    $cuerpo .= "<p><a href='$enlace'>$enlace</a></p>";
                    $cuerpo .= "<p>Si no fuiste tú, ignora este mensaje.</p>";

                    if (file_exists(dirname(__DIR__, 2) . '/includes/correo.php')) {
                        require_once dirname(__DIR__, 2) . '/includes/correo.php';
                        enviarCorreo($correo, 'Recupera tu contraseña en SmashCode', $cuerpo);
                    }
                }
                
                // Siempre mostramos éxito por seguridad para no revelar si el correo existe
                $exito = 'Si el correo está registrado, te hemos enviado las instrucciones para restablecer tu contraseña.';
            }
        }

        $this->render('auth/recuperar', [
            'error' => $error,
            'exito' => $exito,
            'csrf' => $csrf
        ]);
    }

    /**
     * Muestra la pantalla para restablecer contraseña.
     */
    public function showRestablecer(): void {
        if (estaAutenticado()) {
            $this->redirect('');
        }

        $error = '';
        $exito = '';
        $csrf = generarTokenCSRF();
        $token = $_GET['token'] ?? ($_POST['token'] ?? '');

        if (empty($token)) {
            $this->redirect('login');
        }

        $tokenRow = $this->userModel->obtenerTokenValido($token);

        if (!$tokenRow) {
            $error = 'El enlace de recuperación es inválido o ha expirado. Por favor, solicita uno nuevo.';
        }

        $this->render('auth/restablecer', [
            'error' => $error,
            'exito' => $exito,
            'csrf' => $csrf,
            'token' => $token,
            'tokenRow' => $tokenRow
        ]);
    }

    /**
     * Procesa la actualización de la nueva contraseña.
     */
    public function guardarClave(): void {
        if (estaAutenticado()) {
            $this->redirect('');
        }

        $error = '';
        $exito = '';
        $csrf = generarTokenCSRF();
        $token = $_POST['token'] ?? '';

        if (empty($token)) {
            $this->redirect('login');
        }

        $tokenRow = $this->userModel->obtenerTokenValido($token);

        if (!$tokenRow) {
            $error = 'El enlace de recuperación es inválido o ha expirado. Por favor, solicita uno nuevo.';
        } else {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->redirect('login');
            }

            if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
                $error = 'Solicitud inválida. Recarga la página.';
            } else {
                $clave = $_POST['contrasena'] ?? '';
                
                if (strlen($clave) < 8 || !preg_match('/[A-Z]/', $clave) || !preg_match('/[0-9]/', $clave)) {
                    $error = 'La contraseña debe tener mínimo 8 caracteres, 1 mayúscula y 1 número.';
                } else {
                    $hash = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 12]);
                    
                    if ($this->userModel->restablecerContrasena($tokenRow['usuario_id'], $hash, $token)) {
                        $exito = 'Tu contraseña ha sido actualizada con éxito.';
                        $tokenRow = null; // Oculta el formulario
                    } else {
                        $error = 'Hubo un error al actualizar la contraseña.';
                    }
                }
            }
        }

        $this->render('auth/restablecer', [
            'error' => $error,
            'exito' => $exito,
            'csrf' => $csrf,
            'token' => $token,
            'tokenRow' => $tokenRow
        ]);
    }

    /**
     * Redirige al usuario a su panel de control según su rol.
     */
    private function redirigirPorRol(string $rol): void {
        if ($rol === 'admin') {
            $this->redirect('admin');
        } elseif ($rol === 'instructor') {
            $this->redirect('instructor');
        } else {
            $this->redirect('');
        }
    }

    /* ========================================================
     * HU09 — Cambio de contraseña forzado (primer login)
     * ======================================================== */

    /**
     * Muestra el formulario de cambio de contraseña obligatorio.
     * Solo accesible si se está autenticado y la sesión tiene debe_cambiar_clave.
     */
    public function showCambiarClave(): void {
        if (!estaAutenticado()) {
            $this->redirect('login');
        }

        // Si el usuario no necesita cambiar clave, redirigir a su panel
        $usuario = $this->userModel->obtenerPorId($_SESSION['usuario_id']);
        if (!$usuario || empty($usuario['debe_cambiar_clave'])) {
            $this->redirigirPorRol($_SESSION['rol']);
        }

        $this->render('auth/cambiar_clave', [
            'error' => '',
            'csrf'  => generarTokenCSRF(),
        ]);
    }

    /**
     * Procesa el cambio de contraseña forzado del instructor.
     * Tras guardar exitosamente, limpia el flag debe_cambiar_clave.
     */
    public function guardarCambiarClave(): void {
        if (!estaAutenticado()) {
            $this->redirect('login');
        }

        $csrf = generarTokenCSRF();

        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->render('auth/cambiar_clave', [
                'error' => 'Solicitud inválida. Recarga la página.',
                'csrf'  => $csrf,
            ]);
            return;
        }

        $claveNueva   = $_POST['contrasena'] ?? '';
        $claveConfirm = $_POST['contrasena_confirmar'] ?? '';

        $errores = [];
        if (strlen($claveNueva) < 8)                      $errores[] = 'Mín. 8 caracteres.';
        if (!preg_match('/[A-Z]/', $claveNueva))          $errores[] = 'Al menos 1 mayúscula.';
        if (!preg_match('/[0-9]/', $claveNueva))          $errores[] = 'Al menos 1 número.';
        if ($claveNueva !== $claveConfirm)                $errores[] = 'Las contraseñas no coinciden.';

        if ($errores) {
            $this->render('auth/cambiar_clave', [
                'error' => implode(' ', $errores),
                'csrf'  => $csrf,
            ]);
            return;
        }

        $hash = password_hash($claveNueva, PASSWORD_BCRYPT, ['cost' => 12]);
        $this->userModel->actualizarContrasenaYLimpiarFlag($_SESSION['usuario_id'], $hash);

        // Redirigir al panel correspondiente con mensaje de éxito
        $this->redirigirPorRol($_SESSION['rol']);
    }
}
