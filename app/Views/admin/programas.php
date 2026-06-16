<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programas de Formación — Admin SmashCode</title>
  <meta name="description" content="Gestión de programas de formación SENA en la plataforma SmashCode.">
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>(function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
</head>
<body>
<div class="contenedor-app">

  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="contenido-principal">
    <header class="barra-superior">
      <div class="stat-xp">
        <i class="fas fa-graduation-cap"></i> Programas de Formación
      </div>
      <div style="margin-left:auto; display:flex; align-items:center; gap:16px;">
        <button id="btn-cambiar-tema" class="btn-tema" aria-label="Cambiar tema" title="Cambiar tema">
          <i class="fas fa-sun tema-icono"></i>
          <span class="tema-label">Claro</span>
        </button>
        <div class="avatar-usuario" style="border:2px solid var(--verde); background:linear-gradient(135deg,var(--verde),var(--azul)); font-weight:800; cursor:default; margin:0;" title="<?= limpiar($_SESSION['nombre']) ?>">
          <?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?>
        </div>
      </div>
    </header>

    <div class="pagina-contenido">

      <!-- Encabezado con acción -->
      <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
        <div>
          <h1 class="pagina-titulo" style="margin-bottom:4px;">
            <i class="fas fa-graduation-cap" style="color:var(--verde-acento);"></i>
            Programas de Formación
          </h1>
          <p style="color:var(--texto-tenue); font-size:var(--texto-sm); margin:0;">
            Gestiona los programas del SENA. Los programas inactivos no permiten nuevas asignaciones.
          </p>
        </div>
        <a href="<?= PROYECTO_PATH ?>/admin/programas/crear" class="btn btn-verde" id="btn-nuevo-programa">
          <i class="fas fa-plus"></i> Nuevo Programa
        </a>
      </div>

      <!-- Alertas -->
      <?php if ($exito): ?>
        <div class="alerta alerta-exito" style="margin-bottom:16px;">
          <i class="fas fa-circle-check"></i>
          <?php
            $msgs = [
              'creado'      => 'Programa creado correctamente.',
              'actualizado' => 'Programa actualizado correctamente.',
              'estado'      => 'Estado del programa actualizado.',
              'eliminado'   => 'Programa eliminado correctamente.',
            ];
            echo $msgs[$exito] ?? 'Operación realizada.';
          ?>
        </div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alerta alerta-error" style="margin-bottom:16px;">
          <i class="fas fa-triangle-exclamation"></i> <?= $error ?>
        </div>
      <?php endif; ?>

      <!-- Tabla de programas -->
      <div class="tarjeta" style="padding:0; overflow:hidden;">
        <?php if (empty($programas)): ?>
          <div style="text-align:center; padding:60px 20px; color:var(--texto-tenue);">
            <i class="fas fa-graduation-cap" style="font-size:3rem; margin-bottom:16px; display:block; opacity:.3;"></i>
            <p style="font-size:var(--texto-sm);">No hay programas registrados aún.</p>
            <a href="<?= PROYECTO_PATH ?>/admin/programas/crear" class="btn btn-verde" style="margin-top:12px;">
              <i class="fas fa-plus"></i> Crear primer programa
            </a>
          </div>
        <?php else: ?>
          <table class="tabla-datos" style="width:100%;">
            <thead>
              <tr>
                <th style="width:30%;">Nombre</th>
                <th>Descripción</th>
                <th style="width:100px; text-align:center;">Usuarios</th>
                <th style="width:100px; text-align:center;">Estado</th>
                <th style="width:140px; text-align:center;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($programas as $p): ?>
              <tr id="fila-programa-<?= $p['id'] ?>" style="<?= !$p['activo'] ? 'opacity:.6;' : '' ?>">
                <td>
                  <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--verde-oscuro),var(--verde-acento)); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                      <i class="fas fa-graduation-cap" style="color:#fff; font-size:.8rem;"></i>
                    </div>
                    <div>
                      <div style="font-weight:600; font-size:var(--texto-sm);"><?= limpiar($p['nombre']) ?></div>
                    </div>
                  </div>
                </td>
                <td style="color:var(--texto-tenue); font-size:var(--texto-xs);">
                  <?= $p['descripcion'] ? limpiar($p['descripcion']) : '<span style="opacity:.4;">Sin descripción</span>' ?>
                </td>
                <td style="text-align:center;">
                  <span class="nav-badge" style="background:rgba(88,204,2,.12); color:var(--verde-acento); border:1px solid rgba(88,204,2,.25); padding:2px 10px; border-radius:20px; font-size:.72rem; font-weight:700;">
                    <?= (int)$p['total_usuarios'] ?>
                  </span>
                </td>
                <td style="text-align:center;">
                  <?php if ($p['activo']): ?>
                    <span style="background:rgba(88,204,2,.12); color:var(--verde-acento); border:1px solid rgba(88,204,2,.25); padding:3px 12px; border-radius:20px; font-size:.72rem; font-weight:700;">
                      <i class="fas fa-circle" style="font-size:.4rem; vertical-align:middle;"></i> Activo
                    </span>
                  <?php else: ?>
                    <span style="background:rgba(255,75,75,.1); color:var(--rojo); border:1px solid rgba(255,75,75,.25); padding:3px 12px; border-radius:20px; font-size:.72rem; font-weight:700;">
                      <i class="fas fa-circle" style="font-size:.4rem; vertical-align:middle;"></i> Inactivo
                    </span>
                  <?php endif; ?>
                </td>
                <td style="text-align:center;">
                  <div style="display:flex; gap:6px; justify-content:center;">
                    <!-- Editar -->
                    <a href="<?= PROYECTO_PATH ?>/admin/programas/editar?id=<?= $p['id'] ?>"
                       class="btn-accion btn-editar" title="Editar" id="btn-editar-programa-<?= substr($p['id'],0,8) ?>">
                      <i class="fas fa-pen"></i>
                    </a>
                    <!-- Toggle activo/inactivo -->
                    <form method="POST" action="<?= PROYECTO_PATH ?>/admin/programas/toggle" style="display:inline;" id="form-toggle-<?= substr($p['id'],0,8) ?>">
                      <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                      <input type="hidden" name="id" value="<?= $p['id'] ?>">
                      <button type="submit" class="btn-accion <?= $p['activo'] ? 'btn-suspender' : 'btn-activar' ?>"
                              title="<?= $p['activo'] ? 'Desactivar' : 'Activar' ?>"
                              id="btn-toggle-programa-<?= substr($p['id'],0,8) ?>">
                        <i class="fas fa-<?= $p['activo'] ? 'ban' : 'check' ?>"></i>
                      </button>
                    </form>
                    <!-- Eliminar (solo si no tiene usuarios) -->
                    <?php if ((int)$p['total_usuarios'] === 0): ?>
                    <form method="POST" action="<?= PROYECTO_PATH ?>/admin/programas/eliminar" style="display:inline;"
                          id="form-eliminar-<?= substr($p['id'],0,8) ?>"
                          onsubmit="return confirm('¿Eliminar el programa «<?= limpiar($p['nombre']) ?>»? Esta acción no se puede deshacer.')">
                      <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                      <input type="hidden" name="id" value="<?= $p['id'] ?>">
                      <button type="submit" class="btn-accion btn-eliminar" title="Eliminar"
                              id="btn-eliminar-programa-<?= substr($p['id'],0,8) ?>">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    <?php else: ?>
                    <button class="btn-accion btn-eliminar" disabled title="Tiene usuarios vinculados" style="opacity:.3; cursor:not-allowed;">
                      <i class="fas fa-trash"></i>
                    </button>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

      <!-- Nota informativa -->
      <div style="margin-top:16px; padding:12px 16px; background:rgba(88,204,2,.06); border:1px solid rgba(88,204,2,.15); border-radius:var(--radio-sm); font-size:var(--texto-xs); color:var(--texto-tenue); display:flex; gap:10px; align-items:flex-start;">
        <i class="fas fa-circle-info" style="color:var(--verde-acento); margin-top:2px; flex-shrink:0;"></i>
        <div>
          Los programas <strong>inactivos</strong> no aparecen al crear nuevos usuarios, pero los usuarios ya vinculados conservan su asignación.
          Un programa solo puede <strong>eliminarse</strong> si no tiene usuarios asociados.
        </div>
      </div>

    </div><!-- /pagina-contenido -->
  </main>
</div>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
