<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Niveles — Admin SmashCode</title>
  <meta name="description" content="Panel de administración: gestiona los 6 niveles del programa de inglés médico SmashCode.">
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>(function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
  <style>
    /* ── Grid de tarjetas de nivel ── */
    .grid-niveles {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 22px;
    }
    .card-nivel {
      background: var(--blanco);
      border: 1px solid var(--borde-sutil);
      border-radius: 18px;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
      position: relative;
    }
    .card-nivel:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(0,0,0,0.25);
    }
    .card-nivel-imagen {
      width: 100%;
      height: 140px;
      object-fit: cover;
      background: linear-gradient(135deg, #1a2d35 0%, #0e3a4a 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
    }
    .card-nivel-imagen img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .card-nivel-body { padding: 18px 20px; }
    .card-nivel-orden {
      font-size: 0.62rem;
      font-weight: 800;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--texto-tenue);
      margin-bottom: 4px;
    }
    .card-nivel-nombre {
      font-size: 1.05rem;
      font-weight: 800;
      color: var(--texto-principal);
      margin: 0 0 8px 0;
      line-height: 1.3;
    }
    .card-nivel-desc {
      font-size: 0.78rem;
      color: var(--texto-secundario);
      margin-bottom: 14px;
      line-height: 1.55;
      min-height: 36px;
    }
    .card-nivel-meta {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
      margin-bottom: 16px;
    }
    .badge-mcer {
      background: rgba(28,176,246,0.13);
      color: var(--azul);
      border: 1px solid rgba(28,176,246,0.25);
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 0.68rem;
      font-weight: 700;
    }
    .badge-raps {
      background: rgba(139,92,246,0.13);
      color: #8B5CF6;
      border: 1px solid rgba(139,92,246,0.25);
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 0.68rem;
      font-weight: 700;
    }
    .badge-umbral {
      background: rgba(245,158,11,0.13);
      color: #F59E0B;
      border: 1px solid rgba(245,158,11,0.25);
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 0.68rem;
      font-weight: 700;
    }
    .badge-activo {
      background: rgba(16,185,129,0.13);
      color: #10B981;
      border: 1px solid rgba(16,185,129,0.3);
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 0.68rem;
      font-weight: 700;
    }
    .badge-inactivo {
      background: rgba(239,68,68,0.13);
      color: #EF4444;
      border: 1px solid rgba(239,68,68,0.3);
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 0.68rem;
      font-weight: 700;
    }
    .card-nivel-acciones {
      display: flex;
      gap: 8px;
    }
    .btn-editar-nivel {
      flex: 1;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 9px 14px;
      background: var(--verde-acento);
      color: #fff;
      border-radius: 10px;
      font-size: 0.8rem;
      font-weight: 700;
      text-decoration: none;
      transition: opacity 0.15s;
    }
    .btn-editar-nivel:hover { opacity: 0.85; }
    .btn-toggle-nivel {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 9px 14px;
      border-radius: 10px;
      font-size: 0.8rem;
      font-weight: 700;
      border: none;
      cursor: pointer;
      transition: opacity 0.15s;
    }
    .btn-toggle-nivel.desactivar {
      background: rgba(239,68,68,0.12);
      color: #EF4444;
      border: 1px solid rgba(239,68,68,0.3);
    }
    .btn-toggle-nivel.activar {
      background: rgba(16,185,129,0.12);
      color: #10B981;
      border: 1px solid rgba(16,185,129,0.3);
    }
    .btn-toggle-nivel:hover { opacity: 0.75; }
    /* Overlay inactivo */
    .card-nivel.inactivo .card-nivel-imagen::after {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.35);
    }
    /* Alerta flash */
    .alerta-flash {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 18px; border-radius: 12px;
      font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;
    }
    .alerta-exito { background: rgba(16,185,129,0.12); color: #10B981; border: 1px solid rgba(16,185,129,0.3); }
    .alerta-error { background: rgba(239,68,68,0.12);  color: #EF4444;  border: 1px solid rgba(239,68,68,0.3); }
  </style>
</head>
<body>
<div class="contenedor-app">

  <!-- Barra lateral admin -->
  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="contenido-principal">
    <header class="barra-superior" style="background:transparent;border:none;box-shadow:none;margin:0;padding:24px 24px 10px;z-index:90;position:relative;min-height:60px;">
      <div style="display:flex;align-items:center;gap:8px;font-size:0.82rem;font-weight:600;color:var(--texto-tenue);">
        <i class="fas fa-home" style="font-size:0.75rem;"></i>
        <a href="<?= PROYECTO_PATH ?>/admin" style="color:var(--texto-secundario);font-weight:700;text-decoration:none;">Dashboard</a>
        <i class="fas fa-chevron-right" style="font-size:0.65rem;"></i>
        <span style="color:var(--texto-tenue);">Niveles</span>
      </div>
      <div style="margin-left:auto;display:flex;align-items:center;gap:16px;">
        <button id="btn-cambiar-tema" class="btn-tema" aria-label="Cambiar tema">
          <i class="fas fa-sun tema-icono"></i><span class="tema-label">Claro</span>
        </button>
        <div class="avatar-usuario" title="<?= limpiar($_SESSION['nombre']) ?>">
          <?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?>
        </div>
      </div>
    </header>

    <div class="pagina-contenido" style="padding:10px 24px 32px;">

      <!-- Encabezado de sección -->
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
          <h1 style="font-size:1.7rem;font-weight:800;letter-spacing:-0.5px;margin:0 0 4px 0;">
            <i class="fas fa-layer-group" style="color:var(--azul);margin-right:10px;"></i>Gestión de Niveles
          </h1>
          <p style="color:var(--texto-secundario);font-size:0.85rem;margin:0;">
            6 niveles fijos alineados al MCER (A1 → B2) · Solo se pueden editar, no crear ni eliminar.
          </p>
        </div>
      </div>

      <!-- Alertas flash -->
      <?php if ($exito): ?>
        <div class="alerta-flash alerta-exito" role="alert">
          <i class="fas fa-check-circle"></i>
          <?php
            echo match($exito) {
              'actualizado' => 'Nivel actualizado correctamente.',
              'estado'      => 'Estado del nivel actualizado.',
              default       => 'Operación completada.',
            };
          ?>
        </div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alerta-flash alerta-error" role="alert">
          <i class="fas fa-triangle-exclamation"></i> <?= $error ?>
        </div>
      <?php endif; ?>

      <!-- Resumen rápido -->
      <div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:28px;">
        <?php
          $totalActivos   = count(array_filter($niveles, fn($n) => $n['activo'] == 1));
          $totalInactivos = count($niveles) - $totalActivos;
        ?>
        <div style="background:var(--blanco);border:1px solid var(--borde-sutil);border-radius:12px;padding:14px 20px;display:flex;align-items:center;gap:12px;">
          <div style="width:38px;height:38px;background:rgba(28,176,246,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--azul);"><i class="fas fa-layer-group"></i></div>
          <div><div style="font-size:1.5rem;font-weight:800;line-height:1;"><?= count($niveles) ?></div><div style="font-size:0.72rem;color:var(--texto-tenue);font-weight:600;">Total Niveles</div></div>
        </div>
        <div style="background:var(--blanco);border:1px solid var(--borde-sutil);border-radius:12px;padding:14px 20px;display:flex;align-items:center;gap:12px;">
          <div style="width:38px;height:38px;background:rgba(16,185,129,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#10B981;"><i class="fas fa-circle-check"></i></div>
          <div><div style="font-size:1.5rem;font-weight:800;line-height:1;"><?= $totalActivos ?></div><div style="font-size:0.72rem;color:var(--texto-tenue);font-weight:600;">Activos</div></div>
        </div>
        <div style="background:var(--blanco);border:1px solid var(--borde-sutil);border-radius:12px;padding:14px 20px;display:flex;align-items:center;gap:12px;">
          <div style="width:38px;height:38px;background:rgba(239,68,68,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#EF4444;"><i class="fas fa-ban"></i></div>
          <div><div style="font-size:1.5rem;font-weight:800;line-height:1;"><?= $totalInactivos ?></div><div style="font-size:0.72rem;color:var(--texto-tenue);font-weight:600;">Inactivos</div></div>
        </div>
      </div>

      <!-- Grid de niveles -->
      <div class="grid-niveles">
        <?php
        $mcer = ['A1', 'A2', 'B1', 'B1+', 'B2-', 'B2'];
        $iconosNivel = ['🩺','💊','🏥','📋','🚑','🩻'];
        foreach ($niveles as $n):
          $orden = (int)$n['orden'];
          $mcerLabel = $mcer[$orden - 1] ?? 'N/A';
          $icono     = $iconosNivel[$orden - 1] ?? '📚';
        ?>
        <div class="card-nivel <?= $n['activo'] ? '' : 'inactivo' ?>" id="nivel-<?= limpiar($n['id']) ?>">
          <!-- Imagen / portada -->
          <div class="card-nivel-imagen">
            <?php if (!empty($n['imagen_url'])): ?>
              <img src="<?= limpiar($n['imagen_url']) ?>" alt="Portada Nivel <?= $orden ?>">
            <?php else: ?>
              <span><?= $icono ?></span>
            <?php endif; ?>
          </div>

          <div class="card-nivel-body">
            <div class="card-nivel-orden">Nivel <?= $orden ?> · MCER <?= $mcerLabel ?></div>
            <h2 class="card-nivel-nombre"><?= limpiar($n['nombre']) ?></h2>
            <p class="card-nivel-desc"><?= limpiar($n['descripcion'] ?? 'Sin descripción configurada.') ?></p>

            <div class="card-nivel-meta">
              <span class="badge-mcer"><i class="fas fa-graduation-cap"></i> <?= $mcerLabel ?></span>
              <span class="badge-raps"><i class="fas fa-file-lines"></i> <?= (int)$n['total_raps'] ?> RAP<?= (int)$n['total_raps'] !== 1 ? 's' : '' ?></span>
              <?php if ($orden > 1): ?>
                <span class="badge-umbral"><i class="fas fa-lock"></i> ≥<?= number_format((float)$n['umbral_desbloqueo'], 0) ?>%</span>
              <?php else: ?>
                <span class="badge-umbral"><i class="fas fa-lock-open"></i> Libre</span>
              <?php endif; ?>
              <?php if ($n['activo']): ?>
                <span class="badge-activo"><i class="fas fa-circle" style="font-size:0.5rem;"></i> Activo</span>
              <?php else: ?>
                <span class="badge-inactivo"><i class="fas fa-circle" style="font-size:0.5rem;"></i> Inactivo</span>
              <?php endif; ?>
            </div>

            <div class="card-nivel-acciones">
              <a href="<?= PROYECTO_PATH ?>/admin/niveles/editar?id=<?= urlencode($n['id']) ?>" class="btn-editar-nivel" id="btn-editar-nivel-<?= $orden ?>">
                <i class="fas fa-pen-to-square"></i> Editar
              </a>
              <form method="POST" action="<?= PROYECTO_PATH ?>/admin/niveles/toggle" style="margin:0;">
                <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                <input type="hidden" name="id"         value="<?= limpiar($n['id']) ?>">
                <button type="submit" class="btn-toggle-nivel <?= $n['activo'] ? 'desactivar' : 'activar' ?>"
                        id="btn-toggle-nivel-<?= $orden ?>"
                        onclick="return confirm('<?= $n['activo'] ? '¿Desactivar este nivel? Los aprendices no podrán verlo.' : '¿Activar este nivel?' ?>')">
                  <i class="fas fa-<?= $n['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                  <?= $n['activo'] ? 'Desactivar' : 'Activar' ?>
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Nota informativa -->
      <div style="margin-top:28px;padding:14px 18px;background:rgba(28,176,246,0.07);border:1px solid rgba(28,176,246,0.2);border-radius:12px;display:flex;align-items:flex-start;gap:10px;">
        <i class="fas fa-circle-info" style="color:var(--azul);margin-top:2px;"></i>
        <p style="margin:0;font-size:0.8rem;color:var(--texto-secundario);line-height:1.6;">
          <strong style="color:var(--texto-principal);">Nota pedagógica (HU10):</strong>
          Los 6 niveles están precargados y alineados al Marco Común Europeo de Referencia (MCER).
          No es posible crear ni eliminar niveles. Solo se puede editar su nombre, descripción, imagen de portada,
          umbral de desbloqueo y estado activo/inactivo.
        </p>
      </div>

    </div><!-- /pagina-contenido -->
  </main>
</div>

<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
