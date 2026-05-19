<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Admin SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Estilos locales para reforzar la estética premium */
    .stat-icono {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }
    .punto-actividad-glow {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 12px;
      position: relative;
    }
    .punto-verde-glow {
      background: #10B981;
      box-shadow: 0 0 8px #10B981;
    }
    .punto-oro-glow {
      background: #F59E0B;
      box-shadow: 0 0 8px #F59E0B;
    }
    .item-actividad-card {
      padding: 14px 18px;
      border-radius: 12px;
      background: #18262C;
      border: 1px solid var(--borde-sutil);
      margin-bottom: 10px;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .item-actividad-card:hover {
      background: #25373F;
      transform: translateX(4px);
    }
    .estado-operativo-glow {
      background: #ECFDF5;
      border: 1px solid #A7F3D0;
      color: #065F46;
      padding: 6px 16px;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .estado-operativo-glow::before {
      content: '';
      width: 6px;
      height: 6px;
      background: #10B981;
      border-radius: 50%;
      display: inline-block;
      animation: pulse-green 1.5s infinite;
    }
    @keyframes pulse-green {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
  </style>
</head>
<body class="bg-mesh">
<div class="contenedor-app">

  <!-- Barra lateral admin -->
  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <!-- Contenido principal -->
  <main class="contenido-principal">
    <header class="barra-superior" style="background: transparent; border: none; box-shadow: none; margin: 0; padding: 24px 24px 10px; z-index: 90; position:relative; min-height:60px;">
      <div style="display:flex; align-items:center; gap:8px; font-size:0.82rem; font-weight:600; color:var(--texto-tenue);">
        <i class="fas fa-home" style="font-size:0.75rem;"></i>
        <span style="color:var(--texto-secundario); font-weight:700;">Dashboard</span>
      </div>
      <div style="margin-left: auto; display:flex; align-items:center; gap:16px;">
        <div class="stat-xp" style="font-weight: 800; color: var(--naranja); font-size: 0.9rem; display: flex; align-items: center; gap: 6px;">
          <i class="fas fa-bolt" style="animation: pulse-green 2s infinite;"></i> <?= formatearXP((int)$totalXP) ?> XP Total
        </div>
        <div class="avatar-usuario" style="border: 2px solid var(--verde); background: linear-gradient(135deg, var(--verde), var(--azul)); font-weight: 800; cursor: default;" title="<?= limpiar($_SESSION['nombre']) ?>">
          <?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?>
        </div>
      </div>
    </header>

    <div class="pagina-contenido" style="padding: 10px 24px 32px;">
      <!-- Encabezado -->
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
        <div>
          <h1 class="pagina-titulo" style="font-size:1.8rem; font-weight:800; letter-spacing:-0.5px;">Dashboard</h1>
          <p class="pagina-subtitulo" style="margin-bottom:0; color:var(--texto-secundario);">
            ¡Bienvenido, <strong style="color:var(--texto-principal);"><?= limpiar(explode(' ', $_SESSION['nombre'])[0]) ?></strong>! 👋
            &nbsp;— Resumen de control de Smash Code
          </p>
        </div>
      </div>

      <!-- KPIs Premium Grid -->
      <div class="grid-estadisticas" style="margin-bottom: 28px; gap: 20px;">
        
        <!-- CARD 1 -->
        <div class="tarjeta-premium card-azul">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <span class="stat-etiqueta" style="color:var(--azul-oscuro); font-weight:700;">Total Usuarios</span>
            <div class="stat-icono" style="background:rgba(28,176,246,0.1); color:var(--azul);"><i class="fas fa-users"></i></div>
          </div>
          <div class="stat-valor" style="font-size:2.2rem; font-weight:800; color:var(--texto-principal);"><?= $totalUsuarios ?></div>
          <div class="stat-cambio" style="color:var(--azul-oscuro); font-weight:600; font-size:0.75rem; margin-top:8px; display:flex; align-items:center; gap:4px;">
            <i class="fas fa-arrow-trend-up"></i> +12 este mes
          </div>
        </div>

        <!-- CARD 2 -->
        <div class="tarjeta-premium card-verde">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <span class="stat-etiqueta" style="color:var(--verde-oscuro); font-weight:700;">Aprendices Activos</span>
            <div class="stat-icono" style="background:rgba(16,185,129,0.1); color:#10B981;"><i class="fas fa-running"></i></div>
          </div>
          <div class="stat-valor" style="font-size:2.2rem; font-weight:800; color:var(--texto-principal);"><?= $aprendicesActivos ?></div>
          <div class="stat-cambio" style="color:var(--verde-oscuro); font-weight:600; font-size:0.75rem; margin-top:8px; display:flex; align-items:center; gap:4px;">
            <i class="fas fa-arrow-trend-up"></i> +8 esta semana
          </div>
        </div>

        <!-- CARD 3 -->
        <div class="tarjeta-premium card-naranja">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <span class="stat-etiqueta" style="color:#D97706; font-weight:700;">XP Generado</span>
            <div class="stat-icono" style="background:rgba(245,158,11,0.1); color:#F59E0B;"><i class="fas fa-bolt"></i></div>
          </div>
          <div class="stat-valor" style="font-size:2.2rem; font-weight:800; color:var(--texto-principal);"><?= $totalXP >= 1000 ? round($totalXP/1000,1).'K' : $totalXP ?></div>
          <div class="stat-cambio" style="color:#D97706; font-weight:600; font-size:0.75rem; margin-top:8px; display:flex; align-items:center; gap:4px;">
            <i class="fas fa-fire" style="color:#EF4444;"></i> Racha global activa
          </div>
        </div>

        <!-- CARD 4 -->
        <div class="tarjeta-premium card-lila">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <span class="stat-etiqueta" style="color:#7C3AED; font-weight:700;">Quizzes Listos</span>
            <div class="stat-icono" style="background:rgba(139,92,246,0.1); color:#8B5CF6;"><i class="fas fa-file-invoice"></i></div>
          </div>
          <div class="stat-valor" style="font-size:2.2rem; font-weight:800; color:var(--texto-principal);"><?= $quizzesCompletos ?></div>
          <div class="stat-cambio" style="color:#7C3AED; font-weight:600; font-size:0.75rem; margin-top:8px; display:flex; align-items:center; gap:4px;">
            <i class="fas fa-check-double"></i> 100% de integridad
          </div>
        </div>

      </div>

      <!-- Gráfico + Actividad reciente -->
      <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px;">

        <!-- Gráfico de barras premium -->
        <div class="tarjeta-premium" style="padding: 24px 28px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <span style="font-size: 0.95rem; font-weight:700; color:var(--texto-principal); display:flex; align-items:center; gap:8px;">
              <i class="fas fa-chart-line" style="color: var(--azul);"></i>
              Rendimiento Semanal (Quizzes Completados)
            </span>
            <span style="font-size: 0.75rem; color: var(--texto-tenue); font-weight: 600; background:var(--gris-claro); padding:4px 10px; border-radius:6px;">Últimos 7 días</span>
          </div>
          
          <div class="barra-chart-premium" id="grafico-quizzes">
            <!-- Barras generadas por JS dinámicamente -->
          </div>
          
          <div class="etiquetas-dias" style="margin-top: 12px; border-top: 1px solid var(--borde-sutil); padding-top: 10px;">
            <span style="font-weight:700; color:var(--texto-secundario);">Lun</span>
            <span style="font-weight:700; color:var(--texto-secundario);">Mar</span>
            <span style="font-weight:700; color:var(--texto-secundario);">Mié</span>
            <span style="font-weight:700; color:var(--texto-secundario);">Jue</span>
            <span style="font-weight:700; color:var(--texto-secundario);">Vie</span>
            <span style="font-weight:700; color:var(--texto-secundario);">Sáb</span>
            <span style="font-weight:700; color:var(--texto-secundario);">Dom</span>
          </div>
        </div>

        <!-- Actividad reciente Premium -->
        <div class="tarjeta-premium" style="display:flex; flex-direction:column;">
          <div style="margin-bottom:20px; display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size: 0.95rem; font-weight:700; color:var(--texto-principal); display:flex; align-items:center; gap:8px;">
              <i class="fas fa-history" style="color: var(--naranja);"></i>
              Actividad Académica Reciente
            </span>
          </div>
          
          <div style="flex:1; overflow-y:auto; max-height:220px; padding-right:4px;">
            <?php if (empty($actividad)): ?>
              <div style="text-align:center; padding:40px 20px; color:var(--texto-tenue);">
                <i class="fas fa-face-meh" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                Aún no hay actividad registrada hoy.
              </div>
            <?php else: ?>
              <?php foreach ($actividad as $a): ?>
              <div class="item-actividad-card">
                <div style="display:flex; align-items:center;">
                  <span class="punto-actividad-glow <?= $a['aprobado'] ? 'punto-verde-glow' : 'punto-oro-glow' ?>"></span>
                  <div>
                    <strong style="color:var(--texto-principal); font-size:0.85rem; display:block;"><?= limpiar($a['nombre_completo']) ?></strong>
                    <span style="color:var(--texto-secundario); font-size:0.75rem;">Completó <?= limpiar(substr($a['rap_titulo'],0,28)) ?>...</span>
                  </div>
                </div>
                <div style="text-align:right;">
                  <span style="font-weight:800; font-size:0.85rem; color:<?= $a['aprobado'] ? '#10B981' : '#F59E0B' ?>;"><?= number_format($a['puntaje'], 0) ?>%</span>
                  <span style="display:block; font-size:0.65rem; color:var(--texto-tenue); margin-top:2px;">
                    <?= date('H:i a', strtotime($a['creado_en'])) ?>
                  </span>
                </div>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

      </div><!-- /grid -->
    </div><!-- /pagina-contenido -->
  </main>
</div>

<script>
  /* Generación dinámica de barras premium con Tooltip nativo */
  const datos = [12, 8, 15, 22, 18, 5, 11];
  const max   = Math.max(...datos);
  const cont  = document.getElementById('grafico-quizzes');
  datos.forEach((v, i) => {
    const col = document.createElement('div');
    col.className = 'columna' + (i === 3 ? ' destacada' : '');
    col.style.height = (v / max * 100) + '%';
    col.setAttribute('title', `Quizzes: ${v}`);
    cont.appendChild(col);
  });
</script>
</body>
</html>
