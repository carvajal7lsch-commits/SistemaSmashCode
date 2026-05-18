<?php
namespace App\Models;

use App\Core\Model;

/**
 * Programa.php
 * Modelo de negocio para la gestión de Programas de Formación del SENA.
 */
class Programa extends Model {

    /**
     * Obtiene todos los programas de formación ordenados por su nombre.
     */
    public function obtenerTodos(): array {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->query('SELECT id, nombre FROM programa_formacion ORDER BY nombre');
        return $stmt->fetchAll();
    }
}
