<?php
/**
 * crear_usuarios.php — Script temporal para insertar usuarios con hash correcto.
 * ELIMINAR ESTE ARCHIVO después de ejecutarlo una sola vez.
 */
require_once __DIR__ . '/config/conexion.php';

function uuid(): string {
    $d = random_bytes(16);
    $d[6] = chr(ord($d[6]) & 0x0f | 0x40);
    $d[8] = chr(ord($d[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($d), 4));
}

$pdo = obtenerConexion();

$usuarios = [
    [
        'id'             => uuid(),
        'nombre'         => 'Administrador SENA',
        'correo'         => 'admin@smashcode.edu.co',
        'clave'          => 'Admin2025',
        'rol'            => 'admin',
    ],
    [
        'id'             => uuid(),
        'nombre'         => 'Instructor Demo',
        'correo'         => 'instructor@smashcode.edu.co',
        'clave'          => 'Instructor2025',
        'rol'            => 'instructor',
        'debe_cambiar'   => 1,
    ],
];

$stmt = $pdo->prepare(
    'INSERT INTO usuarios (id, nombre_completo, correo, contrasena, rol, activo, correo_verificado, debe_cambiar_clave)
     VALUES (?, ?, ?, ?, ?, 1, 1, ?)'
);

foreach ($usuarios as $u) {
    $hash = password_hash($u['clave'], PASSWORD_BCRYPT, ['cost' => 12]);
    $stmt->execute([
        $u['id'],
        $u['nombre'],
        $u['correo'],
        $hash,
        $u['rol'],
        $u['debe_cambiar'] ?? 0,
    ]);
    echo "✅ Creado: {$u['correo']} / {$u['clave']}<br>";
}
echo "<br><strong>Listo. Elimina este archivo ahora.</strong>";
