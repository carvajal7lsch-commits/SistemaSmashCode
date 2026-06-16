<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicios Clínicos — SmashCode</title>
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

    .ejercicio-card {
      background: var(--blanco); border: 2px solid var(--gris-claro); border-radius: 20px; padding: 24px; margin-bottom: 24px;
    }
    
    .ejercicio-titulo { font-size: 1.15rem; font-weight: 800; color: var(--gris-texto); margin-bottom: 16px; }
    .ejercicio-tipo {
      display: inline-block; padding: 4px 10px; border-radius: 99px; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; background: rgba(28,176,246,0.1); color: var(--azul-oscuro); margin-bottom: 12px;
    }

    .opciones-list { display: flex; flex-direction: column; gap: 10px; }
    .opcion-item {
      padding: 14px 18px; border: 2px solid var(--gris-claro); border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.15s; background: var(--blanco); display: flex; align-items: center; justify-content: space-between;
    }
    .opcion-item:hover { border-color: var(--azul); }
    .opcion-item.correct { border-color: var(--verde); background: rgba(88,204,2,0.05); }
    .opcion-item.incorrect { border-color: var(--rojo); background: rgba(255,75,75,0.05); }
    
    .retro-box {
      margin-top: 12px; padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; display: none;
    }
    .retro-box.correct { background: rgba(88,204,2,0.1); color: var(--verde-oscuro); }
    .retro-box.incorrect { background: rgba(255,75,75,0.1); color: var(--rojo); }
  </style>
</head>
<body>
<div class="contenedor-app">
  <?php include dirname(__DIR__) . '/layouts/aprendiz_sidebar.php'; ?>

  <main class="contenido-principal">
    <div class="module-view">
        <div class="module-header">
            <i class="fas fa-dumbbell header-icon"></i>
            <div>
                <h1>Banco de Ejercicios Clínicos</h1>
                <p>Practica las estructuras y conceptos clínicos con ejercicios de auto-evaluación interactivos.</p>
            </div>
        </div>

        <?php if (empty($ejercicios)): ?>
          <div style="padding: 50px; text-align: center; color: var(--texto-tenue);">
            <i class="fas fa-dumbbell" style="font-size: 40px; margin-bottom: 12px; color: var(--gris-claro);"></i>
            <h3>No hay ejercicios cargados aún</h3>
            <p style="font-size: 0.85rem; margin-top: 4px;">Completa el mapa formativo para desbloquear desafíos.</p>
          </div>
        <?php else: ?>
          <?php foreach ($ejercicios as $idx => $ej): ?>
            <div class="ejercicio-card" id="ejercicio-card-<?= $ej['id'] ?>">
              <span class="ejercicio-tipo"><?= str_replace('_', ' ', htmlspecialchars($ej['tipo'])) ?></span>
              <small style="color:var(--texto-tenue); font-weight:700; margin-left:12px;"><?= htmlspecialchars($ej['nivel_nombre']) ?></small>
              <div class="ejercicio-titulo"><?= htmlspecialchars($ej['enunciado']) ?></div>
              
              <div class="opciones-list">
                <?php foreach ($ej['opciones'] as $opc): ?>
                  <div class="opcion-item" onclick="checkPracticeOption('<?= $ej['id'] ?>', '<?= $opc['id'] ?>', <?= $opc['es_correcta'] ? 'true' : 'false' ?>, this)">
                    <span><?= htmlspecialchars($opc['texto']) ?></span>
                    <span class="retro-text" style="display:none;"><?= htmlspecialchars($opc['retroalimentacion']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>

              <div class="retro-box" id="retro-box-<?= $ej['id'] ?>">
                <i class="fas fa-info-circle" style="margin-right:8px;"></i>
                <span class="retro-content">Retroalimentación del ejercicio.</span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </main>
</div>

<script>
  function checkPracticeOption(ejId, opcId, esCorrecta, node) {
    let card = document.getElementById('ejercicio-card-' + ejId);
    let options = card.querySelectorAll('.opcion-item');
    let retroBox = document.getElementById('retro-box-' + ejId);

    // Desactivar clicks adicionales
    options.forEach(n => {
      n.style.pointerEvents = 'none';
      n.classList.remove('correct', 'incorrect');
    });

    let retroMsg = node.querySelector('.retro-text').textContent;

    if (esCorrecta) {
      node.classList.add('correct');
      retroBox.className = 'retro-box correct';
      retroBox.querySelector('.retro-content').textContent = retroMsg || '¡Respuesta correcta! Excelente.';
    } else {
      node.classList.add('incorrect');
      retroBox.className = 'retro-box incorrect';
      retroBox.querySelector('.retro-content').textContent = retroMsg || 'Respuesta incorrecta. Sigue practicando.';

      // Resaltar la correcta en verde
      options.forEach(n => {
        let isOptionCorrect = n.getAttribute('onclick').includes('true');
        if (isOptionCorrect) {
          n.classList.add('correct');
        }
      });
    }

    retroBox.style.display = 'block';
  }
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
