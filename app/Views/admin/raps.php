<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de RAPs — Admin SmashCode</title>
  <meta name="description" content="Verificación de componentes, publicación y previsualización de RAPs en SmashCode.">
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>(function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
  <style>
    /* Estilos Premium para la matriz de componentes */
    .comp-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 700;
      border: 1px solid transparent;
      transition: all 0.2s;
    }
    .comp-badge.complete {
      background: rgba(16, 185, 129, 0.08);
      color: #10B981;
      border-color: rgba(16, 185, 129, 0.2);
    }
    .comp-badge.incomplete {
      background: rgba(239, 68, 68, 0.08);
      color: #EF4444;
      border-color: rgba(239, 68, 68, 0.2);
    }
    .badge-completitud {
      font-size: 0.72rem;
      font-weight: 800;
      text-transform: uppercase;
      padding: 4px 10px;
      border-radius: 99px;
      letter-spacing: 0.05em;
    }
    .badge-completitud.si {
      background: #10B981;
      color: #fff;
      box-shadow: 0 4px 0 #059669;
    }
    .badge-completitud.no {
      background: #EF4444;
      color: #fff;
      box-shadow: 0 4px 0 #DC2626;
    }
    .alerta-flash {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 18px; border-radius: 12px;
      font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;
    }
    .alerta-exito { background: rgba(16,185,129,0.12); color: #10B981; border: 1px solid rgba(16,185,129,0.3); }
  </style>
</head>
<body>
<div class="contenedor-app">

  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="contenido-principal">
    <header class="barra-superior" style="background:transparent;border:none;box-shadow:none;margin:0;padding:24px 24px 10px;z-index:90;position:relative;min-height:60px;">
      <div style="display:flex;align-items:center;gap:8px;font-size:0.82rem;font-weight:600;color:var(--texto-tenue);">
        <i class="fas fa-home" style="font-size:0.75rem;"></i>
        <a href="<?= PROYECTO_PATH ?>/admin" style="color:var(--texto-secundario);font-weight:700;text-decoration:none;">Dashboard</a>
        <i class="fas fa-chevron-right" style="font-size:0.65rem;"></i>
        <span style="color:var(--texto-tenue);">RAPs</span>
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

      <!-- Encabezado -->
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
          <h1 style="font-size:1.7rem;font-weight:800;letter-spacing:-0.5px;margin:0 0 4px 0;">
            <i class="fas fa-file-lines" style="color:var(--azul);margin-right:10px;"></i>Previsualizar y Publicar RAPs
          </h1>
          <p style="color:var(--texto-secundario);font-size:0.85rem;margin:0;">
            HU03: Controla la completitud de los 5 componentes requeridos y la visibilidad de los RAPs para los aprendices.
          </p>
        </div>
      </div>

      <!-- Alertas flash -->
      <?php if ($exito): ?>
        <div class="alerta-flash alerta-exito" role="alert">
          <i class="fas fa-check-circle"></i> Estado del RAP actualizado correctamente.
        </div>
      <?php endif; ?>

      <!-- Barra de filtros -->
      <div class="barra-filtros" style="margin-bottom: 24px;">
        <div class="contenedor-input-search" style="max-width: 450px; flex: 1; margin: 0;">
          <i class="fas fa-search icono-search"></i>
          <input type="text" id="buscar-rap" class="input-busqueda" placeholder="Buscar RAP o nivel...">
        </div>
      </div>

      <!-- Contenedor Tabla -->
      <div class="tarjeta" style="padding:0; overflow:hidden;">
        <table class="tabla-usuarios" style="width:100%;">
          <thead>
            <tr>
              <th style="width:22%;">RAP / Nivel</th>
              <th style="text-align:center; width:52%;">Verificación de los 5 Componentes</th>
              <th style="text-align:center; width:90px;">Completitud</th>
              <th style="text-align:center; width:90px;">Estado</th>
              <th style="text-align:center; width:130px;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($raps as $r): 
              // Validar completitud de cada uno de los 5 componentes
              $cVocab = $r['total_vocabulario'] > 0;
              $cPron  = $r['total_vocabulario'] > 0 && ($r['total_pronunciacion'] === $r['total_vocabulario']);
              $cEjerc = $r['total_ejercicios'] > 0;
              $cDial  = $r['total_dialogos'] > 0;
              $cQuiz  = $r['tiene_quiz'] > 0 && $r['total_preguntas_quiz'] > 0;

              $esCompleto = ($cVocab && $cPron && $cEjerc && $cDial && $cQuiz);
            ?>
            <tr id="fila-rap-<?= $r['id'] ?>" class="fila-rap" data-nombre="<?= limpiar(mb_strtolower($r['titulo'])) ?>" data-nivel="<?= limpiar(mb_strtolower($r['nivel_nombre'])) ?>" style="<?= !$r['rap_activo'] ? 'opacity: 0.75;' : '' ?>">
              <td>
                <div style="font-weight:700; font-size:0.9rem; color:var(--texto-principal);"><?= limpiar($r['titulo']) ?></div>
                <div style="font-size:0.75rem; color:var(--texto-tenue); margin-top:2px; font-weight:600;"><i class="fas fa-graduation-cap" style="margin-right:4px;"></i><?= limpiar($r['nivel_nombre']) ?></div>
              </td>
              
              <!-- Matriz de los 5 Componentes -->
              <td>
                <div style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
                  <!-- Vocabulario -->
                  <span class="comp-badge <?= $cVocab ? 'complete' : 'incomplete' ?>" title="Requerido: >= 1 término activo">
                    <i class="fas fa-<?= $cVocab ? 'circle-check' : 'circle-xmark' ?>"></i>
                    Vocabulario: <?= (int)$r['total_vocabulario'] ?>
                  </span>

                  <!-- Pronunciación -->
                  <span class="comp-badge <?= $cPron ? 'complete' : 'incomplete' ?>" title="Requerido: Todos los vocablos con IPA configurado">
                    <i class="fas fa-<?= $cPron ? 'circle-check' : 'circle-xmark' ?>"></i>
                    IPA: <?= (int)$r['total_pronunciacion'] ?>/<?= (int)$r['total_vocabulario'] ?>
                  </span>

                  <!-- Ejercicios -->
                  <span class="comp-badge <?= $cEjerc ? 'complete' : 'incomplete' ?>" title="Requerido: >= 1 ejercicio activo">
                    <i class="fas fa-<?= $cEjerc ? 'circle-check' : 'circle-xmark' ?>"></i>
                    Ejercicios: <?= (int)$r['total_ejercicios'] ?>
                  </span>

                  <!-- Diálogos -->
                  <span class="comp-badge <?= $cDial ? 'complete' : 'incomplete' ?>" title="Requerido: >= 1 diálogo clínico activo">
                    <i class="fas fa-<?= $cDial ? 'circle-check' : 'circle-xmark' ?>"></i>
                    Diálogos: <?= (int)$r['total_dialogos'] ?>
                  </span>

                  <!-- Quiz -->
                  <span class="comp-badge <?= $cQuiz ? 'complete' : 'incomplete' ?>" title="Requerido: Quiz con >= 1 pregunta">
                    <i class="fas fa-<?= $cQuiz ? 'circle-check' : 'circle-xmark' ?>"></i>
                    Quiz: <?= (int)$r['total_preguntas_quiz'] ?> preg.
                  </span>
                </div>
              </td>

              <!-- Estado de Completitud -->
              <td style="text-align:center;">
                <?php if ($esCompleto): ?>
                  <span class="badge-completitud si">Completo</span>
                <?php else: ?>
                  <span class="badge-completitud no">Incompleto</span>
                <?php endif; ?>
              </td>

              <!-- Visibilidad (Publicado / Desactivado) -->
              <td style="text-align:center;">
                <?php if ($r['rap_activo']): ?>
                  <span class="badge-activo">Publicado</span>
                <?php else: ?>
                  <span class="badge-inactivo">Inactivo</span>
                <?php endif; ?>
              </td>

              <!-- Acciones -->
              <td style="text-align:center;">
                <div style="display:flex; justify-content:center; gap:8px;">
                  <!-- Previsualizar (Preview) -->
                  <a href="<?= PROYECTO_PATH ?>/aprendiz/rap?id=<?= urlencode($r['id']) ?>" 
                     class="btn btn-azul" 
                     style="padding:8px 12px; font-size:0.75rem; border:none; display:inline-flex; align-items:center; gap:6px; text-decoration:none;"
                     id="btn-preview-rap-<?= $r['nivel_orden'] ?>"
                     title="Previsualizar la vista exacta del aprendiz">
                    <i class="fas fa-eye"></i> Prever
                  </a>

                  <!-- Publicar / Desactivar (Toggle) -->
                  <button type="button" 
                          class="btn-accion <?= $r['rap_activo'] ? 'btn-suspender' : 'btn-activar' ?>"
                          style="width: 36px; height: 36px; display:inline-flex; align-items:center; justify-content:center;"
                          title="<?= $r['rap_activo'] ? 'Desactivar RAP' : 'Publicar RAP' ?>"
                          id="btn-toggle-rap-<?= $r['nivel_orden'] ?>"
                          onclick="abrirModalToggle('<?= $r['id'] ?>', <?= $r['rap_activo'] ?>, '<?= limpiar(addslashes($r['titulo'])) ?>', <?= $esCompleto ? 'true' : 'false' ?>)">
                    <i class="fas fa-<?= $r['rap_activo'] ? 'ban' : 'circle-check' ?>"></i>
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>

    <!-- Modal: Publicar / Desactivar RAP -->
    <div class="modal-fondo" id="modal-toggle-rap">
      <div class="modal-caja">
        <p class="modal-titulo" id="modal-rap-title" style="font-size:1.3rem; font-weight:800; color:var(--texto-principal); margin-bottom:12px;"></p>
        <p class="modal-desc" id="modal-rap-desc" style="font-size:0.875rem; color:var(--texto-secundario); line-height:1.6; margin-bottom:24px;"></p>
        
        <div id="modal-warning-completo" style="display:none; margin-bottom:20px; padding:12px 16px; background:rgba(255,150,0,0.08); border:1px solid rgba(255,150,0,0.3); border-radius:12px; display:flex; gap:10px; align-items:center;">
          <i class="fas fa-triangle-exclamation" style="color:#FF9600; font-size:1.2rem;"></i>
          <p style="margin:0; font-size:0.75rem; color:var(--texto-secundario); text-align:left;">
            ⚠️ <strong>Atención:</strong> Este RAP tiene componentes incompletos. Se recomienda completar todos los componentes antes de publicarlo.
          </p>
        </div>

        <form method="POST" action="<?= PROYECTO_PATH ?>/admin/raps/toggle">
          <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
          <input type="hidden" name="id" id="toggle-rap-id">
          <div class="modal-acciones" style="gap:12px;">
            <button type="button" class="btn btn-gris" onclick="cerrarModal('modal-toggle-rap')">Cancelar</button>
            <button type="submit" class="btn" id="toggle-rap-btn-confirm">Confirmar</button>
          </div>
        </form>
      </div>
    </div>

  </main>
</div>

<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
<script>
  function abrirModalToggle(id, activo, titulo, esCompleto) {
    document.getElementById('toggle-rap-id').value = id;
    const accion = activo === 1 ? 'Desactivar' : 'Publicar';
    document.getElementById('modal-rap-title').textContent = accion + ' RAP';
    
    let desc = '¿Estás seguro de que deseas ' + accion.toLowerCase() + ' el RAP «' + titulo + '»? ';
    if (activo === 1) {
      desc += 'Los aprendices ya no podrán ver este RAP en su mapa de aprendizaje.';
      document.getElementById('modal-warning-completo').style.display = 'none';
    } else {
      desc += 'El RAP se hará inmediatamente visible en el mapa de aprendizaje de los aprendices que tengan el nivel correspondiente desbloqueado.';
      if (!esCompleto) {
        document.getElementById('modal-warning-completo').style.display = 'flex';
      } else {
        document.getElementById('modal-warning-completo').style.display = 'none';
      }
    }
    
    document.getElementById('modal-rap-desc').textContent = desc;
    
    const btnConfirm = document.getElementById('toggle-rap-btn-confirm');
    if (activo === 1) {
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
      btnConfirm.textContent = 'Publicar';
    }
    
    document.getElementById('modal-toggle-rap').classList.add('visible');
  }

  function cerrarModal(id) {
    document.getElementById(id).classList.remove('visible');
  }

  // Cerrar modal al hacer clic fuera de la caja
  document.querySelectorAll('.modal-fondo').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('visible'); });
  });

  // Client-side search for RAPs
  document.getElementById('buscar-rap')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase().trim();
    const rows = document.querySelectorAll('.fila-rap');
    
    rows.forEach(row => {
      const nombre = row.getAttribute('data-nombre') || '';
      const nivel = row.getAttribute('data-nivel') || '';
      
      if (nombre.includes(query) || nivel.includes(query)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
</script>
</body>
</html>
