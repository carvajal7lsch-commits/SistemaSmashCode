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
      background: rgba(31, 47, 54, 0.65) !important;
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 2px solid rgba(255, 255, 255, 0.06) !important;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 24px var(--glow-color) !important;
      transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.25s;
      position: relative;
      display: flex;
      flex-direction: column;
    }
    [data-theme="light"] .card-nivel {
      background: rgba(255, 255, 255, 0.75) !important;
      border: 2px solid rgba(0, 0, 0, 0.08) !important;
      box-shadow: 0 8px 24px var(--glow-color) !important;
    }
    .card-nivel:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 36px var(--glow-color) !important;
      border-color: var(--theme-color) !important;
    }
    .card-nivel.inactivo {
      opacity: 0.65;
      filter: grayscale(0.35);
      border-top-color: var(--gris-medio) !important;
      --theme-color: var(--gris-medio) !important;
      --glow-color: rgba(132, 146, 156, 0.08) !important;
    }
    .card-nivel-imagen {
      width: 100%;
      height: 140px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
      position: relative;
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
      gap: 10px;
      align-items: center;
      margin-top: auto;
    }
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
      <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:28px;">
        <?php
          $totalActivos   = count(array_filter($niveles, fn($n) => $n['activo'] == 1));
          $totalInactivos = count($niveles) - $totalActivos;
        ?>
        <div class="tarjeta glass-panel" style="flex: 1; min-width: 180px; padding:16px 20px; display:flex; align-items:center; gap:14px; border-radius: 16px; border: 1px solid var(--borde-sutil);">
          <div style="width:44px; height:44px; background:rgba(28,176,246,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--azul); font-size: 1.2rem; box-shadow: 0 0 12px rgba(28,176,246,0.1);"><i class="fas fa-layer-group"></i></div>
          <div>
            <div style="font-size:1.6rem; font-weight:900; line-height:1.1; color: var(--texto-principal);"><?= count($niveles) ?></div>
            <div style="font-size:0.75rem; color:var(--texto-secundario); font-weight:700; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px;">Total Niveles</div>
          </div>
        </div>
        <div class="tarjeta glass-panel" style="flex: 1; min-width: 180px; padding:16px 20px; display:flex; align-items:center; gap:14px; border-radius: 16px; border: 1px solid var(--borde-sutil);">
          <div style="width:44px; height:44px; background:rgba(88,204,2,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--verde); font-size: 1.2rem; box-shadow: 0 0 12px rgba(88,204,2,0.1);"><i class="fas fa-circle-check"></i></div>
          <div>
            <div style="font-size:1.6rem; font-weight:900; line-height:1.1; color: var(--texto-principal);"><?= $totalActivos ?></div>
            <div style="font-size:0.75rem; color:var(--texto-secundario); font-weight:700; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px;">Activos</div>
          </div>
        </div>
        <div class="tarjeta glass-panel" style="flex: 1; min-width: 180px; padding:16px 20px; display:flex; align-items:center; gap:14px; border-radius: 16px; border: 1px solid var(--borde-sutil);">
          <div style="width:44px; height:44px; background:rgba(255,75,75,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--rojo); font-size: 1.2rem; box-shadow: 0 0 12px rgba(255,75,75,0.1);"><i class="fas fa-ban"></i></div>
          <div>
            <div style="font-size:1.6rem; font-weight:900; line-height:1.1; color: var(--texto-principal);"><?= $totalInactivos ?></div>
            <div style="font-size:0.75rem; color:var(--texto-secundario); font-weight:700; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px;">Inactivos</div>
          </div>
        </div>
      </div>

      <!-- Barra de filtros -->
      <div class="barra-filtros" style="margin-bottom: 28px;">
        <div class="contenedor-input-search" style="max-width: 450px; flex: 1;">
          <i class="fas fa-search icono-search"></i>
          <input type="text" id="buscar-nivel" class="input-busqueda" placeholder="Buscar nivel por nombre o descripción...">
        </div>
        <select id="filtrar-estado" class="select-filtro" style="min-width: 180px;">
          <option value="todos">Todos los estados</option>
          <option value="activos">Activos</option>
          <option value="inactivos">Inactivos</option>
        </select>
      </div>

      <!-- Grid de niveles -->
      <div class="grid-niveles">
        <?php
        $mcer = ['A1', 'A2', 'B1', 'B1+', 'B2-', 'B2'];
        $iconosNivel = ['🩺','💊','🏥','📋','🚑','🩻'];
        
        $coloresNivel = [
          1 => ['color' => '#58CC02', 'shadow' => 'rgba(88,204,2,0.25)', 'bg' => 'rgba(88,204,2,0.1)'],
          2 => ['color' => '#1CB0F6', 'shadow' => 'rgba(28,176,246,0.25)', 'bg' => 'rgba(28,176,246,0.1)'],
          3 => ['color' => '#FF9600', 'shadow' => 'rgba(255,150,0,0.25)', 'bg' => 'rgba(255,150,0,0.1)'],
          4 => ['color' => '#CE82FF', 'shadow' => 'rgba(206,130,255,0.25)', 'bg' => 'rgba(206,130,255,0.1)'],
          5 => ['color' => '#FF4B4B', 'shadow' => 'rgba(255,75,75,0.25)', 'bg' => 'rgba(255,75,75,0.1)'],
          6 => ['color' => '#FFD900', 'shadow' => 'rgba(255,217,0,0.25)', 'bg' => 'rgba(255,217,0,0.1)']
        ];

        foreach ($niveles as $n):
          $orden = (int)$n['orden'];
          $mcerLabel = $mcer[$orden - 1] ?? 'N/A';
          $icono     = $iconosNivel[$orden - 1] ?? '📚';
          $cfg       = $coloresNivel[$orden] ?? ['color' => '#84929C', 'shadow' => 'rgba(0,0,0,0.1)', 'bg' => 'rgba(0,0,0,0.05)'];
        ?>
        <div class="card-nivel <?= $n['activo'] ? '' : 'inactivo' ?>" 
             id="nivel-<?= limpiar($n['id']) ?>" 
             data-nombre="<?= limpiar(mb_strtolower($n['nombre'])) ?>"
             data-desc="<?= limpiar(mb_strtolower($n['descripcion'] ?? '')) ?>"
             data-activo="<?= $n['activo'] ? '1' : '0' ?>"
             style="border-top: 4px solid <?= $cfg['color'] ?>; --theme-color: <?= $cfg['color'] ?>; --glow-color: <?= $cfg['shadow'] ?>;">
          <!-- Imagen / portada -->
          <div class="card-nivel-imagen" style="background: linear-gradient(135deg, #1A2D35 0%, <?= $cfg['color'] ?> 100%);">
            <?php if (!empty($n['imagen_url'])): ?>
              <img src="<?= limpiar($n['imagen_url']) ?>" alt="Portada Nivel <?= $orden ?>">
            <?php else: ?>
              <span><?= $icono ?></span>
            <?php endif; ?>
          </div>

          <div class="card-nivel-body">
            <div class="card-nivel-orden" style="color: <?= $cfg['color'] ?>;">Nivel <?= $orden ?> · MCER <?= $mcerLabel ?></div>
            <h2 class="card-nivel-nombre"><?= limpiar($n['nombre']) ?></h2>
            <p class="card-nivel-desc"><?= limpiar($n['descripcion'] ?? 'Sin descripción configurada.') ?></p>

            <div class="card-nivel-meta">
              <span class="badge-mcer" style="background: <?= $cfg['bg'] ?>; color: <?= $cfg['color'] ?>; border: 1px solid <?= $cfg['shadow'] ?>;"><i class="fas fa-graduation-cap"></i> <?= $mcerLabel ?></span>
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
              <a href="<?= PROYECTO_PATH ?>/admin/niveles/editar?id=<?= urlencode($n['id']) ?>" 
                 class="btn" 
                 style="padding: 10px 12px; font-size: 0.78rem; background: <?= $cfg['color'] ?>; color: #fff; box-shadow: 0 4px 0 <?= $cfg['shadow'] ?>; border: none; text-align: center; display: inline-flex; align-items: center; justify-content: center; text-decoration:none;"
                 onmouseover="this.style.filter='brightness(1.08)'"
                 onmouseout="this.style.filter='none'"
                 onmousedown="this.style.transform='translateY(4px)'; this.style.boxShadow='none'"
                 onmouseup="this.style.transform='none'; this.style.boxShadow='0 4px 0 <?= $cfg['shadow'] ?>'"
                 id="btn-editar-nivel-<?= $orden ?>">
                <i class="fas fa-edit"></i> Editar
              </a>
              <?php if ($n['rap_id']): ?>
                <a href="<?= PROYECTO_PATH ?>/aprendiz/rap?id=<?= urlencode($n['rap_id']) ?>" 
                   class="btn-azul" 
                   style="padding: 10px 12px; font-size: 0.78rem; border: none; text-align: center; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;"
                   id="btn-preview-nivel-<?= $orden ?>"
                   title="Previsualizar el RAP como aprendiz">
                  <i class="fas fa-eye-low-vision"></i> Prever
                </a>
              <?php endif; ?>
              <?php if ($orden > 1): ?>
                <button type="button" class="btn-accion <?= $n['activo'] ? 'btn-suspender' : 'btn-activar' ?>"
                        style="width: 42px; height: 42px; flex-shrink: 0;"
                        title="<?= $n['activo'] ? 'Desactivar' : 'Activar' ?>"
                        id="btn-toggle-nivel-<?= $orden ?>"
                        onclick="abrirModalToggleNivel('<?= $n['id'] ?>', <?= $n['activo'] ?>, '<?= $orden ?>', '<?= limpiar(addslashes($n['nombre'])) ?>')">
                  <i class="fas fa-<?= $n['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                </button>
              <?php else: ?>
                <button type="button" class="btn-accion" disabled 
                        style="width: 42px; height: 42px; flex-shrink: 0; opacity: 0.35; cursor: not-allowed;" 
                        title="El Nivel 1 siempre debe estar activo">
                  <i class="fas fa-eye"></i>
                </button>
              <?php endif; ?>
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

    <!-- Modal: Activar/Desactivar Nivel -->
    <div class="modal-fondo" id="modal-toggle-nivel">
      <div class="modal-caja">
        <p class="modal-titulo" id="modal-level-title" style="font-size:1.3rem; font-weight:800; color:var(--texto-principal); margin-bottom:12px;"></p>
        <p class="modal-desc" id="modal-level-desc" style="font-size:0.875rem; color:var(--texto-secundario); line-height:1.6; margin-bottom:24px;"></p>
        <form method="POST" action="<?= PROYECTO_PATH ?>/admin/niveles/toggle">
          <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
          <input type="hidden" name="id" id="toggle-nivel-id">
          <div class="modal-acciones" style="gap:12px;">
            <button type="button" class="btn btn-gris" onclick="cerrarModal('modal-toggle-nivel')">Cancelar</button>
            <button type="submit" class="btn" id="toggle-level-btn-confirm">Confirmar</button>
          </div>
        </form>
      </div>
    </div>

  </main>
