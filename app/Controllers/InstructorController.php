<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Instructor;
use App\Models\Nivel;

/**
 * InstructorController.php
 * Controlador para las vistas y reportes del Instructor en SmashCode.
 * Incluye gestión de Niveles (HU10).
 */
class InstructorController extends Controller {

    private Instructor $instructorModel;
    private Nivel $nivelModel;

    public function __construct() {
        parent::__construct();
        $this->instructorModel = new Instructor();
        $this->nivelModel      = new Nivel();
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
        $promedioQuiz    = $this->instructorModel->obtenerPromedioQuiz();
        $aprendices      = $this->instructorModel->obtenerListadoAprendices();

        $this->render('instructor/dashboard', [
            'totalAprendices' => $totalAprendices,
            'completaronAlgo' => $completaronAlgo,
            'promedioQuiz'    => $promedioQuiz,
            'aprendices'      => $aprendices
        ]);
    }

    /* ========================================================
     * HU10 — Gestión de Niveles (6 niveles fijos MCER)
     * ======================================================== */

    /**
     * Lista los 6 niveles con estadísticas de RAPs.
     */
    public function niveles(): void {
        $niveles = $this->nivelModel->obtenerTodos();
        $exito   = limpiar($_GET['exito'] ?? '');
        $error   = limpiar($_GET['error']  ?? '');

        $this->render('instructor/niveles', compact('niveles', 'exito', 'error'));
    }

    /**
     * Muestra el formulario de edición de un nivel.
     */
    public function editarNivel(): void {
        $id    = limpiar($_GET['id'] ?? '');
        $nivel = $this->nivelModel->obtenerPorId($id);

        if (!$nivel) {
            $this->redirect('instructor/niveles?error=' . urlencode('Nivel no encontrado.'));
        }

        $this->render('instructor/nivel_form', compact('nivel'));
    }

    /**
     * Procesa la actualización de un nivel.
     */
    public function actualizarNivel(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('instructor/niveles');
        }

        $id          = limpiar($_POST['id'] ?? '');
        $nombre      = limpiar($_POST['nombre'] ?? '');
        $descripcion = limpiar($_POST['descripcion'] ?? '');
        $imagenUrl   = limpiar($_POST['imagen_url'] ?? '') ?: null;
        $umbral      = (float)($_POST['umbral_desbloqueo'] ?? 80);
        $activo      = isset($_POST['activo']) ? 1 : 0;

        if (empty($id) || empty($nombre)) {
            $this->redirect('instructor/niveles?error=' . urlencode('El nombre del nivel es obligatorio.'));
            return;
        }

        $nivel = $this->nivelModel->obtenerPorId($id);
        if (!$nivel) {
            $this->redirect('instructor/niveles?error=' . urlencode('Nivel no encontrado.'));
            return;
        }

        // El nivel 1 (orden=1) siempre tiene umbral 0
        if ((int)$nivel['orden'] === 1) {
            $umbral = 0.00;
        }

        $this->nivelModel->actualizar($id, $nombre, $descripcion, $imagenUrl, $umbral, $activo);
        $this->redirect('instructor/niveles?exito=actualizado');
    }

    /**
     * Alterna el estado activo/inactivo de un nivel.
     */
    public function toggleNivel(): void {
        if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $this->redirect('instructor/niveles');
        }

        $id = limpiar($_POST['id'] ?? '');
        if (!empty($id)) {
            $this->nivelModel->toggleActivo($id);
        }

        $this->redirect('instructor/niveles?exito=estado');
    }
}
