<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;
use App\Models\GestionUsuarios;
use App\Models\Programa;

/**
 * AdminController.php
 * Controlador para las vistas y lógica administrativa del sistema SmashCode.
 * Incluye la gestión completa de usuarios (HU04).
 */
class AdminController extends Controller {

    private Admin $adminModel;
    private GestionUsuarios $usuarioModel;
    private Programa $programaModel;

    public function __construct() {
        parent::__construct();
        $this->adminModel   = new Admin();
        $this->usuarioModel = new GestionUsuarios();
        $this->programaModel = new Programa();
        iniciarSesion();

        // Verificar rol administrador obligatoriamente
        if (!estaAutenticado() || obtenerRolSesion() !== 'admin') {
            $this->redirect('login');
        }
    }

    /**
     * Muestra el panel de control administrativo general.
     */
    public function index(): void {
        $totalUsuarios     = $this->adminModel->obtenerTotalUsuarios();
        $aprendicesActivos = $this->adminModel->obtenerAprendicesActivos();
        $totalXP           = $this->adminModel->obtenerTotalXP();
        $quizzesCompletos  = $this->adminModel->obtenerQuizzesCompletados();
        $actividad         = $this->adminModel->obtenerActividadReciente();

        $this->render('admin/dashboard', [
            'totalUsuarios'     => $totalUsuarios,
            'aprendicesActivos' => $aprendicesActivos,
            'totalXP'           => $totalXP,
            'quizzesCompletos'  => $quizzesCompletos,
            'actividad'         => $actividad
        ]);
    }

    /* ========================================================
     * HU04 — Gestión de Usuarios
     * ======================================================== */

    /**
     * Lista paginada con búsqueda de usuarios.
     */
    public function usuarios(): void {
        $busqueda = limpiar($_GET['busqueda'] ?? '');
        $rol      = limpiar($_GET['rol'] ?? '');
        $pagina   = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina = 15;

        $lista  = $this->usuarioModel->listar($busqueda, $rol, $pagina, $porPagina);
        $total  = $this->usuarioModel->contarTotal($busqueda, $rol);
        $paginas = (int) ceil($total / $porPagina);
        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();
        $programas     = $this->programaModel->obtenerTodos();

        $this->render('admin/usuarios', compact(
            'lista', 'total', 'paginas', 'pagina', 'busqueda', 'rol', 'totalUsuarios', 'programas'
        ));
    }

    /**
     * Muestra el formulario de creación de usuario.
     */
    public function crearUsuario(): void {
        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();
        $this->render('admin/usuario_form', [
            'usuario'      => null,
            'totalUsuarios' => $totalUsuarios,
            'modoEditar'   => false,
            'error'        => '',
            'exito'        => ''
        ]);
    }

    /**
     * Procesa el guardado de un nuevo usuario.
     */
    public function guardarUsuario(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/usuarios');
        }

        $nombre    = limpiar($_POST['nombre_completo'] ?? '');
        $correo    = limpiar($_POST['correo'] ?? '');
        $rol       = limpiar($_POST['rol'] ?? 'aprendiz');
        $ficha     = limpiar($_POST['ficha_sena'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';

        $errores = $this->validarCamposUsuario($nombre, $correo, $contrasena);

        if ($errores) {
            $this->redirect('admin/usuarios?error=' . urlencode(implode(' ', $errores)));
            return;
        }

        if ($this->usuarioModel->existeCorreo($correo)) {
            $this->redirect('admin/usuarios?error=' . urlencode('Ese correo ya está registrado en el sistema.'));
            return;
        }

        $hash = password_hash($contrasena, PASSWORD_BCRYPT, ['cost' => 12]);
        $id   = generarUUID();
        $this->usuarioModel->crear($id, $nombre, $correo, $hash, $rol, $ficha ?: null);

        $this->redirect('admin/usuarios?exito=creado');
    }

    /**
     * Muestra el formulario de edición de un usuario existente.
     */
    public function editarUsuario(): void {
        $id = limpiar($_GET['id'] ?? '');
        $usuario = $this->usuarioModel->obtenerPorId($id);

        if (!$usuario) {
            $this->redirect('admin/usuarios');
        }

        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();
        $this->render('admin/usuario_form', [
            'usuario'      => $usuario,
            'totalUsuarios' => $totalUsuarios,
            'modoEditar'   => true,
            'error'        => '',
            'exito'        => ''
        ]);
    }

    /**
     * Procesa la actualización de datos de un usuario (sin cambiar contraseña).
     */
    public function actualizarUsuario(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/usuarios');
        }

        $id     = limpiar($_POST['id'] ?? '');
        $nombre = limpiar($_POST['nombre_completo'] ?? '');
        $correo = limpiar($_POST['correo'] ?? '');
        $rol    = limpiar($_POST['rol'] ?? 'aprendiz');
        $ficha  = limpiar($_POST['ficha_sena'] ?? '');

        if (empty($id) || empty($nombre) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('admin/usuarios?error=' . urlencode('El nombre es obligatorio y el correo electrónico debe tener un formato válido.'));
            return;
        }

        $this->usuarioModel->actualizar($id, $nombre, $correo, $rol, $ficha ?: null);
        $this->redirect('admin/usuarios?exito=actualizado');
    }

