<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Nivel <?= (int)$nivel['orden'] ?> — Admin SmashCode</title>
  <meta name="description" content="Formulario de edición del nivel <?= limpiar($nivel['nombre']) ?> en SmashCode.">
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>(function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
  <style>
    .form-nivel-card {
      background: var(--blanco);
      border: 1px solid var(--borde-sutil);
      border-radius: 20px;
      padding: 32px 36px;
      max-width: 680px;
    }
    .form-grupo { margin-bottom: 22px; }
    .form-label {
      display: block;
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--texto-secundario);
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .form-label span { color: #EF4444; margin-left: 2px; }
    .form-input, .form-textarea {
      width: 100%;
      padding: 11px 14px;
      background: var(--fondo-input);
      border: 1px solid var(--borde-sutil);
      border-radius: 10px;
      color: var(--texto-principal);
      font-size: 0.9rem;
      font-family: inherit;
      transition: border-color 0.2s;
      box-sizing: border-box;
    }
    .form-input:focus, .form-textarea:focus {
      outline: none;
      border-color: var(--azul);
    }
    .form-textarea { resize: vertical; min-height: 90px; }
    .form-input:disabled {
      opacity: 0.55;
      cursor: not-allowed;
    }
    .form-hint {
      font-size: 0.72rem;
      color: var(--texto-tenue);
      margin-top: 5px;
    }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .toggle-activo {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 16px;
      background: var(--fondo-input);
      border: 1px solid var(--borde-sutil);
      border-radius: 10px;
    }
    .toggle-switch {
      position: relative;
      width: 46px;
      height: 26px;
      flex-shrink: 0;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .slider {
      position: absolute;
      cursor: pointer;
      inset: 0;
      background: #374151;
      border-radius: 99px;
      transition: 0.3s;
    }
    .slider:before {
      position: absolute;
      content: '';
      height: 18px; width: 18px;
      left: 4px; bottom: 4px;
      background: #fff;
      border-radius: 50%;
      transition: 0.3s;
    }
    input:checked + .slider { background: #10B981; }
    input:checked + .slider:before { transform: translateX(20px); }
    .preview-imagen {
      width: 100%;
      height: 140px;
      border-radius: 12px;
      object-fit: cover;
      border: 1px solid var(--borde-sutil);
      margin-top: 10px;
      display: none;
      background: var(--fondo-input);
    }
    .preview-placeholder {
      width: 100%;
      height: 140px;
      border-radius: 12px;
      border: 2px dashed var(--borde-sutil);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--texto-tenue);
      font-size: 0.8rem;
      gap: 8px;
      margin-top: 10px;
    }
    .badge-nivel-orden {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 12px;
      background: rgba(28,176,246,0.12);
      color: var(--azul);
      border-radius: 99px;
      font-size: 0.72rem;
      font-weight: 700;
      margin-bottom: 18px;
    }
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
        <a href="<?= PROYECTO_PATH ?>/admin/niveles" style="color:var(--texto-secundario);font-weight:700;text-decoration:none;">Niveles</a>
        <i class="fas fa-chevron-right" style="font-size:0.65rem;"></i>
        <span style="color:var(--texto-tenue);">Editar Nivel <?= (int)$nivel['orden'] ?></span>
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

      <div style="margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;">
        <div>
          <h1 style="font-size:1.6rem;font-weight:800;letter-spacing:-0.5px;margin:0 0 4px 0;">
            <i class="fas fa-pen-to-square" style="color:var(--verde-acento);margin-right:8px;"></i>
            Editar Nivel
          </h1>
          <p style="color:var(--texto-secundario);font-size:0.83rem;margin:0;">
            Modifica los atributos del nivel. Los cambios se reflejan inmediatamente para los aprendices.
          </p>
        </div>
        <a href="<?= PROYECTO_PATH ?>/admin/niveles" style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:var(--fondo-input);border:1px solid var(--borde-sutil);border-radius:10px;color:var(--texto-secundario);text-decoration:none;font-size:0.82rem;font-weight:600;">
          <i class="fas fa-arrow-left"></i> Volver
        </a>
      </div>

      <div class="form-nivel-card">
        <div class="badge-nivel-orden">
          <i class="fas fa-layer-group"></i>
          Nivel <?= (int)$nivel['orden'] ?> — MCER
        </div>

        <form id="form-editar-nivel" method="POST" action="<?= PROYECTO_PATH ?>/admin/niveles/actualizar" novalidate>
          <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
          <input type="hidden" name="id"         value="<?= limpiar($nivel['id']) ?>">

          <!-- Nombre -->
          <div class="form-grupo">
            <label for="nombre-nivel" class="form-label">Nombre del Nivel <span>*</span></label>
            <input type="text" id="nombre-nivel" name="nombre"
                   class="form-input"
                   value="<?= limpiar($nivel['nombre']) ?>"
                   maxlength="255" required
                   placeholder="Ej: Nivel 1 - A1 Básico">
            <p class="form-hint">Identificador visible para aprendices e instructores.</p>
          </div>

          <!-- Descripción -->
          <div class="form-grupo">
            <label for="descripcion-nivel" class="form-label">Descripción</label>
            <textarea id="descripcion-nivel" name="descripcion"
                      class="form-textarea"
                      maxlength="500"
                      placeholder="Describe el contenido y objetivos de este nivel..."><?= limpiar($nivel['descripcion'] ?? '') ?></textarea>
            <p class="form-hint">Máximo 500 caracteres. Visible en el mapa de niveles del aprendiz.</p>
          </div>

          <!-- URL de imagen -->
          <div class="form-grupo">
            <label for="imagen-url-nivel" class="form-label">URL de imagen de portada</label>
            <input type="url" id="imagen-url-nivel" name="imagen_url"
                   class="form-input"
                   value="<?= limpiar($nivel['imagen_url'] ?? '') ?>"
                   placeholder="https://ejemplo.com/imagen.jpg">
            <p class="form-hint">Imagen de portada del nivel (PNG, JPG o WebP recomendado, mín. 600×300 px).</p>
            <!-- Preview -->
            <div class="preview-placeholder" id="preview-placeholder-<?= (int)$nivel['orden'] ?>">
              <i class="fas fa-image"></i> Vista previa de imagen
            </div>
            <img id="preview-img-nivel" class="preview-imagen"
                 src="<?= limpiar($nivel['imagen_url'] ?? '') ?>"
                 alt="Preview portada nivel">
          </div>

          <!-- Umbral + RAPs -->
          <div class="form-row">
            <div class="form-grupo" style="margin-bottom:0;">
              <label for="umbral-nivel" class="form-label">Umbral de desbloqueo (%)</label>
              <input type="number" id="umbral-nivel" name="umbral_desbloqueo"
                     class="form-input"
                     value="<?= number_format((float)$nivel['umbral_desbloqueo'], 2) ?>"
                     min="0" max="100" step="0.01"
                     <?= (int)$nivel['orden'] === 1 ? 'disabled title="El Nivel 1 siempre está disponible (0%)"' : '' ?>>
              <p class="form-hint">
                <?= (int)$nivel['orden'] === 1 ? '⚡ El Nivel 1 siempre es accesible sin requisito previo.' : '% mínimo del nivel anterior para desbloquear este.' ?>
              </p>
            </div>

            <div class="form-grupo" style="margin-bottom:0;">
              <label class="form-label">RAPs configurados</label>
              <div style="padding:11px 14px;background:var(--fondo-input);border:1px solid var(--borde-sutil);border-radius:10px;font-size:0.9rem;color:var(--texto-secundario);">
                <i class="fas fa-file-lines" style="color:#8B5CF6;margin-right:6px;"></i>
                <?= (int)$nivel['total_raps'] ?> RAP<?= (int)$nivel['total_raps'] !== 1 ? 's' : '' ?> asignado<?= (int)$nivel['total_raps'] !== 1 ? 's' : '' ?>
              </div>
              <p class="form-hint">Gestiona los RAPs desde el módulo de RAPs.</p>
            </div>
          </div>

          <!-- Toggle activo -->
          <div class="form-grupo" style="margin-top:22px;">
            <label class="form-label">Estado del nivel</label>
            <div class="toggle-activo">
              <label class="toggle-switch" for="activo-nivel">
                <input type="checkbox" id="activo-nivel" name="activo" value="1"
                       <?= $nivel['activo'] ? 'checked' : '' ?>
                       <?= (int)$nivel['orden'] === 1 ? 'disabled title="El Nivel 1 no puede desactivarse."' : '' ?>>
                <span class="slider"></span>
              </label>
              <div>
                <span style="font-size:0.88rem;font-weight:700;color:var(--texto-principal);" id="estado-label-nivel">
                  <?= $nivel['activo'] ? 'Activo' : 'Inactivo' ?>
                </span>
                <p style="font-size:0.72rem;color:var(--texto-tenue);margin:2px 0 0 0;">
                  <?= (int)$nivel['orden'] === 1 ? 'El Nivel 1 siempre debe estar activo.' : 'Un nivel inactivo no es visible para los aprendices.' ?>
                </p>
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div style="display:flex;gap:12px;margin-top:28px;padding-top:20px;border-top:1px solid var(--borde-sutil);">
            <button type="submit" id="btn-guardar-nivel" class="btn btn-primario" style="width:auto;padding:11px 28px;font-size:0.9rem;">
              <i class="fas fa-floppy-disk"></i> Guardar cambios
            </button>
            <a href="<?= PROYECTO_PATH ?>/admin/niveles" class="btn" style="width:auto;padding:11px 20px;font-size:0.9rem;background:var(--fondo-input);border:1px solid var(--borde-sutil);color:var(--texto-secundario);text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
              <i class="fas fa-xmark"></i> Cancelar
            </a>
          </div>
        </form>
      </div>

    </div><!-- /pagina-contenido -->
  </main>
</div>

<script>
  // Preview de imagen
  const inputImg  = document.getElementById('imagen-url-nivel');
  const previewImg = document.getElementById('preview-img-nivel');
  const placeholder = document.getElementById('preview-placeholder-<?= (int)$nivel['orden'] ?>');

  function actualizarPreview() {
    const url = inputImg.value.trim();
    if (url) {
      previewImg.src = url;
      previewImg.style.display = 'block';
      placeholder.style.display = 'none';
    } else {
      previewImg.style.display = 'none';
      placeholder.style.display = 'flex';
    }
  }
  inputImg.addEventListener('input', actualizarPreview);
  // Mostrar si ya hay imagen
  if (inputImg.value.trim()) {
    previewImg.style.display = 'block';
    placeholder.style.display = 'none';
  }

  // Toggle label dinámico
  const toggleInput = document.getElementById('activo-nivel');
  const estadoLabel = document.getElementById('estado-label-nivel');
  if (toggleInput) {
    toggleInput.addEventListener('change', () => {
      estadoLabel.textContent = toggleInput.checked ? 'Activo' : 'Inactivo';
    });
  }

  // Validación básica del formulario
  document.getElementById('form-editar-nivel').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre-nivel').value.trim();
    if (!nombre) {
      e.preventDefault();
      alert('El nombre del nivel es obligatorio.');
      document.getElementById('nombre-nivel').focus();
    }
  });
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
