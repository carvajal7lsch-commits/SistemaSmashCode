<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glosario Médico — SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>
    (function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();
  </script>
  <style>
    .glosario-container {
      display: flex;
      flex-direction: column;
      padding: 32px 40px;
      background: var(--fondo);
      flex: 1;
      height: 100vh;
      overflow-y: auto;
      gap: 28px;
    }

    .header-seccion {
      display: flex;
      align-items: center;
      gap: 20px;
      padding-bottom: 20px;
      border-bottom: 2px solid var(--gris-claro);
    }
    .header-seccion i {
      font-size: 2.2rem;
      color: var(--verde);
      background: rgba(88,204,2,0.1);
      padding: 16px;
      border-radius: 16px;
    }
    .header-seccion h1 { font-size: 1.8rem; font-weight: 900; margin: 0 0 4px 0; color: var(--gris-texto); }
    .header-seccion p { margin: 0; color: var(--texto-tenue); font-size: 0.9rem; }

    /* Filtros card */
    .filtros-card {
      background: var(--blanco);
      border: 2px solid var(--gris-claro);
      border-radius: 16px;
      padding: 20px 24px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .filtros-row {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 16px;
    }
    @media (max-width: 900px) {
      .filtros-row { grid-template-columns: 1fr; }
    }

    .filtro-input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }
    .filtro-input-wrap i {
      position: absolute;
      left: 14px;
      color: var(--gris-medio);
      font-size: 0.9rem;
      pointer-events: none;
    }
    .filtro-campo {
      width: 100%;
      padding: 10px 12px 10px 38px;
      border: 2px solid var(--gris-claro);
      border-radius: 10px;
      font-size: 0.85rem;
      font-family: var(--fuente);
      background: var(--fondo);
      color: var(--gris-texto);
      outline: none;
      transition: all 0.2s;
    }
    .filtro-campo:focus {
      border-color: var(--verde);
      background: var(--blanco);
    }

    .btn-filtrar {
      background: var(--verde);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-weight: 800;
      font-family: var(--fuente);
      cursor: pointer;
      box-shadow: 0 4px 0 var(--verde-oscuro);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.1s;
    }
    .btn-filtrar:active {
      transform: translateY(4px);
      box-shadow: none;
    }

    /* Listado de términos */
    .vocab-table-card {
      background: var(--blanco);
      border: 2px solid var(--gris-claro);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(0,0,0,0.02);
    }
    
    .vocab-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }
    .vocab-table th {
      background: var(--fondo);
      padding: 16px 20px;
      font-size: 0.75rem;
      text-transform: uppercase;
      font-weight: 800;
      letter-spacing: 0.08em;
      color: var(--gris-medio);
      border-bottom: 2px solid var(--gris-claro);
    }
    .vocab-table td {
      padding: 18px 20px;
      border-bottom: 1px solid var(--gris-claro);
      font-size: 0.9rem;
      color: var(--gris-texto);
      vertical-align: middle;
    }
    .vocab-row:hover { background: rgba(0,0,0,0.01); }

    .term-english { font-size: 1.1rem; font-weight: 800; color: var(--gris-texto); display: flex; align-items: center; gap: 8px; }
    .term-ipa { font-family: monospace; font-size: 0.82rem; color: var(--azul-oscuro); background: rgba(28,176,246,0.08); padding: 2px 6px; border-radius: 4px; }
    .term-spanish { font-weight: 700; color: var(--verde-oscuro); }
    
    .tag-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 99px;
      font-size: 0.7rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }
    .tag-badge.area { background: rgba(28,176,246,0.1); color: var(--azul-oscuro); }
    .tag-badge.cat { background: rgba(168,85,247,0.1); color: var(--morado); }
    .tag-badge.nivel { background: rgba(88,204,2,0.1); color: var(--verde-oscuro); }

    .btn-audio-play {
      background: var(--azul);
      color: white;
      border: none;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 3px 0 var(--azul-oscuro);
      transition: all 0.1s;
    }
    .btn-audio-play:active {
      transform: translateY(3px);
      box-shadow: none;
    }

    .term-example { font-style: italic; color: var(--texto-tenue); font-size: 0.82rem; line-height: 1.4; max-width: 350px; }
  </style>
