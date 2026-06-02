<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Nivel <?= (int)$nivel['orden'] ?> — Instructor SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>(function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
  <style>
    .form-nivel-card { background:var(--blanco); border:1px solid var(--borde-sutil); border-radius:20px; padding:30px 34px; max-width:660px; }
    .form-grupo { margin-bottom:20px; }
    .form-label { display:block; font-size:0.8rem; font-weight:700; color:var(--texto-secundario); margin-bottom:6px; text-transform:uppercase; letter-spacing:0.05em; }
    .form-label span { color:#EF4444; margin-left:2px; }
    .form-input, .form-textarea { width:100%; padding:11px 14px; background:var(--fondo-input); border:1px solid var(--borde-sutil); border-radius:10px; color:var(--texto-principal); font-size:0.9rem; font-family:inherit; transition:border-color 0.2s; box-sizing:border-box; }
    .form-input:focus, .form-textarea:focus { outline:none; border-color:var(--azul); }
    .form-textarea { resize:vertical; min-height:88px; }
    .form-input:disabled { opacity:0.55; cursor:not-allowed; }
    .form-hint { font-size:0.72rem; color:var(--texto-tenue); margin-top:5px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .toggle-activo { display:flex; align-items:center; gap:12px; padding:14px 16px; background:var(--fondo-input); border:1px solid var(--borde-sutil); border-radius:10px; }
    .toggle-switch { position:relative; width:46px; height:26px; flex-shrink:0; }
    .toggle-switch input { opacity:0; width:0; height:0; }
    .slider { position:absolute; cursor:pointer; inset:0; background:#374151; border-radius:99px; transition:0.3s; }
    .slider:before { position:absolute; content:''; height:18px; width:18px; left:4px; bottom:4px; background:#fff; border-radius:50%; transition:0.3s; }
    input:checked + .slider { background:#10B981; }
    input:checked + .slider:before { transform:translateX(20px); }
    .preview-imagen { width:100%; height:130px; border-radius:12px; object-fit:cover; border:1px solid var(--borde-sutil); margin-top:10px; display:none; }
    .preview-placeholder { width:100%; height:130px; border-radius:12px; border:2px dashed var(--borde-sutil); display:flex; align-items:center; justify-content:center; color:var(--texto-tenue); font-size:0.8rem; gap:8px; margin-top:10px; }
  </style>
</head>
<body>
<div class="contenedor-app">

  <!-- Sidebar Instructor -->
  <nav class="barra-lateral" aria-label="Navegación instructor">
    <div class="logo-app">
      <div class="logo-icono">
        <svg viewBox="0 0 100 100" width="40" height="40" xmlns="http://www.w3.org/2000/svg" style="display:block;">
          <ellipse cx="50" cy="85" rx="22" ry="5" fill="#000" opacity="0.3"/>
          <ellipse cx="38" cy="82" rx="7" ry="4" fill="#FF9600"/>
          <ellipse cx="62" cy="82" rx="7" ry="4" fill="#FF9600"/>
          <rect x="26" y="20" width="48" height="58" rx="24" fill="#2B3E46"/>
          <path d="M 26 38 C 17 42 17 56 26 62 Z" fill="#2B3E46"/>
          <path d="M 74 38 C 83 42 83 56 74 62 Z" fill="#2B3E46"/>
          <ellipse cx="50" cy="54" rx="17" ry="20" fill="#FFFFFF"/>
          <ellipse cx="41" cy="38" rx="9" ry="9" fill="#FFFFFF"/>
          <ellipse cx="59" cy="38" rx="9" ry="9" fill="#FFFFFF"/>
          <circle cx="42" cy="38" r="5" fill="#111B1E"/>
          <circle cx="40.5" cy="36.5" r="1.8" fill="#FFFFFF"/>
          <circle cx="58" cy="38" r="5" fill="#111B1E"/>
          <circle cx="56.5" cy="36.5" r="1.8" fill="#FFFFFF"/>
          <path d="M 44 43 Q 50 51 56 43 Z" fill="#FF9600" stroke="#FF9600" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div>
        <div class="logo-nombre">Smash<span>Code</span></div>
        <div style="font-size:0.62rem;color:#52656D;letter-spacing:1.5px;font-weight:800;padding-left:2px;margin-top:2px;">INSTRUCTOR</div>
      </div>
    </div>
    <ul class="nav-lateral">
      <li><a href="<?= PROYECTO_PATH ?>/instructor" class="nav-enlace"><i class="fas fa-gauge-high nav-icono"></i><span>Dashboard</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/instructor/aprendices" class="nav-enlace"><i class="fas fa-users nav-icono"></i><span>Mis Aprendices</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/instructor/resultados" class="nav-enlace"><i class="fas fa-clipboard-list nav-icono"></i><span>Resultados Quiz</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/instructor/niveles" class="nav-enlace activo"><i class="fas fa-layer-group nav-icono"></i><span>Niveles</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/instructor/raps" class="nav-enlace"><i class="fas fa-file-lines nav-icono"></i><span>RAPs</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/instructor/vocabulario" class="nav-enlace"><i class="fas fa-spell-check nav-icono"></i><span>Vocabulario</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/instructor/quizzes" class="nav-enlace"><i class="fas fa-question-circle nav-icono"></i><span>Quizzes</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/instructor/exportar" class="nav-enlace"><i class="fas fa-file-csv nav-icono"></i><span>Exportar CSV</span></a></li>
      <li><a href="<?= PROYECTO_PATH ?>/logout" class="nav-enlace" style="color:var(--rojo);"><i class="fas fa-right-from-bracket nav-icono"></i><span>Cerrar Sesión</span></a></li>
    </ul>
  </nav>

  <main class="contenido-principal">
    <header class="barra-superior">
      <button id="btn-cambiar-tema" class="btn-tema" aria-label="Cambiar tema">
        <i class="fas fa-sun tema-icono"></i><span class="tema-label">Claro</span>
      </button>
      <div class="avatar-usuario" title="<?= limpiar($_SESSION['nombre']) ?>">
        <?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?>
      </div>
    </header>

    <div class="pagina-contenido" style="padding:10px 24px 32px;">
      <div style="margin-bottom:22px;display:flex;align-items:center;justify-content:space-between;">
        <div>
          <h1 class="pagina-titulo"><i class="fas fa-pen-to-square" style="color:var(--verde-acento);margin-right:8px;"></i>Editar Nivel</h1>
          <p class="pagina-subtitulo">Los cambios se reflejan de inmediato para los aprendices.</p>
        </div>
        <a href="<?= PROYECTO_PATH ?>/instructor/niveles" style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:var(--fondo-input);border:1px solid var(--borde-sutil);border-radius:10px;color:var(--texto-secundario);text-decoration:none;font-size:0.82rem;font-weight:600;">
          <i class="fas fa-arrow-left"></i> Volver
        </a>
      </div>

      <div class="form-nivel-card">
        <div style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;background:rgba(28,176,246,0.12);color:var(--azul);border-radius:99px;font-size:0.72rem;font-weight:700;margin-bottom:18px;">
          <i class="fas fa-layer-group"></i> Nivel <?= (int)$nivel['orden'] ?> — MCER
        </div>

        <form id="form-editar-nivel-instructor" method="POST" action="<?= PROYECTO_PATH ?>/instructor/niveles/actualizar" novalidate>
          <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
          <input type="hidden" name="id"         value="<?= limpiar($nivel['id']) ?>">

          <div class="form-grupo">
            <label for="nombre-nivel-inst" class="form-label">Nombre del Nivel <span>*</span></label>
            <input type="text" id="nombre-nivel-inst" name="nombre" class="form-input"
                   value="<?= limpiar($nivel['nombre']) ?>" maxlength="255" required>
            <p class="form-hint">Identificador visible en el mapa de aprendizaje.</p>
          </div>

          <div class="form-grupo">
            <label for="desc-nivel-inst" class="form-label">Descripción</label>
            <textarea id="desc-nivel-inst" name="descripcion" class="form-textarea" maxlength="500"><?= limpiar($nivel['descripcion'] ?? '') ?></textarea>
          </div>

          <div class="form-grupo">
            <label for="img-nivel-inst" class="form-label">URL de imagen de portada</label>
            <input type="url" id="img-nivel-inst" name="imagen_url" class="form-input"
                   value="<?= limpiar($nivel['imagen_url'] ?? '') ?>"
                   placeholder="https://ejemplo.com/imagen.jpg">
            <div class="preview-placeholder" id="ph-inst">
              <i class="fas fa-image"></i> Vista previa
            </div>
            <img id="preview-img-inst" class="preview-imagen" src="<?= limpiar($nivel['imagen_url'] ?? '') ?>" alt="Preview">
          </div>

          <div class="form-row">
            <div class="form-grupo" style="margin-bottom:0;">
              <label for="umbral-nivel-inst" class="form-label">Umbral de desbloqueo (%)</label>
              <input type="number" id="umbral-nivel-inst" name="umbral_desbloqueo" class="form-input"
                     value="<?= number_format((float)$nivel['umbral_desbloqueo'], 2) ?>"
                     min="0" max="100" step="0.01"
                     <?= (int)$nivel['orden'] === 1 ? 'disabled' : '' ?>>
              <p class="form-hint"><?= (int)$nivel['orden'] === 1 ? '⚡ Nivel 1 siempre accesible.' : '% mínimo del nivel anterior.' ?></p>
            </div>
            <div class="form-grupo" style="margin-bottom:0;">
              <label class="form-label">RAPs asignados</label>
              <div style="padding:11px 14px;background:var(--fondo-input);border:1px solid var(--borde-sutil);border-radius:10px;font-size:0.9rem;color:var(--texto-secundario);">
                <i class="fas fa-file-lines" style="color:#8B5CF6;margin-right:6px;"></i>
                <?= (int)$nivel['total_raps'] ?> RAP<?= (int)$nivel['total_raps'] !== 1 ? 's' : '' ?>
              </div>
            </div>
          </div>

          <div class="form-grupo" style="margin-top:20px;">
            <label class="form-label">Estado del nivel</label>
            <div class="toggle-activo">
              <label class="toggle-switch" for="activo-nivel-inst">
                <input type="checkbox" id="activo-nivel-inst" name="activo" value="1"
                       <?= $nivel['activo'] ? 'checked' : '' ?>
                       <?= (int)$nivel['orden'] === 1 ? 'disabled' : '' ?>>
                <span class="slider"></span>
              </label>
              <div>
                <span style="font-size:0.88rem;font-weight:700;color:var(--texto-principal);" id="estado-lbl-inst">
                  <?= $nivel['activo'] ? 'Activo' : 'Inactivo' ?>
                </span>
                <p style="font-size:0.72rem;color:var(--texto-tenue);margin:2px 0 0 0;">
                  <?= (int)$nivel['orden'] === 1 ? 'El Nivel 1 siempre debe estar activo.' : 'Un nivel inactivo no es visible para aprendices.' ?>
                </p>
              </div>
            </div>
          </div>

          <div style="display:flex;gap:12px;margin-top:26px;padding-top:18px;border-top:1px solid var(--borde-sutil);">
            <button type="submit" class="btn btn-primario" style="width:auto;padding:11px 26px;font-size:0.9rem;">
              <i class="fas fa-floppy-disk"></i> Guardar cambios
            </button>
            <a href="<?= PROYECTO_PATH ?>/instructor/niveles" class="btn" style="width:auto;padding:11px 18px;font-size:0.9rem;background:var(--fondo-input);border:1px solid var(--borde-sutil);color:var(--texto-secundario);text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
              <i class="fas fa-xmark"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<script>
  const inp = document.getElementById('img-nivel-inst');
  const img = document.getElementById('preview-img-inst');
  const ph  = document.getElementById('ph-inst');
  function updatePrev() {
    if (inp.value.trim()) { img.style.display = 'block'; ph.style.display = 'none'; }
    else { img.style.display = 'none'; ph.style.display = 'flex'; }
  }
  inp.addEventListener('input', updatePrev);
  updatePrev();

  const tog = document.getElementById('activo-nivel-inst');
  const lbl = document.getElementById('estado-lbl-inst');
  if (tog) tog.addEventListener('change', () => { lbl.textContent = tog.checked ? 'Activo' : 'Inactivo'; });

  document.getElementById('form-editar-nivel-instructor').addEventListener('submit', function(e) {
    if (!document.getElementById('nombre-nivel-inst').value.trim()) {
      e.preventDefault();
      alert('El nombre del nivel es obligatorio.');
    }
  });
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
