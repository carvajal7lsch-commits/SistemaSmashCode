<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log de Actividad — <?= limpiar($usuario['nombre_completo']) ?> — SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .linea-tiempo { list-style: none; padding: 0; margin: 0; position: relative; }
    .linea-tiempo::before {
      content: ''; position: absolute; left: 15px; top: 0; bottom: 0;
      width: 2px; background: var(--borde-sutil);
    }
    .lt-item {
      display: flex; gap: 16px; align-items: flex-start;
      padding: 12px 0 12px 10px; position: relative;
    }
    .lt-icono {
      width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.8rem; position: relative; z-index: 1;
    }
    .lt-quiz      { background: rgba(30,132,73,0.15); color: var(--verde-acento); }
    .lt-ejercicio { background: rgba(46,134,193,0.15); color: var(--azul-claro); }
    .lt-cuerpo { flex: 1; }
    .lt-titulo    { font-size: var(--texto-sm); font-weight: 700; color: var(--texto-principal); }
    .lt-detalle   { font-size: 0.78rem; color: var(--texto-secundario); margin-top: 2px; }
    .lt-fecha     { font-size: 0.7rem; color: var(--texto-tenue); margin-top: 4px; }
    .badge-correcto   { background: rgba(30,132,73,0.12);  color: var(--verde-acento); border-radius: 4px; padding: 1px 7px; font-size: 0.68rem; font-weight: 700; }
    .badge-incorrecto { background: rgba(231,76,60,0.12);  color: var(--rojo);         border-radius: 4px; padding: 1px 7px; font-size: 0.68rem; font-weight: 700; }
    .badge-aprobado   { background: rgba(30,132,73,0.12);  color: var(--verde-acento); border-radius: 4px; padding: 1px 7px; font-size: 0.68rem; font-weight: 700; }
    .badge-reprobado  { background: rgba(231,76,60,0.12);  color: var(--rojo);         border-radius: 4px; padding: 1px 7px; font-size: 0.68rem; font-weight: 700; }
    .perfil-card {
      display: flex; align-items: center; gap: 18px;
      background: var(--fondo-sidebar); padding: 18px 22px; border-radius: var(--radio);
      margin-bottom: 24px; border: 1px solid var(--borde-sutil);
    }
    .perfil-avatar {
      width: 56px; height: 56px; border-radius: 50%; background: var(--verde-salud);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem; font-weight: 900; color: #fff; flex-shrink: 0;
    }
  </style>
</head>
<body>
<div class="contenedor-app">

  <!-- Barra lateral -->
  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="contenido-principal">
    <header class="barra-superior">
      <div class="stat-xp"><i class="fas fa-clock-rotate-left"></i> Log de Actividad</div>
      <div class="avatar-usuario"><?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?></div>
    </header>

    <div class="pagina-contenido">
      <!-- Migas de pan -->
      <nav style="font-size: 0.78rem; color: var(--texto-tenue); margin-bottom: 20px;">
        <a href="<?= PROYECTO_PATH ?>/admin" style="color:var(--verde-acento);">Dashboard</a>
        <i class="fas fa-chevron-right" style="font-size:0.6rem; margin: 0 6px;"></i>
        <a href="<?= PROYECTO_PATH ?>/admin/usuarios" style="color:var(--verde-acento);">Usuarios</a>
        <i class="fas fa-chevron-right" style="font-size:0.6rem; margin: 0 6px;"></i>
        <span>Log de <?= limpiar($usuario['nombre_completo']) ?></span>
      </nav>

      <h1 class="pagina-titulo"><i class="fas fa-clock-rotate-left" style="color:var(--acento-oro);"></i> Historial de Actividad</h1>

      <!-- Perfil resumido -->
      <div class="perfil-card">
        <div class="perfil-avatar"><?= strtoupper(substr($usuario['nombre_completo'], 0, 1)) ?></div>
        <div>
          <div style="font-weight: 800; font-size: 1rem;"><?= limpiar($usuario['nombre_completo']) ?></div>
          <div style="font-size: 0.8rem; color: var(--texto-secundario);"><?= limpiar($usuario['correo']) ?></div>
          <div style="margin-top: 6px; display:flex; gap:8px; flex-wrap:wrap;">
            <span class="badge-rol badge-<?= $usuario['rol'] ?>"><?= ucfirst($usuario['rol']) ?></span>
            <span style="font-size:0.75rem; color:var(--acento-oro);"><i class="fas fa-bolt"></i> <?= number_format($usuario['xp_puntos']) ?> XP</span>
            <span style="font-size:0.75rem; color:var(--texto-tenue);"><i class="fas fa-calendar"></i> Desde <?= date('d/m/Y', strtotime($usuario['creado_en'])) ?></span>
          </div>
        </div>
        <div style="margin-left:auto;">
          <a href="<?= PROYECTO_PATH ?>/admin/usuarios/editar?id=<?= $usuario['id'] ?>" class="btn btn-verde">
            <i class="fas fa-pen-to-square"></i> Editar perfil
          </a>
        </div>
      </div>

      <!-- Línea de tiempo -->
      <div class="tarjeta">
        <div style="margin-bottom:16px;">
          <span style="font-size: var(--texto-sm); font-weight:600;">
            <i class="fas fa-stream" style="color:var(--verde-acento);"></i>
            Últimas <?= count($log) ?> interacciones
          </span>
        </div>

        <?php if (empty($log)): ?>
          <div style="text-align:center; padding: 40px 0; color: var(--texto-tenue);">
            <i class="fas fa-ghost" style="font-size:2.5rem; display:block; margin-bottom:10px;"></i>
            Este usuario aún no tiene actividad registrada.
          </div>
        <?php else: ?>
          <ul class="linea-tiempo">
            <?php foreach ($log as $item): ?>
            <li class="lt-item">
              <div class="lt-icono lt-<?= $item['tipo'] ?>">
                <i class="fas fa-<?= $item['tipo'] === 'quiz' ? 'clipboard-check' : 'dumbbell' ?>"></i>
              </div>
              <div class="lt-cuerpo">
                <div class="lt-titulo">
                  <?= limpiar($item['descripcion']) ?>
                  <span class="badge-<?= $item['estado'] ?>"><?= ucfirst($item['estado']) ?></span>
                </div>
                <div class="lt-detalle">
                  <i class="fas fa-info-circle" style="font-size:0.7rem;"></i>
                  <?= limpiar($item['detalle']) ?>
                </div>
                <div class="lt-fecha">
                  <i class="fas fa-clock" style="font-size:0.65rem;"></i>
                  <?= date('d/m/Y \a \l\a\s H:i', strtotime($item['fecha'])) ?>
                </div>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div><!-- /tarjeta -->

      <div style="margin-top: 20px;">
        <a href="<?= PROYECTO_PATH ?>/admin/usuarios" class="btn btn-gris">
          <i class="fas fa-arrow-left"></i> Volver a Usuarios
        </a>
      </div>
    </div><!-- /pagina-contenido -->
  </main>
</div>
</body>
</html>