</div>

<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
<script>
  function abrirModalToggleNivel(id, activo, orden, nombre) {
    document.getElementById('toggle-nivel-id').value = id;
    const accion = activo == 1 ? 'Desactivar' : 'Activar';
    document.getElementById('modal-level-title').textContent = accion + ' Nivel ' + orden;
    document.getElementById('modal-level-desc').textContent = 
      '¿Estás seguro de que deseas ' + accion.toLowerCase() + ' el nivel «' + nombre + '»? ' +
      (activo == 1 ? 'Los aprendices no podrán visualizar este nivel ni realizar los ejercicios correspondientes.' : 'El nivel volverá a estar visible para todos los aprendices y habilitado para el aprendizaje.');
    
    const btnConfirm = document.getElementById('toggle-level-btn-confirm');
    if (activo == 1) {
      btnConfirm.className = "btn btn-gris";
      btnConfirm.style.background = "linear-gradient(135deg, var(--rojo), #DC2626)";
      btnConfirm.style.color = "#fff";
      btnConfirm.style.boxShadow = "0 4px 0 #DC2626";
      btnConfirm.textContent = 'Desactivar';
    } else {
      btnConfirm.className = "btn btn-verde";
      btnConfirm.style.background = "";
      btnConfirm.style.color = "";
      btnConfirm.style.boxShadow = "";
      btnConfirm.textContent = 'Activar';
    }
    document.getElementById('modal-toggle-nivel').classList.add('visible');
  }

  function cerrarModal(id) {
    document.getElementById(id).classList.remove('visible');
  }

  // Cerrar modal al hacer clic fuera de la caja
  document.querySelectorAll('.modal-fondo').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('visible'); });
  });

  // Client-side search and status filter for Levels
  document.addEventListener('DOMContentLoaded', () => {
    const buscarInput = document.getElementById('buscar-nivel');
    const filtrarSelect = document.getElementById('filtrar-estado');
    const cards = document.querySelectorAll('.card-nivel');

    function filtrarNiveles() {
      const query = buscarInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
      const estado = filtrarSelect.value;

      cards.forEach(card => {
        const nombre = card.getAttribute('data-nombre').normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        const desc = card.getAttribute('data-desc').normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        const activo = card.getAttribute('data-activo');

        const coincideBusqueda = nombre.includes(query) || desc.includes(query);
        let coincideEstado = true;
        if (estado === 'activos') coincideEstado = (activo === '1');
        else if (estado === 'inactivos') coincideEstado = (activo === '0');

        if (coincideBusqueda && coincideEstado) {
          card.style.display = '';
          // Re-trigger CSS animation
          card.style.animation = 'entrar 0.3s cubic-bezier(0.4, 0, 0.2, 1) both';
        } else {
          card.style.display = 'none';
          card.style.animation = 'none';
        }
      });
    }

    if (buscarInput && filtrarSelect) {
      buscarInput.addEventListener('input', filtrarNiveles);
      filtrarSelect.addEventListener('change', filtrarNiveles);
    }
  });
</script>
</body>
</html>
