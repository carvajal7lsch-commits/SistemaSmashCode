<?php
namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Programa.php
 * Modelo de negocio para la gestión de Programas de Formación del SENA (HU17).
 * Soporta CRUD completo con soft-delete y asignación a usuarios.
 */
class Programa extends Model {

    /**
     * Obtiene todos los programas activos (para selectores en formularios).
     */
    public function obtenerTodos(): array {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->query(
            'SELECT id, nombre, descripcion
             FROM programa_formacion
             WHERE eliminado = 0 AND activo = 1
             ORDER BY nombre'
        );
        return $stmt->fetchAll();
    }

    /**
     * Lista todos los programas (activos e inactivos, sin eliminados) para el panel admin.
     */
    public function listarAdmin(): array {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->query(
            'SELECT p.id, p.nombre, p.descripcion, p.activo,
                    COUNT(u.id) AS total_usuarios
             FROM programa_formacion p
             LEFT JOIN usuarios u ON u.programa_id = p.id AND u.eliminado = 0
             WHERE p.eliminado = 0
             GROUP BY p.id, p.nombre, p.descripcion, p.activo
             ORDER BY p.nombre'
        );
        return $stmt->fetchAll();
    }

    /**
     * Obtiene un programa por su ID.
     */
    public function obtenerPorId(string $id): ?array {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT id, nombre, descripcion, activo
             FROM programa_formacion
             WHERE id = ? AND eliminado = 0
             LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Verifica si ya existe un programa con ese nombre.
     */
    public function existeNombre(string $nombre, string $excluirId = ''): bool {
        $pdo  = self::obtenerConexion();
        $sql  = 'SELECT id FROM programa_formacion WHERE nombre = ? AND eliminado = 0';
        $params = [$nombre];
        if ($excluirId !== '') {
            $sql    .= ' AND id != ?';
            $params[] = $excluirId;
        }
        $stmt = $pdo->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetch();
    }

    /**
     * Crea un nuevo programa de formación.
     */
    public function crear(string $id, string $nombre, ?string $descripcion): bool {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'INSERT INTO programa_formacion (id, nombre, descripcion, activo, eliminado)
             VALUES (?, ?, ?, 1, 0)'
        );
        return $stmt->execute([$id, $nombre, $descripcion]);
    }

    /**
     * Actualiza nombre y descripción de un programa.
     */
    public function actualizar(string $id, string $nombre, ?string $descripcion): bool {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'UPDATE programa_formacion SET nombre = ?, descripcion = ? WHERE id = ? AND eliminado = 0'
        );
        return $stmt->execute([$nombre, $descripcion, $id]);
    }

    /**
     * Desactiva (soft-disable) un programa. Los usuarios ya vinculados se conservan.
     * Un programa inactivo no aparece en los selectores de nuevas asignaciones.
     */
    public function desactivar(string $id): bool {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'UPDATE programa_formacion SET activo = IF(activo = 1, 0, 1) WHERE id = ? AND eliminado = 0'
        );
        return $stmt->execute([$id]);
    }

    /**
     * Soft-delete de un programa. Solo permitido si no tiene usuarios vinculados activos.
     */
    public function softDelete(string $id): bool {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'UPDATE programa_formacion SET eliminado = 1, activo = 0 WHERE id = ?'
        );
        return $stmt->execute([$id]);
    }

    /**
     * Verifica si el programa tiene usuarios activos vinculados.
     * Usado para impedir la eliminación física de programas en uso.
     */
    public function tieneUsuarios(string $id): bool {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM usuarios WHERE programa_id = ? AND eliminado = 0 LIMIT 1'
        );
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
