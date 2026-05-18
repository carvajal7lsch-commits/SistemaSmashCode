<?php
namespace App\Models;

use App\Core\Model;
use PDO;
use Exception;

/**
 * User.php
 * Modelo de negocio para la gestión de Usuarios y Tokens de Recuperación.
 * Agrupa toda la lógica e interacciones seguras con la base de datos para la entidad de usuarios.
 */
class User extends Model {

    /**
     * Busca un usuario por su correo electrónico.
     */
    public function obtenerPorCorreo(string $correo): ?array {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('SELECT id, nombre_completo, contrasena, rol, activo, bloqueado, intentos_fallidos, debe_cambiar_clave FROM usuarios WHERE correo = ? LIMIT 1');
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();
        return $usuario ?: null;
    }

    /**
     * Busca un usuario por su ID único (incluyendo el flag de primer login).
     */
    public function obtenerPorId(string $id): ?array {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('SELECT nombre_completo, xp_puntos, nivel_perfil, rol, correo, debe_cambiar_clave FROM usuarios WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();
        return $usuario ?: null;
    }

    /**
     * Verifica si un correo electrónico ya está registrado en la base de datos.
     */
    public function existeCorreo(string $correo): bool {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE correo = ? LIMIT 1');
        $stmt->execute([$correo]);
        return (bool) $stmt->fetch();
    }

    /**
     * Registra un nuevo aprendiz.
     */
    public function registrar(string $id, string $nombre, string $correo, string $hashContrasena, ?string $fichaSena, ?string $programaId): bool {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('INSERT INTO usuarios (id, nombre_completo, correo, contrasena, ficha_sena, programa_id, rol) VALUES (?, ?, ?, ?, ?, ?, "aprendiz")');
        return $stmt->execute([$id, $nombre, $correo, $hashContrasena, $fichaSena ?: null, $programaId ?: null]);
    }

    /**
     * Actualiza la cantidad de intentos fallidos y el estado de bloqueo de una cuenta.
     */
    public function actualizarIntentosFallidos(string $id, int $intentos, int $bloqueado): bool {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE usuarios SET intentos_fallidos = ?, bloqueado = ? WHERE id = ?');
        return $stmt->execute([$intentos, $bloqueado, $id]);
    }

    /**
     * Resetea el contador de intentos fallidos a cero.
     */
    public function resetearIntentosFallidos(string $id): bool {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE usuarios SET intentos_fallidos = 0 WHERE id = ?');
        return $stmt->execute([$id]);
    }

    /**
     * Invalida (marca como usados) todos los tokens de recuperación de un usuario.
     */
    public function invalidarTokensRecuperacion(string $usuarioId): bool {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE token_recuperacion SET usado = 1 WHERE usuario_id = ?');
        return $stmt->execute([$usuarioId]);
    }

    /**
     * Inserta un nuevo token de recuperación de contraseña.
     */
    public function crearTokenRecuperacion(string $usuarioId, string $token, string $expiraEn): bool {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('INSERT INTO token_recuperacion (usuario_id, token, expira_en) VALUES (?, ?, ?)');
        return $stmt->execute([$usuarioId, $token, $expiraEn]);
    }

    /**
     * Valida si un token existe, no ha sido usado y no ha expirado.
     */
    public function obtenerTokenValido(string $token): ?array {
        $pdo = self::obtenerConexion();
        $stmt = $pdo->prepare('SELECT usuario_id FROM token_recuperacion WHERE token = ? AND usado = 0 AND expira_en > NOW() LIMIT 1');
        $stmt->execute([$token]);
        $tokenRow = $stmt->fetch();
        return $tokenRow ?: null;
    }

    /**
     * Restablece la contraseña de un usuario, desbloquea la cuenta,
     * reinicia sus intentos fallidos y consume el token de seguridad.
     * Se realiza dentro de una transacción para garantizar integridad.
     */
    public function restablecerContrasena(string $usuarioId, string $hashContrasena, string $token): bool {
        $pdo = self::obtenerConexion();
        $pdo->beginTransaction();
        try {
            // 1. Actualizar contraseña y desbloquear cuenta si estaba bloqueada
            $stmt1 = $pdo->prepare('UPDATE usuarios SET contrasena = ?, intentos_fallidos = 0, bloqueado = 0 WHERE id = ?');
            $stmt1->execute([$hashContrasena, $usuarioId]);

            // 2. Marcar token de recuperación como usado
            $stmt2 = $pdo->prepare('UPDATE token_recuperacion SET usado = 1 WHERE token = ?');
            $stmt2->execute([$token]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log('[User Model] Error en restablecerContrasena: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * HU09: Actualiza la contraseña de un instructor y limpia el flag debe_cambiar_clave.
     * Se usa después del primer inicio de sesión con credenciales temporales.
     */
    public function actualizarContrasenaYLimpiarFlag(string $usuarioId, string $hashContrasena): bool {
        $pdo  = self::obtenerConexion();
        $stmt = $pdo->prepare(
            'UPDATE usuarios SET contrasena = ?, debe_cambiar_clave = 0, intentos_fallidos = 0, bloqueado = 0 WHERE id = ?'
        );
        return $stmt->execute([$hashContrasena, $usuarioId]);
    }
}