</head>
<body>
<div class="contenedor-app">
  <?php include dirname(__DIR__) . '/layouts/aprendiz_sidebar.php'; ?>

  <main class="contenido-principal">
    <div class="glosario-container">
      
      <!-- HEADER -->
      <div class="header-seccion">
        <i class="fas fa-book-medical"></i>
        <div>
          <h1>Glosario Clínico Bilingüe</h1>
          <p>Consulta términos técnicos, categorías gramaticales, áreas de enfermería y escucha pronunciaciones IPA inmediatas.</p>
        </div>
      </div>

      <!-- FORMULARIO DE FILTROS -->
      <form class="filtros-card" method="GET" action="<?= PROYECTO_PATH ?>/aprendiz/glosario">
        <div class="filtros-row">
          
          <!-- Búsqueda texto -->
          <div class="filtro-input-wrap">
            <i class="fas fa-search"></i>
            <input type="text" name="q" class="filtro-campo" placeholder="Buscar término..." value="<?= htmlspecialchars($busqueda) ?>">
          </div>

          <!-- Filtro Área -->
          <div class="filtro-input-wrap">
            <i class="fas fa-hospital"></i>
            <select name="area" class="filtro-campo" style="padding-left: 38px;">
              <option value="">Todas las Áreas</option>
              <?php foreach ($areas as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $areaId === $a['id'] ? 'selected' : '' ?>><?= htmlspecialchars($a['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Filtro Categoría -->
          <div class="filtro-input-wrap">
            <i class="fas fa-tags"></i>
            <select name="categoria" class="filtro-campo" style="padding-left: 38px;">
              <option value="">Todas las Categorías</option>
              <?php foreach ($categorias as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $categoriaId === $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Filtro Nivel -->
          <div class="filtro-input-wrap">
            <i class="fas fa-graduation-cap"></i>
            <select name="nivel" class="filtro-campo" style="padding-left: 38px;">
              <option value="">Todos los Niveles</option>
              <?php foreach ($niveles as $n): ?>
                <option value="<?= $n['id'] ?>" <?= $nivelId === $n['id'] ? 'selected' : '' ?>><?= htmlspecialchars($n['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

        </div>

        <div style="display:flex; justify-content:space-between; align-items:center;">
          <small style="color:var(--gris-medio); font-weight:700;">Resultados encontrados: <?= count($vocabulario) ?></small>
          <div style="display:flex; gap:12px;">
            <?php if ($busqueda || $areaId || $categoriaId || $nivelId): ?>
              <a href="<?= PROYECTO_PATH ?>/aprendiz/glosario" class="btn-gris" style="text-decoration:none; padding:10px 20px; display:inline-flex; align-items:center; border-radius:10px; font-weight:800; font-size:0.85rem;">Limpiar</a>
            <?php endif; ?>
            <button type="submit" class="btn-filtrar">
              <i class="fas fa-filter"></i> Filtrar
            </button>
          </div>
        </div>
      </form>

      <!-- TABLA DE RESULTADOS -->
      <div class="vocab-table-card">
        <?php if (empty($vocabulario)): ?>
          <div style="padding: 40px; text-align:center; color:var(--texto-tenue);">
            <i class="fas fa-face-frown" style="font-size: 3rem; color:var(--gris-claro); margin-bottom:12px; display:block;"></i>
            <h3>No se encontraron términos clínicos</h3>
            <p style="font-size: 0.85rem; margin-top:4px;">Intenta ajustando los criterios de búsqueda o filtros.</p>
          </div>
        <?php else: ?>
          <table class="vocab-table">
            <thead>
              <tr>
                <th>Término en Inglés</th>
                <th>Traducción</th>
                <th>Metadata</th>
                <th>Ejemplo Contextualizado</th>
                <th style="width: 60px; text-align:center;">Audio</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($vocabulario as $v): ?>
                <tr class="vocab-row">
                  <td>
                    <div class="term-english">
                      <?= htmlspecialchars($v['termino_en']) ?>
                      <?php if ($v['transcripcion_ipa']): ?>
                        <span class="term-ipa" title="Transcripción Fonética IPA"><?= htmlspecialchars($v['transcripcion_ipa']) ?></span>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td>
                    <span class="term-spanish"><?= htmlspecialchars($v['termino_es']) ?></span>
                  </td>
                  <td>
                    <div style="display:flex; flex-direction:column; gap:6px; align-items:flex-start;">
                      <?php if ($v['area_nombre']): ?>
                        <span class="tag-badge area" title="Área Clínica"><i class="fas fa-hospital-alt" style="margin-right:4px;"></i><?= htmlspecialchars($v['area_nombre']) ?></span>
                      <?php endif; ?>
                      <?php if ($v['categoria_nombre']): ?>
                        <span class="tag-badge cat" title="Categoría Gramatical"><i class="fas fa-tag" style="margin-right:4px;"></i><?= htmlspecialchars($v['categoria_nombre']) ?></span>
                      <?php endif; ?>
                      <?php if ($v['nivel_nombre']): ?>
                        <span class="tag-badge nivel" title="Nivel Académico"><i class="fas fa-layer-group" style="margin-right:4px;"></i><?= htmlspecialchars($v['nivel_nombre']) ?></span>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td>
                    <div class="term-example" title="Contexto de uso clínico">
                      <?= htmlspecialchars($v['oracion_ejemplo']) ?>
                    </div>
                  </td>
                  <td style="text-align:center;">
                    <button class="btn-audio-play" onclick="speakWord('<?= addslashes($v['termino_en']) ?>')" title="Escuchar término en inglés">
                      <i class="fas fa-volume-up"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

    </div>
  </main>
</div>

<script>
  function speakWord(text) {
    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel();
      let utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'en-US';
      utterance.rate = 0.9;
      
      let voices = window.speechSynthesis.getVoices();
      let enVoice = voices.find(v => v.lang.startsWith('en'));
      if (enVoice) utterance.voice = enVoice;
      
      window.speechSynthesis.speak(utterance);
    } else {
      console.log("Audio Speech synthesis not supported.");
    }
  }

  // Pre-cargar voces al inicio
  if ('speechSynthesis' in window) {
    window.speechSynthesis.onvoiceschanged = () => {};
  }
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
