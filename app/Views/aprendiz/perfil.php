<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Perfil — SmashCode Enfermería SENA</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>(function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
  <style>
    /* ── PERFIL PREMIUM ── */
    .perfil-page { display: flex; flex-direction: column; padding: 32px 40px; flex: 1; min-height: 100vh; overflow-y: auto; background: var(--fondo); gap: 28px; }

    /* Hero del Perfil */
    .hero-perfil {
      display: flex; align-items: center; gap: 28px;
      background: var(--blanco); border: 2px solid var(--gris-claro);
      border-radius: 20px; padding: 28px 32px;
      position: relative; overflow: hidden;
    }
    .hero-perfil::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, var(--verde), var(--azul), var(--morado));
    }
    .avatar-hero {
      width: 90px; height: 90px; border-radius: 50%; flex-shrink: 0;
      background: linear-gradient(135deg, var(--verde), var(--azul));
      display: flex; align-items: center; justify-content: center;
      font-size: 2.4rem; font-weight: 900; color: #fff;
      border: 4px solid var(--gris-claro);
      box-shadow: 0 8px 24px rgba(88,204,2,0.2);
    }
    .hero-info { flex: 1; }
    .hero-info h1 { font-size: 1.6rem; font-weight: 900; color: var(--gris-texto); margin-bottom: 4px; }
    .hero-info .hero-correo { color: var(--gris-medio); font-size: 0.85rem; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
    .hero-badges { display: flex; gap: 10px; flex-wrap: wrap; }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 5px 14px; border-radius: 999px;
      font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
    }
    .badge-xp { background: rgba(255,150,0,0.12); color: var(--naranja); border: 1px solid rgba(255,150,0,0.3); }
    .badge-nivel { background: rgba(88,204,2,0.12); color: var(--verde-oscuro); border: 1px solid rgba(88,204,2,0.3); }
    .badge-rol { background: rgba(28,176,246,0.12); color: var(--azul-oscuro); border: 1px solid rgba(28,176,246,0.3); }

    /* XP Progress */
    .xp-section { display: flex; align-items: center; gap: 16px; margin-top: 14px; }
    .xp-barra-wrap { flex: 1; }
    .xp-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gris-medio); margin-bottom: 6px; display: flex; justify-content: space-between; }
    .xp-barra { height: 10px; background: var(--gris-claro); border-radius: 999px; overflow: hidden; }
    .xp-fill { height: 100%; background: linear-gradient(90deg, var(--verde), #10B981); border-radius: 999px; transition: width 1s ease; }

    /* Grid de configuraciones */
    .config-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 900px) { .config-grid { grid-template-columns: 1fr; } }

    /* Tarjeta de configuración */
    .config-card {
      background: var(--blanco); border: 2px solid var(--gris-claro);
      border-radius: 16px; padding: 24px 28px;
    }
    .config-card-titulo {
      font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;
      color: var(--gris-medio); margin-bottom: 20px;
      display: flex; align-items: center; gap: 8px;
    }
    .config-card-titulo i { font-size: 1rem; }

    /* Form fields */
    .campo-grupo { margin-bottom: 16px; }
    .campo-label { display: block; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gris-texto); margin-bottom: 6px; }
    .campo-wrap { position: relative; }
    .campo-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--gris-medio); font-size: 0.85rem; pointer-events: none; }
    .campo-input-perfil {
      width: 100%; padding: 11px 14px 11px 38px;
      border: 2px solid var(--gris-claro); border-radius: 12px;
      font-size: 0.9rem; color: var(--gris-texto);
      background: var(--fondo); transition: all 0.2s; outline: none;
      font-family: var(--fuente);
    }
    .campo-input-perfil:focus { border-color: var(--verde); background: var(--blanco); box-shadow: 0 0 0 3px rgba(88,204,2,0.15); }
    .campo-input-perfil:disabled { opacity: 0.5; cursor: not-allowed; }

    .btn-guardar {
      width: 100%; padding: 12px; border-radius: 12px;
      background: var(--verde); color: #fff;
      border: none; font-size: 0.9rem; font-weight: 800;
      font-family: var(--fuente); cursor: pointer;
      box-shadow: 0 4px 0 var(--verde-oscuro);
      text-transform: uppercase; letter-spacing: 0.05em;
      transition: filter 0.15s, transform 0.1s;
    }
    .btn-guardar:hover { filter: brightness(1.05); }
    .btn-guardar:active { transform: translateY(4px); box-shadow: 0 0 0 var(--verde-oscuro); }

    /* Estadísticas quick */
    .stats-quick { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .stat-q {
      background: var(--fondo); border: 2px solid var(--gris-claro);
      border-radius: 12px; padding: 16px; text-align: center;
    }
    .stat-q-val { font-size: 1.8rem; font-weight: 900; color: var(--gris-texto); line-height: 1; }
    .stat-q-lbl { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gris-medio); margin-top: 4px; }

    /* Alerta de éxito/error */
    .alerta-perfil { padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; border: 2px solid; }
    .alerta-ok { background: rgba(88,204,2,0.1); border-color: var(--verde); color: var(--verde-oscuro); }
    .alerta-err { background: rgba(255,75,75,0.1); border-color: var(--rojo); color: var(--rojo); }

    /* Danger zone */
    .danger-zone { border-color: rgba(255,75,75,0.35) !important; }
    .danger-zone .config-card-titulo { color: var(--rojo); }
    .divider { height: 1px; background: var(--gris-claro); margin: 16px 0; }
  </style>