    /**
     * Suspende o reactiva (soft-disable) a un usuario de forma inmediata.
     */
    public function suspenderUsuario(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/usuarios');
        }

        $id     = limpiar($_POST['id'] ?? '');
        $activo = (int)($_POST['activo'] ?? 0);

        if (!empty($id)) {
            $this->usuarioModel->cambiarEstado($id, $activo === 1 ? 0 : 1);
        }

        $this->redirect('admin/usuarios?exito=estado');
    }

    /**
     * Soft-delete de un usuario: marca la cuenta como eliminada sin borrarla físicamente.
     */
    public function eliminarUsuario(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/usuarios');
        }

        $id = limpiar($_POST['id'] ?? '');
        if (!empty($id)) {
            $this->usuarioModel->softDelete($id);
        }

        $this->redirect('admin/usuarios?exito=eliminado');
    }

    /**
     * Muestra el log de actividad de un usuario específico.
     */
    public function actividadUsuario(): void {
        $id      = limpiar($_GET['id'] ?? '');
        $usuario = $this->usuarioModel->obtenerPorId($id);

        if (!$usuario) {
            if (isset($_GET['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Usuario no encontrado']);
                return;
            }
            $this->redirect('admin/usuarios');
        }

        $log = $this->usuarioModel->obtenerActividad($id);

        if (isset($_GET['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'usuario' => $usuario,
                'logs'    => $log
            ]);
            return;
        }

        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();
        $this->render('admin/usuario_actividad', compact('usuario', 'log', 'totalUsuarios'));
    }

    /* ========================================================
     * HU09 — Crear Cuentas de Instructor con Credenciales Temporales
     * ======================================================== */

    /**
     * Muestra el formulario de alta de instructor con credenciales temporales.
     */
    public function crearInstructor(): void {
        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();
        $programas     = $this->programaModel->obtenerTodos();
        $this->render('admin/instructor_form', [
            'error'         => '',
            'totalUsuarios' => $totalUsuarios,
            'programas'     => $programas,
            'datos'         => [],
        ]);
    }

    /**
     * Procesa la creación de un instructor:
     *   1. Valida datos.
     *   2. Genera contraseña temporal segura.
     *   3. Guarda en BD con debe_cambiar_clave = 1.
     *   4. Envía correo con las credenciales al instructor.
     */
    public function guardarInstructor(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/usuarios');
        }

        $nombre     = limpiar($_POST['nombre_completo'] ?? '');
        $correo     = limpiar($_POST['correo'] ?? '');
        $programaId = limpiar($_POST['programa_id'] ?? '');
        $ficha      = limpiar($_POST['ficha_sena'] ?? '');

        // Validaciones básicas
        $errores = [];
        if (empty($nombre))                               $errores[] = 'El nombre es obligatorio.';
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL))  $errores[] = 'Correo inválido.';

        if ($errores) {
            $this->redirect('admin/usuarios?error=' . urlencode(implode(' ', $errores)));
            return;
        }

        if ($this->usuarioModel->existeCorreo($correo)) {
            $this->redirect('admin/usuarios?error=' . urlencode('Ese correo ya está registrado en el sistema.'));
            return;
        }

        // Generar contraseña temporal aleatoria de 12 caracteres
        $claveTemp = $this->generarClaveTemp();
        $hash = password_hash($claveTemp, PASSWORD_BCRYPT, ['cost' => 12]);
        $id   = generarUUID();

        $this->usuarioModel->crearInstructor($id, $nombre, $correo, $hash, $programaId ?: null, $ficha ?: null);

        // Enviar credenciales al correo del instructor
        $protocolp = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $urlLogin  = $protocolp . $_SERVER['HTTP_HOST'] . PROYECTO_PATH . '/login';

        // Resolver nombre del programa para el correo
        $nombrePrograma = '';
        if ($programaId) {
            foreach ($programas as $p) {
                if ($p['id'] === $programaId) {
                    $nombrePrograma = $p['nombre'];
                    break;
                }
            }
        }

        $asunto = '¡Bienvenido a SmashCode! Tus credenciales de acceso';
        $cuerpo  = "<h2 style='color:#58CC02;'>¡Bienvenido(a) al equipo SmashCode!</h2>";
        $cuerpo .= "<p>Hola <strong>" . htmlspecialchars($nombre) . "</strong>,</p>";
        $cuerpo .= "<p>El administrador ha creado tu cuenta como <strong>Instructor</strong> en la plataforma SmashCode SENA.</p>";
        $cuerpo .= "<table style='border-collapse:collapse; font-size:1rem; margin:16px 0;'>";
        $cuerpo .= "<tr><td style='padding:8px 16px 8px 0; font-weight:600; color:#555;'>Correo:</td><td style='padding:8px 0; font-family:monospace;'>" . htmlspecialchars($correo) . "</td></tr>";
        $cuerpo .= "<tr><td style='padding:8px 16px 8px 0; font-weight:600; color:#555;'>Contraseña temporal:</td><td style='padding:8px 0; font-family:monospace; font-size:1.2rem; letter-spacing:2px; background:#f4f4f4; padding:6px 12px; border-radius:4px;'>" . htmlspecialchars($claveTemp) . "</td></tr>";
        if ($ficha) {
            $cuerpo .= "<tr><td style='padding:8px 16px 8px 0; font-weight:600; color:#555;'>Ficha SENA:</td><td style='padding:8px 0;'>" . htmlspecialchars($ficha) . "</td></tr>";
        }
        if ($nombrePrograma) {
            $cuerpo .= "<tr><td style='padding:8px 16px 8px 0; font-weight:600; color:#555;'>Programa asignado:</td><td style='padding:8px 0;'>" . htmlspecialchars($nombrePrograma) . "</td></tr>";
        }
        $cuerpo .= "</table>";
        $cuerpo .= "<p>⚠️ <strong>Deberás cambiar esta contraseña en tu primer inicio de sesión.</strong></p>";
        $cuerpo .= "<p><a href='{$urlLogin}' style='display:inline-block; background:#58CC02; color:#fff; padding:12px 28px; border-radius:24px; text-decoration:none; font-weight:700; font-size:1rem;'>Ingresar a SmashCode</a></p>";
        $cuerpo .= "<hr><p style='font-size:0.8rem; color:#aaa;'>Si tienes algún problema para acceder, contacta al administrador del sistema.</p>";

        if (file_exists(dirname(__DIR__, 2) . '/includes/correo.php')) {
            require_once dirname(__DIR__, 2) . '/includes/correo.php';
            enviarCorreo($correo, $asunto, $cuerpo);
        }

        $this->redirect('admin/usuarios?exito=instructor_creado');
    }

    /**
     * Genera una contraseña temporal segura de 12 caracteres:
     * garantiza al menos 1 mayúscula, 1 número y 1 símbolo.
     */
    private function generarClaveTemp(): string {
        $mayus   = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $minuscu = 'abcdefghjkmnpqrstuvwxyz';
        $numeros = '23456789';
        $simbol  = '!@#$%&*?';

        $clave  = $mayus[random_int(0, strlen($mayus) - 1)];
        $clave .= $numeros[random_int(0, strlen($numeros) - 1)];
        $clave .= $simbol[random_int(0, strlen($simbol) - 1)];

        $todos = $mayus . $minuscu . $numeros;
        for ($i = 0; $i < 9; $i++) {
            $clave .= $todos[random_int(0, strlen($todos) - 1)];
        }

        // Mezclar caracteres aleatoriamente
        return str_shuffle($clave);
    }

    /* ======================================================== */

    /**
     * Valida campos básicos de usuario. Retorna array de errores.
     */
    private function validarCamposUsuario(string $nombre, string $correo, string $contrasena): array {
        $errores = [];
        if (empty($nombre))                               $errores[] = 'El nombre es obligatorio.';
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL))  $errores[] = 'Correo inválido.';
        if (strlen($contrasena) < 8)                      $errores[] = 'La contraseña debe tener mínimo 8 caracteres.';
        if (!preg_match('/[A-Z]/', $contrasena))          $errores[] = 'Incluye al menos 1 mayúscula.';
        if (!preg_match('/[0-9]/', $contrasena))          $errores[] = 'Incluye al menos 1 número.';
        return $errores;
    }
}
