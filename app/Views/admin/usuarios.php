<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios — Admin SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
<div class="contenedor-app">

  <!-- Barra lateral -->
  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <!-- Contenido principal -->
  <main class="contenido-principal">
    <header class="barra-superior">
      <div class="stat-xp"><i class="fas fa-users"></i> Usuarios</div>
      <div class="avatar-usuario" title="<?= limpiar($_SESSION['nombre']) ?>">
        <?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?>
      </div>
    </header>

    <div class="pagina-contenido">
      <!-- Encabezado -->
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <div>
          <h1 class="pagina-titulo"><i class="fas fa-users-gear" style="color:var(--verde-acento);"></i> Gestión de Usuarios</h1>
          <p class="pagina-subtitulo" style="margin-bottom:0;">
            <?= $total ?> usuario(s) encontrado(s) en total
          </p>
        </div>
        <a href="<?= PROYECTO_PATH ?>/admin/usuarios/crear" class="btn btn-verde">
          <i class="fas fa-user-plus"></i> Nuevo Usuario
        </a>
      </div>

      <!-- Alertas de éxito -->
      <?php $exito = $_GET['exito'] ?? ''; ?>
      <?php if ($exito === 'creado'): ?>
        <div class="alerta alerta-exito"><i class="fas fa-circle-check"></i> Usuario creado correctamente.</div>
      <?php elseif ($exito === 'actualizado'): ?>
        <div class="alerta alerta-exito"><i class="fas fa-circle-check"></i> Usuario actualizado correctamente.</div>
      <?php elseif ($exito === 'estado'): ?>
        <div class="alerta alerta-exito"><i class="fas fa-circle-check"></i> Estado del usuario actualizado.</div>
      <?php elseif ($exito === 'eliminado'): ?>
        <div class="alerta alerta-exito"><i class="fas fa-circle-check"></i> Usuario eliminado del sistema (soft-delete).</div>
      <?php endif; ?>

      <!-- Filtros de búsqueda -->
      <form method="GET" action="<?= PROYECTO_PATH ?>/admin/usuarios" class="barra-filtros">
        <div class="contenedor-input-search">
          <i class="fas fa-search icono-search"></i>
          <input type="text" name="busqueda" class="input-busqueda"
                 placeholder="Buscar por nombre, correo..."
                 value="<?= limpiar($busqueda) ?>">
        </div>
        <select name="rol" class="select-filtro">
          <option value="">Todos los roles</option>
          <option value="aprendiz"   <?= $rol === 'aprendiz'   ? 'selected' : '' ?>>Aprendiz</option>
          <option value="instructor" <?= $rol === 'instructor' ? 'selected' : '' ?>>Instructor</option>
          <option value="admin"      <?= $rol === 'admin'      ? 'selected' : '' ?>>Admin</option>
        </select>
        <button type="submit" class="btn btn-verde" style="padding: 10px 18px;">
          <i class="fas fa-filter"></i> Filtrar
        </button>
        <?php if ($busqueda || $rol): ?>
          <a href="<?= PROYECTO_PATH ?>/admin/usuarios" class="btn btn-gris" style="padding: 10px 14px;">
            <i class="fas fa-xmark"></i> Limpiar
          </a>
        <?php endif; ?>
      </form>

      <!-- Tabla -->
      <div class="tarjeta" style="padding: 0; overflow: hidden;">
        <table class="tabla-usuarios">
          <thead>
            <tr>
              <th>Usuario</th>
              <th>Correo</th>
              <th>Rol</th>
              <th>Ficha</th>
              <th>XP</th>
              <th>Estado</th>
              <th>Registro</th>
              <th style="text-align:center;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($lista)): ?>
              <tr>
                <td colspan="8" style="text-align:center; padding: 40px; color: var(--texto-tenue);">
                  <i class="fas fa-ghost" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                  No se encontraron usuarios con esos criterios.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($lista as $u): ?>
              <tr>
                <td>
                  <div style="display:flex; align-items:center; gap:10px;">
                    <div class="avatar-usuario" style="width:32px;height:32px;font-size:0.8rem;flex-shrink:0;">
                      <?= strtoupper(substr($u['nombre_completo'], 0, 1)) ?>
                    </div>
                    <span style="font-weight:700;"><?= limpiar($u['nombre_completo']) ?></span>
                  </div>
                </td>
                <td style="color:var(--texto-secundario);"><?= limpiar($u['correo']) ?></td>
                <td>
                  <span class="badge-rol badge-<?= $u['rol'] ?>">
                    <?= ucfirst($u['rol']) ?>
                  </span>
                </td>
                <td><?= $u['ficha_sena'] ? limpiar($u['ficha_sena']) : '<span style="color:var(--texto-tenue);">—</span>' ?></td>
                <td style="font-weight:700; color:var(--acento-oro);"><?= number_format($u['xp_puntos']) ?></td>
                <td>
                  <?php if ($u['bloqueado']): ?>
                    <span class="badge-bloqueado"><i class="fas fa-lock"></i> Bloqueado</span>
                  <?php elseif ($u['activo']): ?>
                    <span class="badge-activo"><i class="fas fa-circle-dot"></i> Activo</span>
                  <?php else: ?>
                    <span class="badge-inactivo"><i class="fas fa-ban"></i> Inactivo</span>
                  <?php endif; ?>
                </td>
                <td style="color:var(--texto-tenue); font-size:0.78rem;">
                  <?= date('d/m/Y', strtotime($u['creado_en'])) ?>
                </td>
                <td>
                  <div style="display:flex; gap:5px; justify-content:center; flex-wrap:wrap;">
                    <a href="<?= PROYECTO_PATH ?>/admin/usuarios/editar?id=<?= $u['id'] ?>" class="btn-accion btn-editar">
                      <i class="fas fa-pen-to-square"></i> Editar
                    </a>
                    <a href="<?= PROYECTO_PATH ?>/admin/usuarios/actividad?id=<?= $u['id'] ?>" class="btn-accion btn-actividad">
                      <i class="fas fa-clock-rotate-left"></i> Log
                    </a>
                    <button type="button"
                      class="btn-accion <?= $u['activo'] ? 'btn-suspender' : 'btn-reactivar' ?>"
                      onclick="abrirModalSuspender('<?= $u['id'] ?>', <?= $u['activo'] ?>, '<?= limpiar($u['nombre_completo']) ?>')">
                      <i class="fas <?= $u['activo'] ? 'fa-user-slash' : 'fa-user-check' ?>"></i>
                      <?= $u['activo'] ? 'Suspender' : 'Reactivar' ?>
                    </button>
                    <button type="button" class="btn-accion btn-eliminar"
                      onclick="abrirModalEliminar('<?= $u['id'] ?>', '<?= limpiar($u['nombre_completo']) ?>')">
                      <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <?php if ($paginas > 1): ?>
        <nav class="paginacion" aria-label="Paginación de usuarios">
          <?php if ($pagina > 1): ?>
            <a href="?busqueda=<?= urlencode($busqueda) ?>&rol=<?= $rol ?>&pagina=<?= $pagina - 1 ?>" class="pag-btn">
              <i class="fas fa-chevron-left"></i>
            </a>
          <?php endif; ?>
          <?php for ($p = 1; $p <= $paginas; $p++): ?>
            <a href="?busqueda=<?= urlencode($busqueda) ?>&rol=<?= $rol ?>&pagina=<?= $p ?>"
               class="pag-btn <?= $p === $pagina ? 'activa' : '' ?>">
              <?= $p ?>
            </a>
          <?php endfor; ?>
          <?php if ($pagina < $paginas): ?>
            <a href="?busqueda=<?= urlencode($busqueda) ?>&rol=<?= $rol ?>&pagina=<?= $pagina + 1 ?>" class="pag-btn">
              <i class="fas fa-chevron-right"></i>
            </a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    </div><!-- /pagina-contenido -->
  </main>
