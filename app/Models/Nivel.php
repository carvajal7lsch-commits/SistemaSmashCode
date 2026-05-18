<?php
namespace App\Models;

use App\Core\Model;

/**
 * Nivel.php
 * Modelo de negocio para la gestión de Niveles de Aprendizaje y RAPs.
 * Centraliza las consultas relacionadas con las etapas del mapa gamificado de SmashCode.
 */
class Nivel extends Model {

    /**
     * Obtiene todos los niveles activos junto con sus RAPs (Resultados de Aprendizaje) asociados.
     */
    public function obtenerNivelesConRaps(): array {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->query(
            'SELECT n.id, n.nombre, n.descripcion, n.orden, n.activo, n.umbral_desbloqueo,
                    r.id AS rap_id, r.titulo AS rap_titulo
             FROM nivel n
             LEFT JOIN rap r ON r.nivel_id = n.id AND r.activo = 1
             WHERE n.activo = 1
             ORDER BY n.orden'
        );
        return $stmt->fetchAll();
    }
}
