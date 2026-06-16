<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Vocabulario — SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>
    (function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();
  </script>
  <style>
    .module-view { display: flex; flex-direction: column; padding: 32px 40px; background: var(--fondo); flex: 1; height: 100vh; overflow-y: auto; gap: 28px; }
    .module-header { display: flex; align-items: center; gap: 20px; padding-bottom: 20px; border-bottom: 2px solid var(--gris-claro); }
    .header-icon { font-size: 2.2rem; color: var(--verde); background: rgba(88,204,2,0.1); padding: 16px; border-radius: 16px; }
    .module-header h1 { font-size: 1.8rem; font-weight: 900; margin: 0 0 5px 0; color: var(--gris-texto); }
    .module-header p { margin: 0; color: var(--texto-tenue); font-size: 0.9rem; }
    
    .vocab-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
    .vocab-card { border: 2px solid var(--gris-claro); border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 15px; background: var(--blanco); transition: transform 0.2s, border-color 0.2s; position: relative; }
    .vocab-card:hover { transform: translateY(-2px); border-color: var(--azul); }
    .btn-play-audio { width: 44px; height: 44px; border-radius: 50%; background: var(--azul); color: white; border: none; box-shadow: 0 3px 0 var(--azul-oscuro); cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .btn-play-audio:active { transform: translateY(3px); box-shadow: none; }
    .vocab-details { flex: 1; }
    .vocab-english { font-size: 1.15rem; font-weight: 800; margin: 0 0 4px 0; color: var(--gris-texto); }
    .vocab-spanish { font-size: 0.9rem; margin: 0; color: var(--verde-oscuro); font-weight: 700; }
    
    .vocab-card-star { position: absolute; top: 12px; right: 12px; background: none; border: none; font-size: 1.15rem; cursor: pointer; }
    .vocab-card-star.active { color: #ffd700; }
    .vocab-card-star.inactive { color: var(--gris-medio); }
  </style>
</head>
<body>

<div class="contenedor-app">
  <?php include dirname(__DIR__) . '/layouts/aprendiz_sidebar.php'; ?>

  <main class="contenido-principal">
    <div class="module-view">
        <div class="module-header">
            <i class="fas fa-spell-check header-icon"></i>
            <div>
                <h1>Vocabulario Clínico</h1>
                <p>Repasa los términos técnicos y marca palabras difíciles para reforzarlas.</p>
            </div>
        </div>

        <?php if (empty($vocabulario)): ?>
          <div style="padding: 50px; text-align: center; color: var(--texto-tenue);">
            <i class="fas fa-book-open" style="font-size: 40px; margin-bottom: 12px; color: var(--gris-claro);"></i>
            <h3>No hay términos clínicos guardados aún</h3>
            <p style="font-size: 0.85rem; margin-top: 4px;">Completa lecciones del mapa para poblar tu vocabulario.</p>
          </div>
        <?php else: ?>
          <div class="vocab-list" id="vocab-container">
              <?php foreach ($vocabulario as $v): ?>
                <div class="vocab-card" id="card-<?= $v['id'] ?>">
                    <button class="btn-play-audio" onclick="speakTerm('<?= addslashes($v['termino_en']) ?>')"><i class="fas fa-volume-up"></i></button>
                    <div class="vocab-details">
                      <h3 class="vocab-english"><?= htmlspecialchars($v['termino_en']) ?></h3>
                      <p class="vocab-spanish"><?= htmlspecialchars($v['termino_es']) ?></p>
                      <small style="color: var(--texto-tenue); font-size: 0.72rem; display: block; margin-top: 4px;">
                        <?= htmlspecialchars($v['nivel_nombre']) ?> • <?= htmlspecialchars($v['categoria_nombre'] ?? 'Sustantivo') ?>
                      </small>
                    </div>
                    <button class="vocab-card-star <?= $v['es_dificil'] ? 'active' : 'inactive' ?>" onclick="toggleVocabStar('<?= $v['id'] ?>', this)">
                      <i class="<?= $v['es_dificil'] ? 'fas' : 'far' ?> fa-star"></i>
                    </button>
                </div>
              <?php endforeach; ?>
          </div>
        <?php endif; ?>
    </div>
  </main>
</div>

<script>
  function speakTerm(text) {
    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel();
      let utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'en-US';
      utterance.rate = 0.9;
      
      let voices = window.speechSynthesis.getVoices();
      let enVoice = voices.find(v => v.lang.startsWith('en'));
      if (enVoice) utterance.voice = enVoice;
      
      window.speechSynthesis.speak(utterance);
    }
  }

  function toggleVocabStar(vocabId, node) {
    let formData = new FormData();
    formData.append('vocabulario_id', vocabId);

    fetch('<?= PROYECTO_PATH ?>/aprendiz/rap/marcar-vocabulario', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(d => {
      if (d.exito) {
        if (d.marcado) {
          node.className = 'vocab-card-star active';
          node.innerHTML = '<i class="fas fa-star"></i>';
        } else {
          node.className = 'vocab-card-star inactive';
          node.innerHTML = '<i class="far fa-star"></i>';
        }
      }
    });
  }
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