</div>

<!-- Modal: Suspender/Reactivar -->
<div class="modal-fondo" id="modal-suspender">
  <div class="modal-caja">
    <p class="modal-titulo" id="modal-suspender-titulo"></p>
    <p class="modal-desc" id="modal-suspender-desc"></p>
    <form method="POST" action="<?= PROYECTO_PATH ?>/admin/usuarios/suspender">
      <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
      <input type="hidden" name="id" id="suspender-id">
      <input type="hidden" name="activo" id="suspender-activo">
      <div class="modal-acciones">
        <button type="button" class="btn btn-gris" onclick="cerrarModal('modal-suspender')">Cancelar</button>
        <button type="submit" class="btn btn-rojo" id="suspender-btn-text">Confirmar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Eliminar -->
<div class="modal-fondo" id="modal-eliminar">
  <div class="modal-caja">
    <p class="modal-titulo">⚠️ Eliminar Usuario</p>
    <p class="modal-desc" id="modal-eliminar-desc"></p>
    <form method="POST" action="<?= PROYECTO_PATH ?>/admin/usuarios/eliminar">
      <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
      <input type="hidden" name="id" id="eliminar-id">
      <div class="modal-acciones">
        <button type="button" class="btn btn-gris" onclick="cerrarModal('modal-eliminar')">Cancelar</button>
        <button type="submit" class="btn btn-rojo"><i class="fas fa-trash-can"></i> Sí, Eliminar</button>
      </div>
    </form>
  </div>
</div>

<script>
  function abrirModalSuspender(id, activo, nombre) {
    document.getElementById('suspender-id').value     = id;
    document.getElementById('suspender-activo').value = activo;
    const accion = activo == 1 ? 'Suspender' : 'Reactivar';
    document.getElementById('modal-suspender-titulo').textContent = accion + ' Usuario';
    document.getElementById('modal-suspender-desc').textContent   =
      '¿Estás seguro de que deseas ' + accion.toLowerCase() + ' a ' + nombre + '? ' +
      (activo == 1 ? 'Perderá acceso inmediatamente.' : 'Recuperará acceso de inmediato.');
    document.getElementById('suspender-btn-text').textContent = accion;
    document.getElementById('modal-suspender').classList.add('visible');
  }

  function abrirModalEliminar(id, nombre) {
    document.getElementById('eliminar-id').value      = id;
    document.getElementById('modal-eliminar-desc').textContent =
      'Vas a eliminar a "' + nombre + '" del sistema. Su historial se conservará (soft-delete). Esta acción requiere confirmación.';
    document.getElementById('modal-eliminar').classList.add('visible');
  }

  function cerrarModal(id) {
    document.getElementById(id).classList.remove('visible');
  }

  // Cerrar modal al hacer clic fuera
  document.querySelectorAll('.modal-fondo').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('visible'); });
  });
</script>
</body>
</html>
