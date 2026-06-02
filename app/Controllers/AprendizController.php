<?php
namespace App\Controllers;

use App\Core\Controller;

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
            $userModel = new \App\Models\User();
            $usuario = $userModel->obtenerPorId($uid);
            $this->render('aprendiz/perfil', ['usuario' => $usuario]);
        } else {
            $this->redirect('login');
        }
    }
}
