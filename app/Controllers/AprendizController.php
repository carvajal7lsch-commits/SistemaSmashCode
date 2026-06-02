<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AprendizController extends Controller {

    public function __construct() {
        parent::__construct();
        iniciarSesion();
        if (!estaAutenticado() || obtenerRolSesion() !== 'aprendiz') {
            $this->redirect('login');
        }
    }

    public function vocabulario(): void {
        $this->render('aprendiz/vocabulario');
    }

    public function dialogos(): void {
        $this->render('aprendiz/dialogos');
    }

    public function ejercicios(): void {
        $this->render('aprendiz/ejercicios');
    }

    public function glosario(): void {
        $this->render('aprendiz/glosario');
    }

    public function perfil(): void {
        $uid = $_SESSION['usuario_id'] ?? null;
        if ($uid) {
            $userModel = new User();
            $usuario = $userModel->obtenerPorId($uid);
            $this->render('aprendiz/perfil', ['usuario' => $usuario]);
        } else {
            $this->redirect('login');
        }
    }

    public function actualizarPerfil(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('aprendiz/perfil?error=csrf');
            return;
        }

        $uid    = $_SESSION['usuario_id'] ?? null;
        $accion = limpiar($_POST['accion'] ?? '');

        if (!$uid) {
            $this->redirect('login');
            return;
        }

        $userModel = new User();
        $usuario   = $userModel->obtenerPorId($uid);

        if ($accion === 'nombre') {
            $nombre = trim(limpiar($_POST['nombre_completo'] ?? ''));
            if (empty($nombre)) {
                $this->redirect('aprendiz/perfil?error=nombre');
                return;
            }
            $userModel->actualizarNombre($uid, $nombre);
            $_SESSION['nombre'] = $nombre;
            $this->redirect('aprendiz/perfil?exito=nombre');

        } elseif ($accion === 'clave') {
            $claveActual   = $_POST['clave_actual']    ?? '';
            $claveNueva    = $_POST['clave_nueva']     ?? '';
            $claveConfirma = $_POST['clave_confirmar'] ?? '';

            // Verificar contraseña actual
            $hashActual = $userModel->obtenerHashContrasena($uid);
            if (!password_verify($claveActual, $hashActual)) {
                $this->redirect('aprendiz/perfil?error=clave_actual');
                return;
            }
            if (strlen($claveNueva) < 8) {
                $this->redirect('aprendiz/perfil?error=clave_corta');
                return;
            }
            if ($claveNueva !== $claveConfirma) {
                $this->redirect('aprendiz/perfil?error=clave_no_coincide');
                return;
            }

            $nuevoHash = password_hash($claveNueva, PASSWORD_BCRYPT, ['cost' => 12]);
            $userModel->actualizarContrasena($uid, $nuevoHash);
            $this->redirect('aprendiz/perfil?exito=clave');
        } else {
            $this->redirect('aprendiz/perfil');
        }
    }
}
