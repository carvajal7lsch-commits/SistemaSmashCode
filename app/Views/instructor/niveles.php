<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Niveles — Instructor SmashCode</title>
  <meta name="description" content="Panel del instructor: gestiona los 6 niveles del programa de inglés médico.">
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>(function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();</script>
  <style>
    .grid-niveles {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }
    .card-nivel {
      background: var(--blanco);
      border: 1px solid var(--borde-sutil);
      border-radius: 18px;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-nivel:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.2); }
    .card-nivel-imagen {
      width: 100%;
      height: 130px;
      background: linear-gradient(135deg, #1a2d35 0%, #0e3a4a 100%);
      display: flex; align-items: center; justify-content: center;
      font-size: 2.8rem;
      position: relative;
    }
    .card-nivel-imagen img { width:100%; height:100%; object-fit:cover; }
    .card-nivel-body { padding: 16px 18px; }
    .card-nivel-orden { font-size:0.62rem; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:var(--texto-tenue); margin-bottom:4px; }
    .card-nivel-nombre { font-size:1rem; font-weight:800; color:var(--texto-principal); margin:0 0 8px 0; line-height:1.3; }
    .card-nivel-desc { font-size:0.77rem; color:var(--texto-secundario); margin-bottom:14px; line-height:1.55; min-height:32px; }
    .card-nivel-meta { display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:14px; }
    .badge-mcer    { background:rgba(28,176,246,0.13);  color:var(--azul);  border:1px solid rgba(28,176,246,0.25); padding:3px 10px; border-radius:99px; font-size:0.67rem; font-weight:700; }
    .badge-raps    { background:rgba(139,92,246,0.13);  color:#8B5CF6;      border:1px solid rgba(139,92,246,0.25); padding:3px 10px; border-radius:99px; font-size:0.67rem; font-weight:700; }
    .badge-umbral  { background:rgba(245,158,11,0.13);  color:#F59E0B;      border:1px solid rgba(245,158,11,0.25); padding:3px 10px; border-radius:99px; font-size:0.67rem; font-weight:700; }
    .badge-activo  { background:rgba(16,185,129,0.13);  color:#10B981;      border:1px solid rgba(16,185,129,0.3);  padding:3px 10px; border-radius:99px; font-size:0.67rem; font-weight:700; }
    .badge-inactivo{ background:rgba(239,68,68,0.13);   color:#EF4444;      border:1px solid rgba(239,68,68,0.3);   padding:3px 10px; border-radius:99px; font-size:0.67rem; font-weight:700; }
    .card-nivel-acciones { display:flex; gap:8px; }
    .btn-editar-nivel {
      flex:1; display:inline-flex; align-items:center; justify-content:center; gap:6px;
      padding:9px 14px; background:var(--verde-acento); color:#fff; border-radius:10px;
      font-size:0.8rem; font-weight:700; text-decoration:none; transition:opacity 0.15s;
    }
    .btn-editar-nivel:hover { opacity:0.85; }
    .btn-toggle-nivel {
      display:inline-flex; align-items:center; justify-content:center; gap:6px;
      padding:9px 14px; border-radius:10px; font-size:0.8rem; font-weight:700;
      border:none; cursor:pointer; transition:opacity 0.15s;
    }
    .btn-toggle-nivel.desactivar { background:rgba(239,68,68,0.12); color:#EF4444; border:1px solid rgba(239,68,68,0.3); }
    .btn-toggle-nivel.activar    { background:rgba(16,185,129,0.12); color:#10B981; border:1px solid rgba(16,185,129,0.3); }
    .btn-toggle-nivel:hover { opacity:0.75; }
    .alerta-flash { display:flex; align-items:center; gap:10px; padding:12px 18px; border-radius:12px; font-size:0.85rem; font-weight:600; margin-bottom:20px; }
    .alerta-exito { background:rgba(16,185,129,0.12); color:#10B981; border:1px solid rgba(16,185,129,0.3); }
    .alerta-error { background:rgba(239,68,68,0.12);  color:#EF4444;  border:1px solid rgba(239,68,68,0.3); }
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
      <li><a href="<?= PROYECTO_PATH ?>/instructor/niveles" class="nav-enlace activo" aria-current="page"><i class="fas fa-layer-group nav-icono"></i><span>Niveles</span></a></li>
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

    <div class="pagina-contenido">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
          <h1 class="pagina-titulo"><i class="fas fa-layer-group" style="color:var(--azul);margin-right:10px;"></i>Gestión de Niveles</h1>
          <p class="pagina-subtitulo">Edita los 6 niveles del programa · MCER A1 → B2</p>
        </div>
      </div>

      <!-- Alertas -->
      <?php if ($exito): ?>
        <div class="alerta-flash alerta-exito" role="alert">
          <i class="fas fa-check-circle"></i>
          <?= match($exito) { 'actualizado' => 'Nivel actualizado correctamente.', 'estado' => 'Estado del nivel actualizado.', default => 'Operación completada.' } ?>
        </div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alerta-flash alerta-error" role="alert"><i class="fas fa-triangle-exclamation"></i> <?= $error ?></div>
      <?php endif; ?>

      <!-- Grid de niveles -->
      <div class="grid-niveles">
        <?php
        $mcer = ['A1', 'A2', 'B1', 'B1+', 'B2-', 'B2'];
        $iconos = ['🩺','💊','🏥','📋','🚑','🩻'];
        foreach ($niveles as $n):
          $orden = (int)$n['orden'];
          $mcerLabel = $mcer[$orden - 1] ?? 'N/A';
          $icono     = $iconos[$orden - 1] ?? '📚';
        ?>
        <div class="card-nivel <?= $n['activo'] ? '' : 'inactivo' ?>">
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
              <span class="badge-<?= $n['activo'] ? 'activo' : 'inactivo' ?>">
                <i class="fas fa-circle" style="font-size:0.5rem;"></i> <?= $n['activo'] ? 'Activo' : 'Inactivo' ?>
              </span>
            </div>
            <div class="card-nivel-acciones">
              <a href="<?= PROYECTO_PATH ?>/instructor/niveles/editar?id=<?= urlencode($n['id']) ?>" class="btn-editar-nivel">
                <i class="fas fa-pen-to-square"></i> Editar
              </a>
              <form method="POST" action="<?= PROYECTO_PATH ?>/instructor/niveles/toggle" style="margin:0;">
                <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                <input type="hidden" name="id"         value="<?= limpiar($n['id']) ?>">
                <button type="submit" class="btn-toggle-nivel <?= $n['activo'] ? 'desactivar' : 'activar' ?>"
                        onclick="return confirm('<?= $n['activo'] ? '¿Desactivar este nivel?' : '¿Activar este nivel?' ?>')">
                  <i class="fas fa-<?= $n['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                  <?= $n['activo'] ? 'Desactivar' : 'Activar' ?>
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div style="margin-top:24px;padding:14px 18px;background:rgba(28,176,246,0.07);border:1px solid rgba(28,176,246,0.2);border-radius:12px;display:flex;align-items:flex-start;gap:10px;">
        <i class="fas fa-circle-info" style="color:var(--azul);margin-top:2px;"></i>
        <p style="margin:0;font-size:0.78rem;color:var(--texto-secundario);line-height:1.6;">
          Los cambios en los niveles se reflejan inmediatamente en el mapa de aprendizaje de los aprendices.
          No es posible crear ni eliminar niveles; solo editar sus atributos.
        </p>
      </div>

    </div>
  </main>
</div>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
