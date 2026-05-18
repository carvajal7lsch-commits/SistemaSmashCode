<!-- Barra lateral compartida del panel admin -->
<nav class="barra-lateral" aria-label="Navegación administrador">
  <div class="logo-app">
    <div class="logo-icono">🐧</div>
    <div>
      <div class="logo-nombre">Smash<span>Code</span></div>
      <div style="font-size:0.6rem; color:var(--gris-medio); padding-left:2px;">PANEL ADMIN</div>
    </div>
  </div>

  <ul class="nav-lateral">
    <li><span class="nav-grupo-titulo">General</span></li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin" class="nav-enlace <?= (strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/usuarios') === false && strpos($_SERVER['REQUEST_URI'] ?? '', '/admin') !== false) ? 'activo' : '' ?>">
        <i class="fas fa-gauge-high nav-icono"></i><span>Dashboard</span>
      </a>
    </li>

    <li><span class="nav-grupo-titulo">Plataforma</span></li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin/usuarios" class="nav-enlace <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/usuarios') !== false ? 'activo' : '' ?>">
        <i class="fas fa-users nav-icono"></i><span>Usuarios</span>
        <span class="nav-badge"><?= $totalUsuarios ?? '' ?></span>
      </a>
    </li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin/niveles" class="nav-enlace">
        <i class="fas fa-layer-group nav-icono"></i><span>Niveles</span>
      </a>
    </li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin/raps" class="nav-enlace">
        <i class="fas fa-file-lines nav-icono"></i><span>RAPs</span>
      </a>
    </li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin/vocabulario" class="nav-enlace">
        <i class="fas fa-spell-check nav-icono"></i><span>Vocabulario</span>
      </a>
    </li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin/quizzes" class="nav-enlace">
        <i class="fas fa-question-circle nav-icono"></i><span>Quizzes</span>
      </a>
    </li>

    <li><span class="nav-grupo-titulo">Reportes</span></li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin/analytics" class="nav-enlace">
        <i class="fas fa-chart-line nav-icono"></i><span>Analytics</span>
      </a>
    </li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/admin/configuracion" class="nav-enlace">
        <i class="fas fa-gear nav-icono"></i><span>Configuración</span>
      </a>
    </li>
    <li>
      <a href="<?= PROYECTO_PATH ?>/logout" class="nav-enlace" style="color:var(--rojo);">
        <i class="fas fa-right-from-bracket nav-icono"></i><span>Cerrar Sesión</span>
      </a>
    </li>
  </ul>
</nav>
