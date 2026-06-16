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
            'SELECT p.rap_id, p.porcentaje, p.completado, p.mejor_puntaje_quiz, r.titulo, r.nivel_id, n.nombre AS nombre_nivel, n.orden AS orden_nivel
             FROM progreso p
             JOIN rap r ON r.id = p.rap_id
             JOIN nivel n ON n.id = r.nivel_id
             WHERE p.usuario_id = ?
             ORDER BY n.orden'
        );
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }

    /**
     * Actualiza o inserta el progreso de un usuario para un RAP específico.
     */
    public function actualizarProgreso(string $usuarioId, string $rapId, float $porcentaje, int $completado): bool {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('SELECT id, porcentaje, completado FROM progreso WHERE usuario_id = ? AND rap_id = ? LIMIT 1');
        $stmt->execute([$usuarioId, $rapId]);
        $row = $stmt->fetch();

        if ($row) {
            $nuevoCompletado = $row['completado'] ? 1 : $completado;
            $nuevoPorcentaje = max((float)$row['porcentaje'], $porcentaje);
            $stmtUpdate = $pdo->prepare('UPDATE progreso SET porcentaje = ?, completado = ?, ultimo_acceso = NOW() WHERE usuario_id = ? AND rap_id = ?');
            return $stmtUpdate->execute([$nuevoPorcentaje, $nuevoCompletado, $usuarioId, $rapId]);
        } else {
            $stmtInsert = $pdo->prepare('INSERT INTO progreso (id, usuario_id, rap_id, porcentaje, completado, ultimo_acceso) VALUES (?, ?, ?, ?, ?, NOW())');
            return $stmtInsert->execute([generarUUID(), $usuarioId, $rapId, $porcentaje, $completado]);
        }
    }

    /**
     * Guarda el mejor puntaje del quiz para un RAP, conservando el mejor histórico.
     */
    public function guardarMejorPuntaje(string $usuarioId, string $rapId, float $puntaje): bool {
        $pdo = self::obtenerConexion();
        $stmtCheck = $pdo->prepare('SELECT id, mejor_puntaje_quiz FROM progreso WHERE usuario_id = ? AND rap_id = ? LIMIT 1');
        $stmtCheck->execute([$usuarioId, $rapId]);
        $row = $stmtCheck->fetch();

        if ($row) {
            $mejorPuntaje = max((float)$row['mejor_puntaje_quiz'], $puntaje);
            $stmtUpdate = $pdo->prepare('UPDATE progreso SET mejor_puntaje_quiz = ? WHERE usuario_id = ? AND rap_id = ?');
            return $stmtUpdate->execute([$mejorPuntaje, $usuarioId, $rapId]);
        } else {
            $stmtInsert = $pdo->prepare('INSERT INTO progreso (id, usuario_id, rap_id, porcentaje, completado, mejor_puntaje_quiz, ultimo_acceso) VALUES (?, ?, ?, 0.00, 0, ?, NOW())');
            return $stmtInsert->execute([generarUUID(), $usuarioId, $rapId, $puntaje]);
        }
    }
}
