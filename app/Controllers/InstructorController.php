<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Instructor;

/**
 * InstructorController.php
 * Controlador para las vistas y reportes del Instructor en SmashCode.
 */
class InstructorController extends Controller {

    private Instructor $instructorModel;

    public function __construct() {
        parent::__construct();
        $this->instructorModel = new Instructor();
        iniciarSesion();

        // Verificar rol instructor obligatoriamente
        if (!estaAutenticado() || obtenerRolSesion() !== 'instructor') {
            $this->redirect('login');
        }
    }

    /**
     * Muestra el dashboard del instructor con el listado y progreso de sus alumnos.
     */
    public function index(): void {
        $totalAprendices = $this->instructorModel->obtenerTotalAprendices();
        $completaronAlgo = $this->instructorModel->obtenerCompletaronAlgo();
        $promedioQuiz = $this->instructorModel->obtenerPromedioQuiz();
        $aprendices = $this->instructorModel->obtenerListadoAprendices();

        $this->render('instructor/dashboard', [
            'totalAprendices' => $totalAprendices,
            'completaronAlgo' => $completaronAlgo,
            'promedioQuiz' => $promedioQuiz,
            'aprendices' => $aprendices
        ]);
    }
}