</head>
<body>
<div class="contenedor-app">
  <?php include dirname(__DIR__) . '/layouts/aprendiz_sidebar.php'; ?>

  <main class="contenido-principal">
    <div class="perfil-page">

      <?php
        $exito = limpiar($_GET['exito'] ?? '');
        $error = limpiar($_GET['error'] ?? '');
        $xp    = (int)($usuario['xp_puntos'] ?? 0);
        $nivel = (int)($usuario['nivel_perfil'] ?? 1);
        $xpSiguiente = $nivel * 500;
        $xpPorcentaje = $xpSiguiente > 0 ? min(100, round(($xp / $xpSiguiente) * 100)) : 100;
        $inicialAvatar = strtoupper(substr($usuario['nombre_completo'] ?? 'A', 0, 1));
      ?>

      <!-- ── HÉROE DEL PERFIL ── -->
      <div class="hero-perfil">
        <div class="avatar-hero"><?= $inicialAvatar ?></div>
        <div class="hero-info">
          <h1><?= limpiar($usuario['nombre_completo'] ?? '') ?></h1>
          <p class="hero-correo">
            <i class="fas fa-envelope"></i>
            <?= limpiar($usuario['correo'] ?? '') ?>
          </p>
          <div class="hero-badges">
            <span class="hero-badge badge-xp"><i class="fas fa-bolt"></i><?= number_format($xp) ?> XP</span>
            <span class="hero-badge badge-nivel"><i class="fas fa-star"></i>Nivel <?= $nivel ?></span>
            <span class="hero-badge badge-rol"><i class="fas fa-user-graduate"></i>Aprendiz</span>
          </div>
          <div class="xp-section">
            <div class="xp-barra-wrap">
              <div class="xp-label">
                <span>Progreso al siguiente nivel</span>
                <span><?= $xp ?> / <?= $xpSiguiente ?> XP</span>
              </div>
              <div class="xp-barra">
                <div class="xp-fill" style="width: <?= $xpPorcentaje ?>%"></div>
              </div>
            </div>
            <span style="font-size:1.6rem; font-weight:900; color:var(--verde); min-width:48px; text-align:right;"><?= $xpPorcentaje ?>%</span>
          </div>
        </div>
      </div>

      <!-- ── ESTADÍSTICAS RÁPIDAS ── -->
      <div class="config-card" style="padding: 20px 28px;">
        <div class="config-card-titulo"><i class="fas fa-chart-bar" style="color:var(--azul);"></i>Mis Estadísticas</div>
        <div class="stats-quick">
          <div class="stat-q">
            <div class="stat-q-val" style="color:var(--naranja);"><?= number_format($xp) ?></div>
            <div class="stat-q-lbl">XP Total</div>
          </div>
          <div class="stat-q">
            <div class="stat-q-val" style="color:var(--verde);"><?= $nivel ?></div>
            <div class="stat-q-lbl">Nivel Actual</div>
          </div>
          <div class="stat-q">
            <div class="stat-q-val" style="color:var(--azul);"><?= $xpPorcentaje ?>%</div>
            <div class="stat-q-lbl">Avance Nivel</div>
          </div>
        </div>
      </div>

      <!-- ── GRID DE CONFIGURACIÓN ── -->
      <div class="config-grid">

        <!-- Datos Personales -->
        <div class="config-card">
          <div class="config-card-titulo"><i class="fas fa-user-pen" style="color:var(--verde);"></i>Datos Personales</div>

          <?php if ($exito === 'nombre'): ?>
            <div class="alerta-perfil alerta-ok"><i class="fas fa-check-circle"></i>Nombre actualizado correctamente.</div>
          <?php endif; ?>
          <?php if ($error === 'nombre'): ?>
            <div class="alerta-perfil alerta-err"><i class="fas fa-exclamation-circle"></i>El nombre no puede estar vacío.</div>
          <?php endif; ?>

          <form method="POST" action="<?= PROYECTO_PATH ?>/aprendiz/perfil/actualizar">
            <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
            <input type="hidden" name="accion" value="nombre">

            <div class="campo-grupo">
              <label class="campo-label" for="nombre_completo">Nombre completo</label>
              <div class="campo-wrap">
                <i class="fas fa-user campo-ico"></i>
                <input type="text" id="nombre_completo" name="nombre_completo" class="campo-input-perfil"
                       value="<?= limpiar($usuario['nombre_completo'] ?? '') ?>" required maxlength="100">
              </div>
            </div>

            <div class="campo-grupo">
              <label class="campo-label">Correo electrónico</label>
              <div class="campo-wrap">
                <i class="fas fa-envelope campo-ico"></i>
                <input type="email" class="campo-input-perfil"
                       value="<?= limpiar($usuario['correo'] ?? '') ?>" disabled>
              </div>
              <small style="color:var(--gris-medio); font-size:0.72rem; margin-top:4px; display:block;">
                <i class="fas fa-lock" style="margin-right:4px;"></i>El correo solo puede ser modificado por un administrador.
              </small>
            </div>

            <button type="submit" class="btn-guardar">
              <i class="fas fa-save"></i> Guardar Nombre
            </button>
          </form>
        </div>

        <!-- Seguridad -->
        <div class="config-card">
          <div class="config-card-titulo"><i class="fas fa-shield-halved" style="color:var(--azul);"></i>Seguridad y Contraseña</div>

          <?php if ($exito === 'clave'): ?>
            <div class="alerta-perfil alerta-ok"><i class="fas fa-check-circle"></i>Contraseña actualizada correctamente.</div>
          <?php endif; ?>
          <?php if ($error === 'clave_actual'): ?>
            <div class="alerta-perfil alerta-err"><i class="fas fa-exclamation-circle"></i>La contraseña actual es incorrecta.</div>
          <?php endif; ?>
          <?php if ($error === 'clave_corta'): ?>
            <div class="alerta-perfil alerta-err"><i class="fas fa-exclamation-circle"></i>La nueva contraseña debe tener mínimo 8 caracteres.</div>
          <?php endif; ?>
          <?php if ($error === 'clave_no_coincide'): ?>
            <div class="alerta-perfil alerta-err"><i class="fas fa-exclamation-circle"></i>Las contraseñas nuevas no coinciden.</div>
          <?php endif; ?>

          <form method="POST" action="<?= PROYECTO_PATH ?>/aprendiz/perfil/actualizar">
            <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
            <input type="hidden" name="accion" value="clave">

            <div class="campo-grupo">
              <label class="campo-label" for="clave_actual">Contraseña actual</label>
              <div class="campo-wrap">
                <i class="fas fa-lock campo-ico"></i>
                <input type="password" id="clave_actual" name="clave_actual" class="campo-input-perfil" placeholder="••••••••" required autocomplete="current-password">
              </div>
            </div>

            <div class="campo-grupo">
              <label class="campo-label" for="clave_nueva">Nueva contraseña</label>
              <div class="campo-wrap">
                <i class="fas fa-key campo-ico"></i>
                <input type="password" id="clave_nueva" name="clave_nueva" class="campo-input-perfil" placeholder="Mín. 8 caracteres" required minlength="8" autocomplete="new-password">
              </div>
            </div>

            <div class="campo-grupo">
              <label class="campo-label" for="clave_confirmar">Confirmar nueva contraseña</label>
              <div class="campo-wrap">
                <i class="fas fa-check-double campo-ico"></i>
                <input type="password" id="clave_confirmar" name="clave_confirmar" class="campo-input-perfil" placeholder="Repite la nueva contraseña" required minlength="8" autocomplete="new-password">
              </div>
            </div>

            <button type="submit" class="btn-guardar" style="background:var(--azul); box-shadow:0 4px 0 var(--azul-oscuro);">
              <i class="fas fa-lock"></i> Actualizar Contraseña
            </button>
          </form>
        </div>

        <!-- Preferencias -->
        <div class="config-card">
          <div class="config-card-titulo"><i class="fas fa-palette" style="color:var(--morado);"></i>Preferencias de Apariencia</div>

          <div class="campo-grupo">
            <label class="campo-label">Tema de la interfaz</label>
            <div style="display:flex; gap:12px; margin-top:4px;">
              <button onclick="cambiarTema('dark')" id="btn-tema-oscuro"
                style="flex:1; padding:10px; border-radius:10px; border:2px solid var(--gris-claro); background:var(--fondo); color:var(--gris-texto); font-family:var(--fuente); font-weight:800; cursor:pointer; font-size:0.82rem; transition:all 0.2s;">
                <i class="fas fa-moon" style="margin-right:6px;"></i>Oscuro
              </button>
              <button onclick="cambiarTema('light')" id="btn-tema-claro"
                style="flex:1; padding:10px; border-radius:10px; border:2px solid var(--gris-claro); background:var(--fondo); color:var(--gris-texto); font-family:var(--fuente); font-weight:800; cursor:pointer; font-size:0.82rem; transition:all 0.2s;">
                <i class="fas fa-sun" style="margin-right:6px;"></i>Claro
              </button>
            </div>
          </div>

          <div class="divider"></div>

          <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0;">
            <div>
              <div style="font-size:0.85rem; font-weight:700; color:var(--gris-texto);">Sonidos de la app</div>
              <div style="font-size:0.72rem; color:var(--gris-medio); margin-top:2px;">Efectos de sonido al completar lecciones</div>
            </div>
            <label class="toggle-switch" style="position:relative; display:inline-block; width:44px; height:24px;">
              <input type="checkbox" id="toggle-sonido" style="opacity:0; width:0; height:0;" onchange="toggleSonido(this)">
              <span style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:var(--gris-claro); border-radius:34px; transition:.3s;"
                    id="toggle-sonido-track">
                <span style="position:absolute; height:18px; width:18px; left:3px; bottom:3px; background:#fff; border-radius:50%; transition:.3s;" id="toggle-sonido-thumb"></span>
              </span>
            </label>
          </div>
        </div>

        <!-- Cerrar sesión -->
        <div class="config-card danger-zone">
          <div class="config-card-titulo"><i class="fas fa-triangle-exclamation"></i>Zona de Riesgo</div>
          <p style="font-size:0.85rem; color:var(--gris-medio); margin-bottom:20px; line-height:1.6;">
            Al cerrar sesión perderás acceso hasta que inicies sesión nuevamente. Tu progreso y XP siempre se guardan automáticamente.
          </p>
          <a href="<?= PROYECTO_PATH ?>/logout"
             style="display:flex; align-items:center; justify-content:center; gap:10px; width:100%; padding:12px; border-radius:12px;
                    background: rgba(255,75,75,0.1); color:var(--rojo); border:2px solid rgba(255,75,75,0.3);
                    font-weight:800; font-size:0.9rem; text-decoration:none; text-transform:uppercase; letter-spacing:0.05em;
                    transition:all 0.2s;"
             onmouseover="this.style.background='rgba(255,75,75,0.2)'"
             onmouseout="this.style.background='rgba(255,75,75,0.1)'">
            <i class="fas fa-right-from-bracket"></i> Cerrar Sesión
          </a>
        </div>

      </div><!-- /config-grid -->
    </div><!-- /perfil-page -->
  </main>
