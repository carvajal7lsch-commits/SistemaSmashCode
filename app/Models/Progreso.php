<?php
namespace App\Models;

use App\Core\Model;

/**
 * Progreso.php
 * Modelo de negocio para la gestión del progreso de los usuarios.
 * Mapea el avance de los aprendices en cada Resultado de Aprendizaje (RAP).
 */
class Progreso extends Model {

    /**
     * Obtiene el progreso de un usuario por RAP, incluyendo información del nivel.
     */
    public function obtenerProgresoPorUsuario(string $usuarioId): array {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT p.rap_id, p.porcentaje, p.completado, r.titulo, r.nivel_id, n.nombre AS nombre_nivel, n.orden AS orden_nivel
             FROM progreso p
             JOIN rap r ON r.id = p.rap_id
             JOIN nivel n ON n.id = r.nivel_id
             WHERE p.usuario_id = ?
             ORDER BY n.orden'
        );
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }
}
