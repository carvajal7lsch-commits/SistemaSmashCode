<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aprender — SmashCode Enfermería SENA</title>
  <meta name="description" content="Aprende inglés clínico con SmashCode, plataforma gamificada para enfermería SENA.">
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>/* Aplicar tema guardado antes del paint para evitar parpadeo */
  (function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();
  </script>
  <style>
    /* Panel aprendiz — tema claro Duolingo */
    .contenedor-aprendiz {
      display: flex;
      gap: 0;
      min-height: 100vh;
      background-color: #F7F9FB; /* Light background */
    }
    .zona-mapa {
      flex: 1;
      padding: 40px 28px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    /* Estilos de la tarjeta de cabecera de nivel */
    .seccion-nivel-card {
      background: #58CC02; /* Duolingo Green */
      border-radius: 16px;
      padding: 16px 20px;
      display: flex;
      align-items: center;
      gap: 16px;
      width: 100%;
      max-width: 580px;
      color: #fff;
      box-shadow: 0 4px 0 #46A302;
      position: relative;
      z-index: 2;
    }
    .seccion-nivel-card.bloqueado {
      background: #E5E5E5;
      color: #AFAFAF;
      box-shadow: 0 4px 0 #CECECE;
    }
    .seccion-nivel-card .icono-etapa {
      background: #fff;
      border-radius: 8px;
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      color: #58CC02;
      flex-shrink: 0;
      box-shadow: 0 2px 0 rgba(0,0,0,0.1);
    }
    .seccion-nivel-card.bloqueado .icono-etapa {
      color: #AFAFAF;
    }
    .seccion-nivel-card .info-etapa {
      flex: 1;
    }
    .seccion-nivel-card .texto-etapa {
      font-size: 0.8rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
      opacity: 0.9;
    }
    .seccion-nivel-card .titulo-etapa {
      font-size: 1.3rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin: 0;
    }
    .seccion-nivel-card .btn-guia {
      background: transparent;
      border: 2px solid rgba(255,255,255,0.4);
      color: #fff;
      padding: 8px 16px;
      border-radius: 12px;
      font-size: 0.85rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }
    .seccion-nivel-card .btn-guia:hover {
      background: rgba(255,255,255,0.15);
      border-color: #fff;
    }
    .seccion-nivel-card.bloqueado .btn-guia {
      display: none;
    }
    
    /* ── Línea del mapa ── */
    .linea-mapa {
      width: 8px;
      height: 48px;
      background: #E5E5E5;
      margin: -2px 0;
      border-radius: 0;
      z-index: 1;
    }
    /* ── Grupo de cada nodo (burbuja + pingüino lateral) ── */
    .grupo-rap {
      display: flex; flex-direction: column;
      align-items: center; position: relative;
      margin-bottom: 24px;
      z-index: 2;
    }
    /* Burbuja circular del nodo */
    .burbuja-rap {
      width: 80px; height: 80px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.8rem; font-weight: 900;
      cursor: pointer; transition: transform 0.15s;
      position: relative;
      background: #E5E5E5;
      border: 6px solid #F7F9FB;
      box-shadow: 0 0 0 4px #E5E5E5, 0 6px 0 4px #CECECE;
      color: #AFAFAF;
    }
    .burbuja-rap:hover { transform: scale(1.05); }
    
    /* Estado completado (Dorado) */
    .burbuja-rap.completado {
      background: #FFC800;
      box-shadow: 0 0 0 4px #FFC800, 0 6px 0 4px #E5B400;
      color: #fff;
    }
    /* Estado disponible/en progreso (Dorado con aura) */
    .burbuja-rap.disponible, .burbuja-rap.en_progreso {
      background: #FFC800;
      box-shadow: 0 0 0 4px #FFC800, 0 6px 0 4px #E5B400, 0 0 20px 8px rgba(255, 200, 0, 0.4);
      color: #fff;
      animation: bounce 2s infinite ease-in-out;
    }
    /* Estado bloqueado (Gris) - default */
    .burbuja-rap.bloqueado {
      cursor: not-allowed;
    }
    .burbuja-rap.bloqueado:hover { transform: none; }
    
    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    .etiqueta-burbuja {
      font-size: 0.85rem; font-weight: 800;
      color: #AFAFAF; margin-top: 20px;
      text-transform: uppercase; letter-spacing: 1px;
    }
    .burbuja-rap.disponible ~ .etiqueta-burbuja,
    .burbuja-rap.en_progreso ~ .etiqueta-burbuja { color: #58CC02; }
    .burbuja-rap.completado ~ .etiqueta-burbuja { color: #FFC800; }
    /* Panel derecho */
    .panel-lateral-derecho {
      width: 320px; flex-shrink: 0;
      padding: 28px 20px; display: flex;
      flex-direction: column; gap: 14px;
      border-left: 2px solid var(--borde);
    }
    .tarjeta-liga {
      background: var(--blanco); border: 2px solid var(--borde);
      border-radius: var(--radio); padding: 16px;
    }
    .tarjeta-liga .titulo-tarjeta {
      font-size: 0.78rem; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.06em;
      color: var(--gris-medio); margin-bottom: 8px;
      display: flex; align-items: center; gap: 8px;
    }
    .tarjeta-liga .titulo-tarjeta a { margin-left:auto; color:var(--azul); font-size:0.7rem; }
    .tarjeta-liga p { font-size: 0.82rem; color: var(--gris-medio); }
    .desafio-item {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 0; border-bottom: 2px solid var(--borde);
    }
    .desafio-item:last-child { border-bottom: none; }
    .desafio-texto { flex:1; font-size:0.82rem; font-weight:600; color:var(--gris-texto); }
    .mini-barra { height:8px; background:var(--gris-claro); border-radius:var(--radio-full); overflow:hidden; margin-top:4px; }
    .mini-barra .relleno { height:100%; background:var(--naranja); border-radius:var(--radio-full); }
    .mini-texto { font-size:0.65rem; color:var(--gris-medio); margin-top:2px; }
    .caja-acceso {
      background: var(--blanco); border: 2px solid var(--borde);
      border-radius: var(--radio); padding: 20px;
      display: flex; flex-direction: column; gap: 10px; text-align:center;
    }
    .caja-acceso p { font-size:0.85rem; color:var(--gris-texto); font-weight:600; margin-bottom:4px; }
  </style>
</head>
<body>

<div class="contenedor-app">

  <!-- ============ BARRA LATERAL ============ -->
  <nav class="barra-lateral" aria-label="Navegación principal">
    <div class="logo-app">
      <div class="logo-icono">
        <svg viewBox="0 0 100 100" width="40" height="40" xmlns="http://www.w3.org/2000/svg" style="display: block;">
          <!-- Sombra sutil -->
          <ellipse cx="50" cy="85" rx="22" ry="5" fill="#000" opacity="0.3" />
          
          <!-- Patitas (Naranja Duolingo) -->
          <ellipse cx="38" cy="82" rx="7" ry="4" fill="#FF9600" />
          <ellipse cx="62" cy="82" rx="7" ry="4" fill="#FF9600" />
          
          <!-- Cuerpo Principal (Azul oscuro mate Duolingo) -->
          <rect x="26" y="20" width="48" height="58" rx="24" fill="#2B3E46" />
          
          <!-- Aletas laterales -->
          <!-- Izquierda -->
          <path d="M 26 38 C 17 42 17 56 26 62 Z" fill="#2B3E46" />
          <!-- Derecha -->
          <path d="M 74 38 C 83 42 83 56 74 62 Z" fill="#2B3E46" />
          
          <!-- Barriga (Blanca redonda) -->
          <ellipse cx="50" cy="54" rx="17" ry="20" fill="#FFFFFF" />
          
          <!-- Cara (Parches blancos de los ojos) -->
          <ellipse cx="41" cy="38" rx="9" ry="9" fill="#FFFFFF" />
          <ellipse cx="59" cy="38" rx="9" ry="9" fill="#FFFFFF" />
          
          <!-- Ojos Grandes Lindos -->
          <!-- Ojo Izquierdo -->
          <circle cx="42" cy="38" r="5" fill="#111B1E" />
          <circle cx="40.5" cy="36.5" r="1.8" fill="#FFFFFF" />
          <!-- Ojo Derecho -->
          <circle cx="58" cy="38" r="5" fill="#111B1E" />
          <circle cx="56.5" cy="36.5" r="1.8" fill="#FFFFFF" />
          
          <!-- Pico Naranja Lindo -->
          <path d="M 44 43 Q 50 51 56 43 Z" fill="#FF9600" stroke="#FF9600" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
      <div>
        <div class="logo-nombre">Smash<span>Code</span></div>
        <div style="font-size: 0.62rem; color: #52656D; letter-spacing: 1.5px; font-weight: 800; padding-left: 2px; margin-top: 2px;">APRENDIZ</div>
      </div>
    </div>

    <ul class="nav-lateral">
      <li>
        <a href="<?= PROYECTO_PATH ?>/" class="nav-enlace activo" aria-current="page">
          <i class="fas fa-book-open nav-icono"></i>
          <span>Aprender</span>
        </a>
      </li>
      <li>
        <a href="<?= PROYECTO_PATH ?>/aprendiz/vocabulario" class="nav-enlace">
          <i class="fas fa-spell-check nav-icono"></i>
          <span>Vocabulario</span>
        </a>
      </li>
      <li>
        <a href="<?= PROYECTO_PATH ?>/modulos/aprendiz/dialogos.php" class="nav-enlace">
          <i class="fas fa-comments nav-icono"></i>
          <span>Diálogos</span>
        </a>
      </li>
      <li>
        <a href="<?= PROYECTO_PATH ?>/modulos/aprendiz/ejercicios.php" class="nav-enlace">
          <i class="fas fa-dumbbell nav-icono"></i>
          <span>Ejercicios</span>
        </a>
      </li>
      <li>
        <a href="<?= PROYECTO_PATH ?>/modulos/aprendiz/glosario.php" class="nav-enlace">
          <i class="fas fa-book-medical nav-icono"></i>
          <span>Glosario</span>
        </a>
      </li>
      <?php if ($autenticado): ?>
      <li>
        <a href="<?= PROYECTO_PATH ?>/modulos/aprendiz/perfil.php" class="nav-enlace">
          <i class="fas fa-user nav-icono"></i>
          <span>Perfil</span>
        </a>
      </li>
      <li>
        <a href="<?= PROYECTO_PATH ?>/logout" class="nav-enlace" style="color:var(--rojo);">
          <i class="fas fa-right-from-bracket nav-icono"></i>
          <span>Cerrar Sesión</span>
        </a>
      </li>
      <?php endif; ?>
    </ul>

    <!-- Botón cambio de tema al fondo de la barra lateral -->
    <div style="padding: 16px 14px; border-top: 2px solid var(--borde-sutil); margin-top: auto; display: flex; justify-content: center;">
      <button id="btn-cambiar-tema" class="btn-tema" style="width: 100%; justify-content: center;" aria-label="Cambiar a modo claro" title="Cambiar a modo claro">
        <i class="fas fa-sun tema-icono"></i>
        <span class="tema-label">Claro</span>
      </button>
    </div>
  </nav>

  <!-- ============ CONTENIDO PRINCIPAL ============ -->
  <main class="contenido-principal">

    <!-- Barra superior -->
    <?php if ($autenticado && $usuario): ?>
    <header class="barra-superior">
      <div class="stat-xp">
        <i class="fas fa-bolt"></i>
        <?= formatearXP($usuario['xp_puntos']) ?> XP
      </div>
      <div class="stat-racha">
        <i class="fas fa-fire"></i>
        Racha: 0 días
      </div>

      <div style="margin-left: auto; display:flex; align-items:center; gap:16px;">
        <div class="avatar-usuario" title="<?= limpiar($usuario['nombre_completo']) ?>">
          <?= strtoupper(substr($usuario['nombre_completo'], 0, 1)) ?>
        </div>
      </div>
    </header>
    <?php endif; ?>

    <!-- Zona del mapa + panel derecho -->
    <div class="contenedor-aprendiz">

      <!-- MAPA DE PROGRESO -->
      <section class="zona-mapa">
        <?php
        $primerActivo = true; // Controla en cuál nodo aparece el pingüino
        foreach ($niveles as $nivel):
          $estado = $autenticado
              ? (isset($mapaProgreso[$nivel['rap_id']])
                  ? ($mapaProgreso[$nivel['rap_id']]['completado'] ? 'completado' : ($mapaProgreso[$nivel['rap_id']]['porcentaje'] > 0 ? 'en_progreso' : 'disponible'))
                  : ($nivel['orden'] === 1 ? 'disponible' : 'bloqueado')) // Nivel 1 siempre disponible
              : ($nivel['orden'] === 1 ? 'disponible' : 'bloqueado');

          // Lógica de desbloqueo avanzado
          if ($autenticado && $estado === 'bloqueado' && $nivel['orden'] > 1) {
              $anteriorOrden = $nivel['orden'] - 1;
              $nivelAnterior = array_filter($niveles, fn($n) => $n['orden'] === $anteriorOrden);
              $nivelAnterior = reset($nivelAnterior);
              if ($nivelAnterior && isset($mapaProgreso[$nivelAnterior['rap_id']])) {
                  if ($mapaProgreso[$nivelAnterior['rap_id']]['porcentaje'] >= 80) {
                      $estado = 'disponible';
                  }
              }
          }

          $iconos = ['🏥','📋','❤️','💊','🚨','⭐'];
          $icono  = $iconos[$nivel['orden'] - 1] ?? '📘';

          /* El pingüino aparece solo en el primer nodo disponible/en progreso */
          $esPrincipal = ($estado === 'disponible' || $estado === 'en_progreso') && $primerActivo;
          if ($esPrincipal) $primerActivo = false;

          /* Ícono dentro de la burbuja según estado */
          $iconoBurbuja = match($estado) {
            'completado'  => '<i class="fas fa-check" style="font-size:1.6rem;"></i>',
            'en_progreso',
            'disponible'  => '<i class="fas fa-star"  style="font-size:1.6rem;"></i>',
            default       => '<i class="fas fa-lock"  style="font-size:1.4rem;"></i>',
          };

          $urlRap = $autenticado && $estado !== 'bloqueado'
              ? PROYECTO_PATH . '/modulos/aprendiz/rap.php?id=' . urlencode($nivel['rap_id'])
              : '#';
        ?>

        <!-- Cabecera de sección (barra verde estilo Duolingo) -->
        <div class="seccion-nivel-card <?= $estado === 'bloqueado' ? 'bloqueado' : '' ?>">
          <div class="icono-etapa"><?= $icono ?></div>
          <div class="info-etapa">
            <div class="texto-etapa">ETAPA 1, SECCIÓN <?= $nivel['orden'] ?></div>
            <h2 class="titulo-etapa"><?= limpiar($nivel['nombre']) ?></h2>
          </div>
          <button class="btn-guia">
            <i class="fas fa-book-open"></i> GUÍA
          </button>
        </div>

        <!-- Línea -->
        <div class="linea-mapa"></div>
        
        <!-- Nodo -->
        <div class="grupo-rap">
          <div class="burbuja-rap <?= $estado ?>"
               onclick="<?= $estado !== 'bloqueado' ? "window.location='{$urlRap}'" : "mostrarMensajeBloqueado()" ?>"
               title="<?= limpiar($nivel['rap_titulo']) ?>"
               role="button"
               tabindex="<?= $estado === 'bloqueado' ? '-1' : '0' ?>">
            <?= $iconoBurbuja ?>
          </div>

          <?php if ($esPrincipal): ?>
            <span class="etiqueta-burbuja">EMPEZAR</span>
          <?php elseif ($estado === 'completado'): ?>
            <span class="etiqueta-burbuja">COMPLETADO</span>
          <?php elseif ($estado === 'bloqueado'): ?>
            <span class="etiqueta-burbuja">BLOQUEADO</span>
          <?php endif; ?>
        </div>
        
        <!-- Línea final hacia el siguiente nodo si no es el último -->
        <?php if ($nivel['orden'] < count($niveles)): ?>
          <div class="linea-mapa"></div>
        <?php endif; ?>

        <?php endforeach; ?>
      </section>

      <!-- PANEL LATERAL DERECHO -->
      <aside class="panel-lateral-derecho" aria-label="Panel de gamificación">

        <!-- ¡Compite en las ligas! -->
        <div class="tarjeta-liga">
          <div class="titulo-tarjeta">🏆 ¡Compite en las Ligas!</div>
          <p>Completa lecciones para empezar a competir</p>
        </div>

        <!-- Desafíos del día -->
        <div class="tarjeta-liga">
          <div class="titulo-tarjeta">
            ⚡ Desafíos del día
            <a href="#">VER TODOS</a>
          </div>
          <div class="desafio-item">
            <span style="font-size:1.3rem; color:var(--naranja);">⚡</span>
            <div class="desafio-texto">
              Gana 10 XP
              <div class="mini-barra">
                <div class="relleno" style="width:<?= $autenticado ? min(100,($usuario['xp_puntos']??0)/10*100) : 0 ?>%"></div>
              </div>
              <div class="mini-texto"><?= $autenticado ? min(10,$usuario['xp_puntos']??0) : 0 ?> / 10</div>
            </div>
            <span style="font-size:1.4rem;">🎁</span>
          </div>
        </div>

        <!-- CTA para visitantes / insignias para autenticados -->
        <?php if (!$autenticado): ?>
        <div class="caja-acceso">
          <p>¡Ingresa para guardar tu progreso!</p>
          <a href="<?= PROYECTO_PATH ?>/login" class="btn btn-verde">INGRESAR</a>
        </div>
        <?php else: ?>
        <div class="tarjeta-liga">
          <div class="titulo-tarjeta">🎖 Mis Insignias</div>
          <p>Completa RAPs y quizzes para ganar insignias.</p>
        </div>
        <?php endif; ?>

      </aside>
    </div><!-- /contenedor-aprendiz -->
  </main>
</div><!-- /contenedor-app -->

<script>
  /* Mostrar mensaje cuando el aprendiz intenta acceder a un nivel bloqueado */
  function mostrarMensajeBloqueado() {
    alert('🔒 Este nivel está bloqueado. Completa el nivel anterior con al menos 80% de progreso.');
  }
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