</div>

<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
<script>
  // Resaltar el botón del tema activo
  function actualizarBotonesTema() {
    const tema = document.documentElement.getAttribute('data-theme') || 'dark';
    const btnOscuro = document.getElementById('btn-tema-oscuro');
    const btnClaro  = document.getElementById('btn-tema-claro');
    if (!btnOscuro || !btnClaro) return;
    const estiloActivo   = 'border-color: var(--verde); color: var(--verde); background: rgba(88,204,2,0.1);';
    const estiloInactivo = '';
    btnOscuro.style.cssText += tema === 'dark' ? estiloActivo : estiloInactivo;
    btnClaro.style.cssText  += tema === 'light' ? estiloActivo : estiloInactivo;
  }

  function cambiarTema(nuevoTema) {
    document.documentElement.setAttribute('data-theme', nuevoTema);
    localStorage.setItem('smashcode_tema', nuevoTema);
    // Actualizar el botón en la sidebar también
    const btnSidebar = document.getElementById('btn-cambiar-tema');
    if (btnSidebar) {
      const ico = btnSidebar.querySelector('.tema-icono');
      const lbl = btnSidebar.querySelector('.tema-label');
      if (nuevoTema === 'light') {
        if (ico) ico.className = 'fas fa-moon tema-icono';
        if (lbl) lbl.textContent = 'Oscuro';
      } else {
        if (ico) ico.className = 'fas fa-sun tema-icono';
        if (lbl) lbl.textContent = 'Claro';
      }
    }
    actualizarBotonesTema();
  }

  function toggleSonido(cb) {
    const track = document.getElementById('toggle-sonido-track');
    const thumb = document.getElementById('toggle-sonido-thumb');
    if (cb.checked) {
      track.style.background = 'var(--verde)';
      thumb.style.transform = 'translateX(20px)';
      localStorage.setItem('smashcode_sonido', '1');
    } else {
      track.style.background = 'var(--gris-claro)';
      thumb.style.transform = 'translateX(0)';
      localStorage.setItem('smashcode_sonido', '0');
    }
  }

  // Al cargar: restaurar preferencias
  document.addEventListener('DOMContentLoaded', function() {
    actualizarBotonesTema();
    const sonido = localStorage.getItem('smashcode_sonido') === '1';
    const cbSonido = document.getElementById('toggle-sonido');
    if (cbSonido && sonido) {
      cbSonido.checked = true;
      toggleSonido(cbSonido);
    }
  });
</script>
</body>
</html>
