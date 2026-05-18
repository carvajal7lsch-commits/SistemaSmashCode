<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;

/**
 * AdminController.php
 * Controlador para las vistas y lógica administrativa del sistema SmashCode.
 */
class AdminController extends Controller {

    private Admin $adminModel;

    public function __construct() {
        parent::__construct();
        $this->adminModel = new Admin();
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
        $totalUsuarios = $this->adminModel->obtenerTotalUsuarios();
        $aprendicesActivos = $this->adminModel->obtenerAprendicesActivos();
        $totalXP = $this->adminModel->obtenerTotalXP();
        $quizzesCompletos = $this->adminModel->obtenerQuizzesCompletados();
        $actividad = $this->adminModel->obtenerActividadReciente();

        $this->render('admin/dashboard', [
            'totalUsuarios' => $totalUsuarios,
            'aprendicesActivos' => $aprendicesActivos,
            'totalXP' => $totalXP,
            'quizzesCompletos' => $quizzesCompletos,
            'actividad' => $actividad
        ]);
    }
}
