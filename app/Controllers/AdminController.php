<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;
use App\Models\GestionUsuarios;

/**
 * AdminController.php
 * Controlador para las vistas y lógica administrativa del sistema SmashCode.
 * Incluye la gestión completa de usuarios (HU04).
 */
class AdminController extends Controller {

    private Admin $adminModel;
    private GestionUsuarios $usuarioModel;

    public function __construct() {
        parent::__construct();
        $this->adminModel   = new Admin();
        $this->usuarioModel = new GestionUsuarios();
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

        $this->render('admin/usuarios', compact(
            'lista', 'total', 'paginas', 'pagina', 'busqueda', 'rol', 'totalUsuarios'
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
        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();

        $errores = $this->validarCamposUsuario($nombre, $correo, $contrasena);

        if ($errores) {
            $this->render('admin/usuario_form', [
                'usuario'      => compact('nombre', 'correo', 'rol', 'ficha'),
                'totalUsuarios' => $totalUsuarios,
                'modoEditar'   => false,
                'error'        => implode(' ', $errores),
                'exito'        => ''
            ]);
            return;
        }

        if ($this->usuarioModel->existeCorreo($correo)) {
            $this->render('admin/usuario_form', [
                'usuario'      => compact('nombre', 'correo', 'rol', 'ficha'),
                'totalUsuarios' => $totalUsuarios,
                'modoEditar'   => false,
                'error'        => 'Ese correo ya está registrado en el sistema.',
                'exito'        => ''
            ]);
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
            $this->redirect('admin/usuarios/editar?id=' . $id . '&error=datos');
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
            $this->redirect('admin/usuarios');
        }

        $log = $this->usuarioModel->obtenerActividad($id);
        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();

        $this->render('admin/usuario_actividad', compact('usuario', 'log', 'totalUsuarios'));
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
