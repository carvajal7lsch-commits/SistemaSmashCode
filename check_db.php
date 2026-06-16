<?php
require_once 'config/sesion.php';
require_once 'includes/funciones.php';
require_once 'config/conexion.php';
require_once 'app/Core/Autoloader.php';
App\Core\Autoloader::registrar();

$pdo = obtenerConexion();

echo "=== NIVELES Y RAPs ===\n";
$stmt = $pdo->query("SELECT * FROM nivel");
$niveles = $stmt->fetchAll();
foreach ($niveles as $n) {
    echo "Nivel: {$n['nombre']} (ID: {$n['id']}, Orden: {$n['orden']}, Activo: {$n['activo']}, Umbral: {$n['umbral_desbloqueo']})\n";
    $stmt2 = $pdo->prepare("SELECT * FROM rap WHERE nivel_id = ?");
    $stmt2->execute([$n['id']]);
    $raps = $stmt2->fetchAll();
    foreach ($raps as $r) {
        echo "  -> RAP: {$r['titulo']} (ID: {$r['id']}, Activo: {$r['activo']})\n";
    }
}

echo "\n=== VOCABULARIO COUNT ===\n";
echo "Total vocabulario: " . $pdo->query("SELECT COUNT(*) FROM vocabulario")->fetchColumn() . "\n";

echo "\n=== DIALOGO COUNT ===\n";
echo "Total diálogos: " . $pdo->query("SELECT COUNT(*) FROM dialogo")->fetchColumn() . "\n";

echo "\n=== EJERCICIO COUNT ===\n";
echo "Total ejercicios: " . $pdo->query("SELECT COUNT(*) FROM ejercicio")->fetchColumn() . "\n";

echo "\n=== QUIZ COUNT ===\n";
echo "Total quizzes: " . $pdo->query("SELECT COUNT(*) FROM quiz")->fetchColumn() . "\n";
