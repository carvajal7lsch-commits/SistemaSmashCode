<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diálogos Clínicos — SmashCode</title>
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

    .dialogue-card {
      background: var(--blanco); border: 2px solid var(--gris-claro); border-radius: 20px; padding: 24px; margin-bottom: 24px;
    }
    
    .dialogue-chat {
      display: flex; flex-direction: column; gap: 16px; background: var(--fondo); border: 2px solid var(--gris-claro); border-radius: 16px; padding: 20px; margin-top: 16px; max-height: 350px; overflow-y: auto;
    }
    .chat-bubble {
      max-width: 70%; padding: 12px 16px; border-radius: 18px; line-height: 1.4; position: relative; border: 2px solid var(--gris-claro); transition: all 0.2s;
    }
    .chat-bubble.left {
      align-self: flex-start; background: var(--blanco); border-bottom-left-radius: 4px;
    }
    .chat-bubble.right {
      align-self: flex-end; background: rgba(88,204,2,0.1); border-bottom-right-radius: 4px; border-color: rgba(88,204,2,0.3);
    }
    .chat-bubble.active-highlight {
      border-color: var(--azul);
      box-shadow: 0 0 10px rgba(28,176,246,0.3);
      transform: scale(1.02);
    }
    .chat-sender { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--gris-medio); margin-bottom: 4px; }
    .chat-text-en { font-size: 0.95rem; font-weight: 700; color: var(--gris-texto); }
    .chat-text-es { font-size: 0.8rem; color: var(--texto-tenue); margin-top: 4px; }
    .chat-bubble-play {
      position: absolute; right: -40px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 1.1rem; color: var(--azul); cursor: pointer;
    }
  </style>
</head>
<body>
<div class="contenedor-app">
  <?php include dirname(__DIR__) . '/layouts/aprendiz_sidebar.php'; ?>

  <main class="contenido-principal">
    <div class="module-view">
        <div class="module-header">
            <i class="fas fa-comments header-icon"></i>
            <div>
                <h1>Diálogos Clínicos</h1>
                <p>Escucha y practica conversaciones del entorno médico real con voces nativas.</p>
            </div>
        </div>

        <?php if (empty($dialogos)): ?>
          <div style="padding: 50px; text-align: center; color: var(--texto-tenue);">
            <i class="fas fa-comments" style="font-size: 40px; margin-bottom: 12px; color: var(--gris-claro);"></i>
            <h3>No hay diálogos disponibles aún</h3>
            <p style="font-size: 0.85rem; margin-top: 4px;">Completa lecciones para habilitar prácticas de conversación.</p>
          </div>
        <?php else: ?>
          <?php foreach ($dialogos as $d): ?>
            <div class="dialogue-card">
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                  <h3 style="font-weight:900; font-size:1.2rem; color:var(--gris-texto);"><i class="fas fa-notes-medical" style="color:var(--azul); margin-right:8px;"></i><?= htmlspecialchars($d['titulo']) ?></h3>
                  <small style="color:var(--texto-tenue); font-weight:700; display:block; margin-top:4px;"><?= htmlspecialchars($d['nivel_nombre']) ?> • <?= htmlspecialchars($d['participantes']) ?></small>
                </div>
                <button class="btn-azul" style="padding:8px 16px;" onclick="playFullDialogue('dialogue-<?= $d['id'] ?>')">
                  <i class="fas fa-play" style="margin-right:6px;"></i> Reproducir Diálogo
                </button>
              </div>
              
              <div class="dialogue-chat" id="dialogue-<?= $d['id'] ?>">
                <?php foreach ($d['turnos'] as $t): ?>
                  <?php 
                    $isNurse = strpos(strtolower($t['hablante']), 'nurse') !== false || strpos(strtolower($t['hablante']), 'enfermer') !== false;
                  ?>
                  <div class="chat-bubble <?= $isNurse ? 'right' : 'left' ?>" 
                       id="turno-<?= $t['id'] ?>" 
                       data-text-en="<?= htmlspecialchars($t['texto_en']) ?>"
                       data-speaker="<?= $isNurse ? 'female' : 'male' ?>">
                    <div class="chat-sender"><?= htmlspecialchars($t['hablante']) ?></div>
                    <div class="chat-text-en"><?= htmlspecialchars($t['texto_en']) ?></div>
                    <div class="chat-text-es"><?= htmlspecialchars($t['texto_es']) ?></div>
                    <button class="chat-bubble-play" onclick="speakSingleTurn('turno-<?= $t['id'] ?>')">
                      <i class="fas fa-volume-up"></i>
                    </button>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </main>
</div>

<script>
  let dialogTimeoutList = [];

  function speakText(text, gender = 'female') {
    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel();
      let utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'en-US';
      utterance.rate = 0.9;
      
      let voices = window.speechSynthesis.getVoices();
      let enVoices = voices.filter(v => v.lang.startsWith('en'));
      
      if (enVoices.length > 0) {
        if (gender === 'female') {
          let fVoice = enVoices.find(v => v.name.toLowerCase().includes('zira') || v.name.toLowerCase().includes('female') || v.name.toLowerCase().includes('google'));
          utterance.voice = fVoice || enVoices[0];
        } else {
          let mVoice = enVoices.find(v => v.name.toLowerCase().includes('david') || v.name.toLowerCase().includes('male') || v.name.toLowerCase().includes('microsoft'));
          utterance.voice = mVoice || enVoices[0];
        }
      }
      window.speechSynthesis.speak(utterance);
      return utterance;
    }
  }

  function playFullDialogue(diaElementId) {
    window.speechSynthesis.cancel();
    dialogTimeoutList.forEach(t => clearTimeout(t));
    dialogTimeoutList = [];
    
    let container = document.getElementById(diaElementId);
    let bubbles = Array.from(container.querySelectorAll('.chat-bubble'));
    
    bubbles.forEach(b => b.classList.remove('active-highlight'));

    function playTurn(idx) {
      if (idx >= bubbles.length) return;
      let bubble = bubbles[idx];
      let text = bubble.getAttribute('data-text-en');
      let speaker = bubble.getAttribute('data-speaker') || 'female';

      bubble.classList.add('active-highlight');
      bubble.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

      let utterance = speakText(text, speaker);
      
      utterance.onend = () => {
        bubble.classList.remove('active-highlight');
        let timeout = setTimeout(() => {
          playTurn(idx + 1);
        }, 500);
        dialogTimeoutList.push(timeout);
      };
    }
    
    playTurn(0);
  }

  function speakSingleTurn(turnId) {
    window.speechSynthesis.cancel();
    dialogTimeoutList.forEach(t => clearTimeout(t));
    dialogTimeoutList = [];

    document.querySelectorAll('.chat-bubble').forEach(b => b.classList.remove('active-highlight'));

    let bubble = document.getElementById(turnId);
    let text = bubble.getAttribute('data-text-en');
    let speaker = bubble.getAttribute('data-speaker') || 'female';

    bubble.classList.add('active-highlight');
    let utterance = speakText(text, speaker);
    utterance.onend = () => {
      bubble.classList.remove('active-highlight');
    };
  }
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
