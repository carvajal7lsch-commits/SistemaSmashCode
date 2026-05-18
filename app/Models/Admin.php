<?php
namespace App\Models;

use App\Core\Model;

/**
 * Admin.php
 * Modelo de negocio para la gestión administrativa y estadísticas globales (KPIs).
 */
class Admin extends Model {

    /**
     * Obtiene el número total de usuarios registrados con el rol de aprendiz.
     */
    public function obtenerTotalUsuarios(): int {
        $pdo = self::obtenerConexion();
        return (int) $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'aprendiz'")->fetchColumn();
    }

    /**
     * Obtiene el número de aprendices activos.
     */
    public function obtenerAprendicesActivos(): int {
        $pdo = self::obtenerConexion();
        return (int) $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'aprendiz' AND activo = 1")->fetchColumn();
    }

    /**
     * Obtiene la suma total de puntos XP acumulados por todos los usuarios.
     */
    public function obtenerTotalXP(): int {
        $pdo = self::obtenerConexion();
        return (int) $pdo->query("SELECT COALESCE(SUM(xp_puntos), 0) FROM usuarios")->fetchColumn();
    }

    /**
     * Obtiene el total de quizzes aprobados (completados).
     */
    public function obtenerQuizzesCompletados(): int {
        $pdo = self::obtenerConexion();
        return (int) $pdo->query("SELECT COUNT(*) FROM intento_quiz WHERE aprobado = 1")->fetchColumn();
    }

    /**
     * Obtiene la lista de los últimos 5 intentos de quizzes aprobados o reprobados.
     */
    public function obtenerActividadReciente(): array {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->query(
            "SELECT u.nombre_completo, iq.puntaje, iq.aprobado, iq.creado_en, r.titulo AS rap_titulo
             FROM intento_quiz iq
             JOIN usuarios u ON u.id = iq.usuario_id
             JOIN quiz q     ON q.id = iq.quiz_id
             JOIN rap r      ON r.id = q.rap_id
             ORDER BY iq.creado_en DESC LIMIT 5"
        );
        return $stmt->fetchAll();
    }
}
