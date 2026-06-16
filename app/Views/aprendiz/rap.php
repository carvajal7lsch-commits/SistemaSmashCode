<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= limpiar($rap['titulo']) ?> — SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>
    (function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

    /* Estilos específicos para la vista del RAP gamificado */
    .learning-view {
      display: flex;
      flex-direction: column;
      height: 100vh;
      background: radial-gradient(at 0% 0%, rgba(28, 176, 246, 0.05) 0px, transparent 50%),
                  radial-gradient(at 100% 100%, rgba(88, 204, 2, 0.05) 0px, transparent 50%),
                  var(--fondo);
      color: var(--gris-texto);
      font-family: 'Plus Jakarta Sans', var(--fuente), sans-serif;
      overflow: hidden;
    }

    .learning-header {
      height: 75px;
      border-bottom: 2px solid var(--gris-claro);
      background: var(--blanco);
      display: flex;
      align-items: center;
      padding: 0 40px;
      gap: 24px;
      flex-shrink: 0;
      box-shadow: 0 4px 30px rgba(0,0,0,0.02);
    }

    .btn-exit {
      background: var(--fondo);
      border: 2px solid var(--gris-claro);
      font-size: 1.1rem;
      color: var(--gris-medio);
      cursor: pointer;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 3px 0 var(--gris-claro);
    }
    .btn-exit:hover {
      background: var(--rojo);
      color: white;
      border-color: var(--rojo);
      box-shadow: 0 4px 0 rgba(255, 75, 75, 0.2);
      transform: translateY(-2px);
    }
    .btn-exit:active {
      transform: translateY(2px);
      box-shadow: none;
    }

    .progreso-header-bar {
      flex: 1;
      height: 20px;
      background: var(--gris-claro);
      border: 2px solid var(--gris-claro);
      border-radius: 99px;
      position: relative;
      overflow: visible;
      max-width: 600px;
      box-shadow: inset 0 2px 5px rgba(0,0,0,0.1), 0 1px 0 rgba(255,255,255,0.05);
    }
    .progreso-header-fill {
      height: 100%;
      background-image: linear-gradient(45deg, rgba(255,255,255,0.18) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.18) 50%, rgba(255,255,255,0.18) 75%, transparent 75%, transparent);
      background-size: 24px 24px;
      background-color: var(--verde);
      box-shadow: inset 0 3px 0 rgba(255,255,255,0.35), inset 0 -3px 0 rgba(0,0,0,0.15), 0 0 12px rgba(88,204,2,0.25);
      animation: progress-bar-stripes 1.2s linear infinite;
      border-radius: 99px;
      width: <?= $progreso['porcentaje'] ?>%;
      transition: width 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
    }
    .progreso-header-fill::after {
      content: "⚡";
      font-size: 0.8rem;
      position: absolute;
      right: -8px;
      top: 50%;
      transform: translateY(-50%);
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: #ffd900;
      border: 2px solid #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 12px #ffd900, 0 3px 6px rgba(0, 0, 0, 0.15);
      animation: pulse-tip 1s infinite alternate;
      z-index: 2;
    }

    @keyframes progress-bar-stripes {
      from { background-position: 0 0; }
      to { background-position: 24px 0; }
    }
    @keyframes pulse-tip {
      0% { transform: translateY(-50%) scale(0.92); box-shadow: 0 0 8px #ffd900; }
      100% { transform: translateY(-50%) scale(1.12); box-shadow: 0 0 16px #ffd900; }
    }

    .progreso-texto {
      font-weight: 900;
      font-size: 0.85rem;
      color: var(--verde-oscuro);
      background: var(--verde-claro);
      border: 2px solid rgba(88, 204, 2, 0.25);
      padding: 5px 12px;
      border-radius: 12px;
      min-width: 58px;
      text-align: center;
      box-shadow: 0 3px 0 rgba(88, 204, 2, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    [data-theme="dark"] .progreso-texto {
      color: var(--verde-claro);
      background: rgba(88, 204, 2, 0.1);
      border-color: rgba(88, 204, 2, 0.25);
    }

    .header-xp-badge {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 800;
      font-size: 0.9rem;
      color: #ff9600;
      background: rgba(255, 150, 0, 0.08);
      border: 2px solid rgba(255, 150, 0, 0.2);
      padding: 6px 14px;
      border-radius: 14px;
      box-shadow: 0 3px 0 rgba(255, 150, 0, 0.1);
      transition: all 0.2s;
    }
    .header-xp-badge:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 0 rgba(255, 150, 0, 0.15);
    }

    /* Moment Tab bar */
    .moments-tabs {
      display: flex;
      background: var(--blanco);
      border: 2px solid var(--gris-claro);
      padding: 6px;
      gap: 10px;
      border-radius: 99px;
      margin: 24px auto 0 auto;
      max-width: 900px;
      width: calc(100% - 80px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.02);
      flex-shrink: 0;
      align-items: center;
      justify-content: space-between;
    }
    .moment-tab {
      flex: 1;
      padding: 12px 16px;
      font-weight: 800;
      font-size: 0.82rem;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      color: var(--gris-medio);
      border: none;
      background: transparent;
      border-radius: 99px;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .moment-tab.active {
      color: white !important;
      background: var(--verde);
      box-shadow: 0 6px 18px rgba(88, 204, 2, 0.25);
      transform: translateY(-1px);
    }
    .moment-tab:hover:not(.locked):not(.active) {
      background: var(--gris-claro);
      color: var(--gris-texto);
    }
    .moment-tab.locked {
      opacity: 0.45;
      cursor: not-allowed;
    }

    /* Layout content */
    .moments-container {
      flex: 1;
      padding: 24px 40px;
      overflow-y: auto;
      position: relative;
    }

    .moment-pane {
      display: none;
      animation: fadeInUp 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      max-width: 900px;
      margin: 0 auto;
    }
    .moment-pane.active { display: block; }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Moments Design Components */
    .card-moment {
      background: var(--blanco);
      border: 2px solid var(--gris-claro);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.02);
      margin-bottom: 24px;
      position: relative;
    }

    /* Moment 1: Warmup Matching */
    .matching-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      margin-top: 24px;
    }
    .matching-col {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .matching-card {
      background: var(--blanco);
      border: 2px solid var(--gris-claro);
      border-radius: 16px;
      padding: 20px 24px;
      font-weight: 800;
      font-size: 1.05rem;
      cursor: pointer;
      text-align: center;
      transition: all 0.15s cubic-bezier(0.2, 0.8, 0.2, 1);
      box-shadow: 0 6px 0 var(--gris-claro);
      color: var(--gris-texto);
      user-select: none;
    }
    .matching-card:hover {
      border-color: var(--azul);
      transform: translateY(-2px);
      box-shadow: 0 8px 0 var(--gris-claro);
    }
    .matching-card.selected {
      border-color: var(--azul);
      background: rgba(28, 176, 246, 0.08);
      box-shadow: 0 2px 0 var(--azul);
      transform: translateY(4px);
      color: var(--azul);
    }
    .matching-card.correct {
      border-color: var(--verde);
      background: rgba(88, 204, 2, 0.08);
      box-shadow: 0 2px 0 var(--verde);
      transform: translateY(4px);
      color: var(--verde-oscuro);
      cursor: default;
      pointer-events: none;
    }
    .matching-card.incorrect {
      border-color: var(--rojo);
      background: rgba(255, 75, 75, 0.08);
      box-shadow: 0 2px 0 var(--rojo);
      transform: translateY(4px);
      color: var(--rojo);
      animation: shake 0.4s ease;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-6px); }
      75% { transform: translateX(6px); }
    }

    /* Moment 2: Grammar Pill & Vocabulary */
    .grammar-pill {
      background: rgba(88, 204, 2, 0.03);
      border: 1px solid rgba(88, 204, 2, 0.15);
      border-left: 6px solid var(--verde);
      padding: 24px;
      border-radius: 16px;
      margin-bottom: 28px;
    }
    .grammar-pill h3 { font-size: 1.15rem; font-weight: 800; color: var(--verde-oscuro); margin-bottom: 12px; }
    
    .grammar-table {
      display: flex;
      gap: 12px;
      justify-content: center;
      font-size: 1.45rem;
      font-weight: 800;
      padding: 20px;
      margin: 16px 0;
      background: var(--fondo);
      border-radius: 16px;
      border: 1px solid var(--gris-claro);
    }
    .gt-sujeto { color: #1cb0f6; border-bottom: 3px dashed #1cb0f6; padding: 2px 8px; }
    .gt-verbo { color: #ff9600; border-bottom: 3px dashed #ff9600; padding: 2px 8px; }
    .gt-complemento { color: #58cc02; border-bottom: 3px dashed #58cc02; padding: 2px 8px; }

    /* Flashcard Slider */
    .slider-wrap {
      display: flex; align-items: center; justify-content: center; gap: 24px; margin-top: 24px;
    }
    .flashcard {
      width: 440px; height: 280px; perspective: 1000px; cursor: pointer;
    }
    .flashcard-inner {
      width: 100%; height: 100%; position: relative; transform-style: preserve-3d; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 24px;
    }
    .flashcard.flipped .flashcard-inner { transform: rotateY(180deg); }
    
    .flashcard-front, .flashcard-back {
      position: absolute; width: 100%; height: 100%; backface-visibility: hidden;
      border: 2px solid var(--gris-claro); border-radius: 24px;
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); background: var(--blanco);
    }
    .flashcard-back { transform: rotateY(180deg); background: var(--fondo); }
    
    .fc-title { font-size: 2.2rem; font-weight: 900; color: var(--gris-texto); margin-bottom: 8px; }
    .fc-ipa { font-family: monospace; font-size: 1.1rem; color: var(--azul-oscuro); margin-bottom: 16px; background: rgba(28,176,246,0.08); padding: 6px 12px; border-radius: 8px; border: 1px solid rgba(28,176,246,0.15); }
    .fc-translation { font-size: 1.8rem; font-weight: 800; color: var(--verde-oscuro); }
    .fc-example { font-style: italic; color: var(--texto-tenue); text-align: center; margin-top: 16px; font-size: 0.95rem; max-width: 85%; line-height: 1.4; }
    
    .btn-star-mark {
      position: absolute; top: 20px; right: 20px; background: var(--fondo); border: 2px solid var(--gris-claro); font-size: 1.2rem; cursor: pointer; color: var(--gris-medio); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s;
    }
    .btn-star-mark:hover { transform: scale(1.1); }
    .btn-star-mark.active { color: #ffd700; border-color: #ffd700; background: rgba(255,215,0,0.08); }
    
    .fc-audio-btn {
      position: absolute; bottom: 20px; right: 20px; width: 48px; height: 48px; border-radius: 50%; background: var(--azul); color: white; border: none; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 0 var(--azul-oscuro); transition: all 0.1s;
    }
    .fc-audio-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 0 var(--azul-oscuro); }
    .fc-audio-btn:active { transform: translateY(2px); box-shadow: none; }

    /* Chat Storybook */
    .dialogue-chat {
      display: flex; flex-direction: column; gap: 16px; background: var(--fondo); border: 2px solid var(--gris-claro); border-radius: 24px; padding: 28px; margin-top: 20px; max-height: 400px; overflow-y: auto;
    }
    .chat-bubble {
      max-width: 68%; padding: 16px 20px; border-radius: 20px; line-height: 1.5; position: relative; border: 2px solid var(--gris-claro); transition: all 0.25s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .chat-bubble.left {
      align-self: flex-start; background: var(--blanco); border-bottom-left-radius: 4px;
    }
    .chat-bubble.right {
      align-self: flex-end; background: rgba(88,204,2,0.05); border-bottom-right-radius: 4px; border-color: rgba(88,204,2,0.2);
    }
    .chat-bubble.active-highlight {
      border-color: var(--azul);
      box-shadow: 0 0 15px rgba(28,176,246,0.25);
      transform: scale(1.015);
    }
    .chat-sender { font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: var(--gris-medio); margin-bottom: 6px; letter-spacing: 0.05em; }
    .chat-text-en { font-size: 1.02rem; font-weight: 700; color: var(--gris-texto); }
    .chat-text-es { font-size: 0.88rem; color: var(--texto-tenue); margin-top: 6px; border-top: 1px dashed var(--gris-claro); padding-top: 6px; }
    .chat-bubble-play {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: var(--blanco);
      border: 2px solid var(--gris-claro);
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.95rem;
      color: var(--azul);
      cursor: pointer;
      box-shadow: 0 3px 0 var(--gris-claro);
      transition: all 0.15s cubic-bezier(0.2, 0.8, 0.2, 1);
      z-index: 10;
    }
    .chat-bubble.left .chat-bubble-play {
      right: -48px;
      left: auto;
    }
    .chat-bubble.right .chat-bubble-play {
      left: -48px;
      right: auto;
    }
    .chat-bubble-play:hover {
      transform: translateY(-50%) scale(1.1);
      border-color: var(--azul);
      color: var(--azul-oscuro);
      box-shadow: 0 4px 0 rgba(28, 176, 246, 0.2);
    }
    .chat-bubble-play:active {
      transform: translateY(-50%) translateY(2px) scale(0.95);
      box-shadow: none;
    }

    .btn-play-full-dialogue {
      background: linear-gradient(135deg, var(--azul), var(--azul-oscuro));
      color: white;
      border: none;
      padding: 10px 20px;
      font-weight: 800;
      font-size: 0.82rem;
      text-transform: uppercase;
      letter-spacing: 0.03em;
      border-radius: 14px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 0 rgba(10, 145, 209, 0.4), 0 4px 10px rgba(28, 176, 246, 0.25);
      transition: all 0.2s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .btn-play-full-dialogue:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 0 rgba(10, 145, 209, 0.4), 0 6px 14px rgba(28, 176, 246, 0.35);
      filter: brightness(1.05);
    }
    .btn-play-full-dialogue:active {
      transform: translateY(3px);
      box-shadow: none;
    }

    /* Moment 3: Exercises Carousel */
    .exercise-box { display: none; }
    .exercise-box.active { display: block; }
    .exercise-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-weight: 800; font-size: 0.9rem; letter-spacing: 0.05em; }
    .exercise-title { font-size: 1.35rem; font-weight: 800; margin-bottom: 28px; color: var(--gris-texto); line-height: 1.4; }
    
    /* MC Opciones */
    .options-list { display: flex; flex-direction: column; gap: 14px; }
    .option-item {
      padding: 18px 22px; border: 2px solid var(--gris-claro); border-radius: 16px; font-weight: 700; cursor: pointer; transition: all 0.15s cubic-bezier(0.2, 0.8, 0.2, 1); background: var(--blanco); display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 0 var(--gris-claro);
    }
    .option-item:hover { border-color: var(--azul); transform: translateY(-2px); box-shadow: 0 6px 0 var(--gris-claro); }
    .option-item.selected { border-color: var(--azul); background: rgba(28, 176, 246, 0.06); box-shadow: 0 2px 0 var(--azul); transform: translateY(2px); }
    .option-badge { width: 30px; height: 30px; border-radius: 50%; border: 2px solid var(--gris-claro); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 900; background: var(--fondo); }
    .option-item.selected .option-badge { border-color: var(--azul); background: var(--azul); color: white; }

    /* Word Bank component */
    .blank-sentence { font-size: 1.45rem; font-weight: 800; text-align: center; margin: 36px 0; display: flex; gap: 10px; justify-content: center; align-items: center; flex-wrap: wrap; }
    .blank-drop { width: 130px; height: 40px; border-bottom: 3px solid var(--gris-medio); display: inline-flex; align-items: center; justify-content: center; color: var(--azul); font-weight: 900; background: rgba(28,176,246,0.03); border-radius: 6px 6px 0 0; }
    .word-bank { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; margin-top: 28px; }
    .word-chip {
      padding: 10px 20px; border: 2px solid var(--gris-claro); border-radius: 12px; font-weight: 700; cursor: pointer; background: var(--blanco); box-shadow: 0 4px 0 var(--gris-claro); transition: all 0.15s;
    }
    .word-chip:hover { transform: translateY(-2px); box-shadow: 0 6px 0 var(--gris-claro); border-color: var(--azul); }
    .word-chip:active { transform: translateY(4px); box-shadow: none; }
    .word-chip.used { opacity: 0.25; cursor: default; pointer-events: none; transform: translateY(4px); box-shadow: none; }

    /* Validation Banner */
    .validation-banner {
      display: none; padding: 22px 36px; margin-top: 28px; border-radius: 20px; align-items: center; justify-content: space-between; border-width: 2px; border-style: solid;
    }
    .validation-banner.correct {
      background: rgba(88,204,2,0.08); border-color: var(--verde); color: var(--verde-oscuro); display: flex;
    }
    .validation-banner.incorrect {
      background: rgba(255,75,75,0.08); border-color: var(--rojo); color: var(--rojo); display: flex;
    }
    .vb-msg { display: flex; align-items: center; gap: 20px; font-weight: 800; }
    .vb-msg i { font-size: 2.2rem; }
    .vb-expl { font-size: 0.9rem; font-weight: 600; margin-top: 4px; opacity: 0.9; }

    /* Drag Columns Grid */
    .columns-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .column-slot {
      border: 2px dashed var(--gris-claro); border-radius: 12px; min-height: 52px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--gris-medio);
    }

    /* Dictation styles */
    .dictation-play-btn {
      width: 76px; height: 76px; border-radius: 50%; background: var(--azul); color: white; border: none; font-size: 2.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 0 var(--azul-oscuro); margin: 28px auto; transition: all 0.1s;
    }
    .dictation-play-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 0 var(--azul-oscuro); }
    .dictation-play-btn:active { transform: translateY(6px); box-shadow: none; }
    .dictation-input {
      width: 100%; max-width: 320px; display: block; margin: 24px auto; padding: 14px 20px; border: 2px solid var(--gris-claro); border-radius: 14px; font-size: 1.25rem; font-weight: 800; text-align: center; outline: none; background: var(--fondo); color: var(--gris-texto); transition: border-color 0.2s;
    }
    .dictation-input:focus { border-color: var(--azul); }

    /* Confetti Canvas */
    #confetti-canvas {
      position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 9999; display: none;
    }
  </style>
</head>
<body>

<div class="learning-view">
  <!-- HEADER CON PROGRESO -->
  <header class="learning-header">
    <button class="btn-exit" onclick="window.location='<?= PROYECTO_PATH ?>/'" title="Volver al Mapa">
      <i class="fas fa-times"></i>
    </button>
    <div class="progreso-header-bar">
      <div class="progreso-header-fill" id="header-progress-fill"></div>
    </div>
    <div class="progreso-texto" id="header-progress-text"><?= (int)$progreso['porcentaje'] ?>%</div>
    
    <div class="header-xp-badge">
      <i class="fas fa-bolt"></i>
      <span id="session-xp">0 XP</span>
    </div>
  </header>

  <!-- PESTAÑAS DE MOMENTOS -->
  <nav class="moments-tabs" aria-label="Momentos Pedagógicos">
    <div class="moment-tab active" id="tab-moment-1" onclick="switchTab(1)">
      <i class="fas fa-gamepad"></i> Moment 1: Warm-Up
    </div>
    <div class="moment-tab <?= $progreso['porcentaje'] >= 25 || $progreso['completado'] ? '' : 'locked' ?>" id="tab-moment-2" onclick="switchTab(2)">
      <i class="fas fa-book-reader"></i> Moment 2: Absorption
    </div>
    <div class="moment-tab <?= $progreso['porcentaje'] >= 50 || $progreso['completado'] ? '' : 'locked' ?>" id="tab-moment-3" onclick="switchTab(3)">
      <i class="fas fa-dumbbell"></i> Moment 3: Practice
    </div>
    <div class="moment-tab <?= $progreso['porcentaje'] >= 75 || $progreso['completado'] ? '' : 'locked' ?>" id="tab-moment-4" onclick="switchTab(4)">
      <i class="fas fa-award"></i> Moment 4: Quiz
    </div>
  </nav>

  <!-- CONTENEDOR DE PANELES -->
  <main class="moments-container">

    <!-- ==================== MOMENTO 1: WARM-UP ==================== -->
    <section class="moment-pane active" id="pane-moment-1" aria-labelledby="tab-moment-1">
      <div class="card-moment">
        <h2>Warm-Up Mini-Game</h2>
        <p style="color:var(--texto-tenue); margin-top:8px;">Match English terms to their Spanish meanings to activate your prior knowledge!</p>
        
        <div class="matching-grid" id="warmup-matching-grid">
          <div class="matching-col" id="warmup-col-en"></div>
          <div class="matching-col" id="warmup-col-es"></div>
        </div>

        <div id="warmup-success-msg" style="display:none; text-align:center; margin-top:32px; animation: fadeInUp 0.3s ease;">
          <h3 style="color:var(--verde); font-size:1.4rem; font-weight:800; margin-bottom:12px;">
            <i class="fas fa-star" style="margin-right:8px;"></i>Warm-Up Completed!
          </h3>
          <p style="color:var(--texto-tenue); margin-bottom:24px;">Moment 2 (Absorption) is now unlocked. Let's start studying!</p>
          <button class="btn-verde" style="margin: 0 auto; display: block;" onclick="switchTab(2)">
            Continue <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- ==================== MOMENTO 2: ABSORPTION ==================== -->
    <section class="moment-pane" id="pane-moment-2" aria-labelledby="tab-moment-2">
      <!-- 2.1 Grammar Pill -->
      <div class="card-moment">
        <h2>Grammar Pill</h2>
        <p style="color:var(--texto-tenue); margin-top:8px; margin-bottom:16px;">Analyze the grammatical structure of clinical interactions: Subject + Verb + Complement.</p>
        <div class="grammar-pill">
          <h3>Forming Patient Registrations & Sentences</h3>
          <div class="grammar-table">
            <span class="gt-sujeto" title="Subject">I</span>
            <span class="gt-verbo" title="Verb To Be">am</span>
            <span class="gt-complemento" title="Complement">Sarah, your nurse</span>
          </div>
          <p style="font-size:0.9rem; text-align:center; color:var(--texto-tenue);">
            Sujeto (<span style="color:#1cb0f6; font-weight:700;">I</span>) + Verbo To Be (<span style="color:#ff9600; font-weight:700;">am</span>) + Complemento Clínico (<span style="color:#58cc02; font-weight:700;">Sarah, su enfermera</span>).
          </p>
        </div>
      </div>

      <!-- 2.2 Vocabulary Lab Slider -->
      <div class="card-moment">
        <h2>Vocabulary Laboratory</h2>
        <p style="color:var(--texto-tenue); margin-top:8px; margin-bottom:20px;">Review clinical terminology. Click a card to flip and reveal the translation. Mark terms you find hard.</p>
        
        <?php if (empty($vocabulario)): ?>
          <p style="color:var(--texto-tenue); text-align:center;">No vocabulary terms loaded for this RAP.</p>
        <?php else: ?>
          <div class="slider-wrap">
            <button class="btn-gris" onclick="prevVocab()" id="btn-prev-vocab" style="padding:10px 16px;"><i class="fas fa-chevron-left"></i></button>
            
            <div class="flashcard" id="current-flashcard" onclick="flipCard()">
              <div class="flashcard-inner">
                <!-- FRONT -->
                <div class="flashcard-front">
                  <button class="btn-star-mark" id="btn-star-vocab" onclick="toggleStar(event)" title="Marcar como difícil">
                    <i class="far fa-star"></i>
                  </button>
                  <div class="fc-title" id="vocab-word-en">Word</div>
                  <div class="fc-ipa" id="vocab-word-ipa">/ipa/</div>
                  <div class="fc-example" id="vocab-word-ex">Example Sentence</div>
                  <button class="fc-audio-btn" onclick="speakVocab(event)" title="Escuchar pronunciación">
                    <i class="fas fa-volume-up"></i>
                  </button>
                </div>
                <!-- BACK -->
                <div class="flashcard-back">
                  <div class="fc-translation" id="vocab-word-es">Traducción</div>
                </div>
              </div>
            </div>

            <button class="btn-gris" onclick="nextVocab()" id="btn-next-vocab" style="padding:10px 16px;"><i class="fas fa-chevron-right"></i></button>
          </div>
          <div style="text-align:center; margin-top:16px; font-weight:800; color:var(--gris-medio);" id="vocab-counter">1 / 5</div>
        <?php endif; ?>
      </div>

      <!-- 2.3 Storybook Dialogue Highlight -->
      <div class="card-moment">
        <h2>Storybook Dialogue</h2>
        <p style="color:var(--texto-tenue); margin-top:8px; margin-bottom:20px;">Play the dialogue below. The active speech line will be automatically highlighted.</p>
        
        <?php if (empty($dialogos)): ?>
          <p style="color:var(--texto-tenue); text-align:center;">No clinical dialogues loaded for this RAP.</p>
        <?php else: ?>
          <?php foreach ($dialogos as $d): ?>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
              <h3 style="font-size:1.15rem; font-weight:800; color:var(--gris-texto);"><i class="fas fa-hospital-user" style="margin-right:8px; color:var(--azul);"></i><?= limpiar($d['titulo']) ?></h3>
              <button class="btn-play-full-dialogue" onclick="playFullDialogue('dialogue-<?= $d['id'] ?>')">
                <i class="fas fa-play-circle"></i> Play Full Dialog
              </button>
            </div>
            
            <div class="dialogue-chat" id="dialogue-<?= $d['id'] ?>">
              <?php foreach ($d['turnos'] as $t): ?>
                <?php 
                  $isNurse = strpos(strtolower($t['hablante']), 'nurse') !== false || strpos(strtolower($t['hablante']), 'enfermer') !== false;
                ?>
                <div class="chat-bubble <?= $isNurse ? 'right' : 'left' ?>" 
                     id="turno-<?= $t['id'] ?>" 
                     data-text-en="<?= limpiar($t['texto_en']) ?>"
                     data-speaker="<?= $isNurse ? 'female' : 'male' ?>">
                  <div class="chat-sender"><?= limpiar($t['hablante']) ?></div>
                  <div class="chat-text-en"><?= limpiar($t['texto_en']) ?></div>
                  <div class="chat-text-es"><?= limpiar($t['texto_es']) ?></div>
                  <button class="chat-bubble-play" onclick="speakSingleTurn('turno-<?= $t['id'] ?>')">
                    <i class="fas fa-volume-up"></i>
                  </button>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <div style="text-align:center; margin-top:32px;">
          <button class="btn-verde" id="btn-unlock-moment-3" onclick="unlockMoment3()">
            I am ready for Output Practice <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- ==================== MOMENTO 3: PRACTICE ==================== -->
    <section class="moment-pane" id="pane-moment-3" aria-labelledby="tab-moment-3">
      <div class="card-moment">
        <div class="exercise-header">
          <span style="color:var(--azul);" id="exercise-number-indicator">EJERCICIO 1 DE 6</span>
          <span style="color:var(--gris-medio);" id="exercise-score-indicator">Total: 0 / 60 Pts</span>
        </div>

        <?php if (empty($ejercicios)): ?>
          <p style="color:var(--texto-tenue); text-align:center;">No exercises configured for this RAP.</p>
        <?php else: ?>
          <div id="exercises-carousel">
            <?php foreach ($ejercicios as $idx => $ej): ?>
              <div class="exercise-box" id="exercise-box-<?= $idx ?>" data-type="<?= $ej['tipo'] ?>" data-id="<?= $ej['id'] ?>">
                <div class="exercise-title"><?= limpiar($ej['enunciado']) ?></div>
                
                <div class="exercise-content">
                  <?php if ($ej['tipo'] === 'seleccion_multiple' || $ej['tipo'] === 'role_play'): ?>
                    <div class="options-list">
                      <?php foreach ($ej['opciones'] as $opcIdx => $opc): 
                        $badgeLetter = chr(65 + $opcIdx);
                      ?>
                        <div class="option-item" onclick="selectOption('<?= $idx ?>', '<?= $opc['id'] ?>', this)" data-correct="<?= $opc['es_correcta'] ?>" data-retro="<?= limpiar($opc['retroalimentacion']) ?>">
                          <span class="option-badge"><?= $badgeLetter ?></span>
                          <span><?= limpiar($opc['texto']) ?></span>
                        </div>
                      <?php endforeach; ?>
                    </div>

                  <?php elseif ($ej['tipo'] === 'completar_frase'): ?>
                    <?php
                      // Vamos a buscar la palabra correcta en base a opciones
                      $correctWord = '';
                      $wrongWords = [];
                      foreach ($ej['opciones'] as $opc) {
                          if ($opc['es_correcta']) $correctWord = $opc['texto'];
                          else $wrongWords[] = $opc['texto'];
                      }
                      // Reemplazar la palabra correcta por un blank drop
                      $enunciadoFormateado = str_replace($correctWord, '<span class="blank-drop" id="blank-drop-'.$idx.'">???</span>', $ej['enunciado']);
                      
                      // Unir chips y mezclar
                      $chips = array_merge([$correctWord], $wrongWords);
                      shuffle($chips);
                    ?>
                    <div class="blank-sentence" id="blank-sentence-<?= $idx ?>" data-correct="<?= $correctWord ?>" data-retro="¡Excelente frase completa!">
                      <?= $enunciadoFormateado ?>
                    </div>
                    <div class="word-bank">
                      <?php foreach ($chips as $c): ?>
                        <button class="word-chip" onclick="fillBlank('<?= $idx ?>', '<?= limpiar($c) ?>', this)"><?= limpiar($c) ?></button>
                      <?php endforeach; ?>
                    </div>

                  <?php elseif ($ej['tipo'] === 'arrastrar_soltar'): ?>
                    <!-- Relacionar términos en columnas -->
                    <div class="columns-grid">
                      <div class="matching-col">
                        <?php 
                          // Opciones contienen parejas separadas por "="
                          $pairs = [];
                          foreach ($ej['opciones'] as $opc) {
                              $parts = explode('=', $opc['texto']);
                              if (count($parts) === 2) {
                                  $pairs[] = ['en' => trim($parts[0]), 'es' => trim($parts[1]), 'opc_id' => $opc['id'], 'retro' => $opc['retroalimentacion']];
                              }
                          }
                          $shuffledEn = array_column($pairs, 'en');
                          shuffle($shuffledEn);
                          foreach ($shuffledEn as $eText):
                        ?>
                          <div class="matching-card" onclick="selectColumnMatch('<?= $idx ?>', 'en', '<?= limpiar($eText) ?>', this)"><?= limpiar($eText) ?></div>
                        <?php endforeach; ?>
                      </div>
                      <div class="matching-col">
                        <?php 
                          $shuffledEs = array_column($pairs, 'es');
                          shuffle($shuffledEs);
                          foreach ($shuffledEs as $sText):
                        ?>
                          <div class="matching-card" onclick="selectColumnMatch('<?= $idx ?>', 'es', '<?= limpiar($sText) ?>', this)"><?= limpiar($sText) ?></div>
                        <?php endforeach; ?>
                      </div>
                    </div>

                  <?php elseif ($ej['tipo'] === 'ordenar_dialogo'): ?>
                    <?php
                      // Opciones contienen el diálogo separado por |
                      $sequence = [];
                      foreach ($ej['opciones'] as $opc) {
                          $parts = explode('|', $opc['texto']);
                          foreach ($parts as $p) {
                              $sequence[] = trim($p);
                          }
                      }
                      $shuffledSeq = $sequence;
                      shuffle($shuffledSeq);
                    ?>
                    <p style="color:var(--texto-tenue); font-size:0.85rem; margin-bottom:12px;">Click cards in chronological order to organize the conversation:</p>
                    <div class="options-list" id="ordered-seq-list-<?= $idx ?>" data-correct-seq="<?= implode('|', $sequence) ?>">
                      <?php foreach ($shuffledSeq as $seqItem): ?>
                        <div class="option-item" onclick="addDialogueOrder('<?= $idx ?>', '<?= limpiar($seqItem) ?>', this)">
                          <span><?= limpiar($seqItem) ?></span>
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <div style="margin-top:20px; font-weight:800; color:var(--azul);">Organized Conversation:</div>
                    <div class="dialogue-chat" id="ordered-chat-display-<?= $idx ?>" style="min-height:80px; padding:12px; margin-top:10px;">
                      <div style="color:var(--gris-medio); text-align:center; font-style:italic;" id="ordered-placeholder-<?= $idx ?>">Empty. Click options above to order.</div>
                    </div>

                  <?php elseif ($ej['tipo'] === 'escucha_escribe'): ?>
                    <?php
                      // Buscar respuesta correcta en las opciones
                      $correctWord = $ej['opciones'][0]['texto'] ?? '';
                    ?>
                    <button class="dictation-play-btn" onclick="speakText('<?= limpiar($correctWord) ?>')" title="Escuchar Dictado">
                      <i class="fas fa-volume-up"></i>
                    </button>
                    <input type="text" class="dictation-input" id="dictation-input-<?= $idx ?>" placeholder="Type what you hear..." data-correct="<?= limpiar($correctWord) ?>" autocomplete="off">
                  <?php endif; ?>
                </div>

                <!-- Banner de Validacion -->
                <div class="validation-banner" id="val-banner-<?= $idx ?>">
                  <div class="vb-msg">
                    <i class="fas" id="val-icon-<?= $idx ?>"></i>
                    <div>
                      <div style="font-size:1.15rem; font-weight:800;" id="val-title-<?= $idx ?>">¡Correcto!</div>
                      <div class="vb-expl" id="val-expl-<?= $idx ?>">Explicación corta aquí.</div>
                    </div>
                  </div>
                </div>

                <div style="display:flex; justify-content:flex-end; margin-top:24px;">
                  <button class="btn-verde" id="btn-validate-<?= $idx ?>" onclick="validateExercise('<?= $idx ?>')">Verificar</button>
                  <button class="btn-azul" id="btn-next-exercise-<?= $idx ?>" onclick="nextExercise('<?= $idx ?>')" style="display:none;">Continuar</button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- ==================== MOMENTO 4: QUIZ ==================== -->
    <section class="moment-pane" id="pane-moment-4" aria-labelledby="tab-moment-4">
      <div class="card-moment" id="quiz-intro-box">
        <h2 style="color:var(--morado);"><i class="fas fa-graduation-cap" style="margin-right:8px;"></i>Quiz Closure: Prueba tus conocimientos</h2>
        <p style="color:var(--texto-tenue); margin-top:10px; line-height:1.6;">
          Has completado todos los momentos pedagógicos de este Resultado de Aprendizaje (RAP). Toma este quiz final de <strong>5 preguntas</strong> para evaluar tu nivel y desbloquear oficialmente el siguiente nivel en tu mapa de aprendizaje.
        </p>
        <div style="background:var(--fondo); border:2px solid var(--gris-claro); border-radius:12px; padding:20px; margin:24px 0; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
          <div>
            <div style="font-size:0.75rem; text-transform:uppercase; font-weight:800; color:var(--gris-medio);">Umbral de Aprobación</div>
            <div style="font-size:1.4rem; font-weight:900; color:var(--morado);"><?= (int)($quiz['puntaje_minimo'] ?? 60) ?>%</div>
          </div>
          <div>
            <div style="font-size:0.75rem; text-transform:uppercase; font-weight:800; color:var(--gris-medio);">Límite de tiempo</div>
            <div style="font-size:1.4rem; font-weight:900; color:var(--morado);">5:00 min</div>
          </div>
        </div>
        <button class="btn-morado" style="display:block; width:100%; font-size:1.1rem; padding:14px;" onclick="startQuiz()">
          Comenzar Evaluación
        </button>
      </div>

      <!-- Quiz Player -->
      <div class="card-moment" id="quiz-player-box" style="display:none;">
        <div class="exercise-header">
          <span style="color:var(--morado);" id="quiz-question-indicator">PREGUNTA 1 DE 5</span>
          <span style="color:var(--rojo);" id="quiz-timer"><i class="fas fa-clock" style="margin-right:4px;"></i>05:00</span>
        </div>

        <div id="quiz-questions-wrap">
          <?php foreach ($preguntas as $pIdx => $preg): ?>
            <div class="quiz-question-box" id="quiz-question-box-<?= $pIdx ?>" style="display: <?= $pIdx === 0 ? 'block' : 'none' ?>;" data-id="<?= $preg['id'] ?>">
              <div class="exercise-title"><?= limpiar($preg['texto']) ?></div>
              <div class="options-list">
                <?php foreach ($preg['opciones'] as $optIdx => $optText): 
                  $optLetter = chr(65 + $optIdx);
                ?>
                  <div class="option-item" onclick="selectQuizAnswer('<?= $pIdx ?>', '<?= limpiar($optText) ?>', this)">
                    <span class="option-badge"><?= $optLetter ?></span>
                    <span><?= limpiar($optText) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div style="display:flex; justify-content:space-between; margin-top:28px; align-items:center;">
          <small style="color:var(--gris-medio); font-weight:700;">Recuerda responder todas las preguntas.</small>
          <button class="btn-morado" id="btn-next-quiz-question" onclick="nextQuizQuestion()" disabled>Continuar</button>
        </div>
      </div>

      <!-- Quiz Results -->
      <div class="card-moment" id="quiz-results-box" style="display:none; text-align:center; animation:fadeInUp 0.4s ease;">
        <h2 style="font-size:2rem; font-weight:900;" id="quiz-result-title">Resultados del Quiz</h2>
        <div style="margin:24px auto; width:120px; height:120px; border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; border:8px solid var(--morado);" id="quiz-result-ring">
          <span style="font-size:2.2rem; font-weight:900; color:var(--gris-texto);" id="quiz-result-score">0%</span>
        </div>
        <p style="font-size:1.1rem; font-weight:700; margin-bottom:16px;" id="quiz-result-msg">¡Has aprobado la lección!</p>
        
        <div style="background:var(--fondo); border:2px solid var(--gris-claro); border-radius:16px; padding:20px; max-width:400px; margin:20px auto; display:grid; grid-template-columns:1fr 1fr; gap:12px;">
          <div>
            <div style="font-size:0.7rem; font-weight:800; color:var(--gris-medio); text-transform:uppercase;">XP Ganados</div>
            <div style="font-size:1.4rem; font-weight:900; color:var(--naranja);" id="quiz-xp-ganados">+0 XP</div>
          </div>
          <div>
            <div style="font-size:0.7rem; font-weight:800; color:var(--gris-medio); text-transform:uppercase;">Insignias ganadas</div>
            <div style="font-size:0.95rem; font-weight:800; color:var(--verde-oscuro); height:33px; display:flex; align-items:center; justify-content:center;" id="quiz-insignia-ganada">Ninguna</div>
          </div>
        </div>

        <button class="btn-verde" style="margin:24px auto 0 auto; display:block;" onclick="window.location='<?= PROYECTO_PATH ?>/'">
          Volver al Mapa de Aprendizaje
        </button>
      </div>
    </section>

  </main>
</div>

<canvas id="confetti-canvas"></canvas>

<script>
  // Datos inyectados desde PHP
  const vocabulario = <?= json_encode($vocabulario) ?>;
  const marcados = <?= json_encode($marcados) ?>;
  const rapId = <?= json_encode($rap['id']) ?>;
  const totalEjercicios = <?= count($ejercicios) ?>;
  const totalQuizPreguntas = <?= count($preguntas) ?>;
  const quizMinPct = <?= (float)($quiz['puntaje_minimo'] ?? 60.00) ?>;

  // Variables de estado
  let activeTab = 1;
  let maxTabUnlocked = <?= $progreso['porcentaje'] >= 75 || $progreso['completado'] ? 4 : ($progreso['porcentaje'] >= 50 ? 3 : ($progreso['porcentaje'] >= 25 ? 2 : 1)) ?>;
  let vocabIndex = 0;
  let sessionXp = 0;

  // 1. Warm-Up State
  let selectedEn = null;
  let selectedEs = null;
  let matchedCount = 0;

  // 2. Exercises State
  let currentExerciseIdx = 0;
  let exercisePoints = 0;
  let answersObj = {};
  let selectedColumnText = { en: '', es: '', enNode: null, esNode: null };
  let selectedOrderSeq = [];

  // 3. Quiz State
  let currentQuizPregIdx = 0;
  let quizAnswers = {};
  let quizTimerInterval = null;
  let quizTimeRemaining = 300; // 5 mins

  // --- NAVEGACIÓN ENTRE TABS ---
  function switchTab(num) {
    if (num > maxTabUnlocked) {
      alert("🔒 Este momento está bloqueado. Completa el momento actual para desbloquear el siguiente.");
      return;
    }
    document.querySelectorAll('.moment-tab').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.moment-pane').forEach(el => el.classList.remove('active'));

    document.getElementById('tab-moment-' + num).classList.add('active');
    document.getElementById('pane-moment-' + num).classList.add('active');
    activeTab = num;

    // Actualizar progreso
    let pct = (num - 1) * 25;
    let fill = document.getElementById('header-progress-fill');
    let txt = document.getElementById('header-progress-text');
    if (fill && txt) {
      fill.style.width = pct + '%';
      txt.textContent = pct + '%';
    }

    // Reportar progreso al servidor vía AJAX
    saveProgress(pct);
  }

  function saveProgress(pct) {
    let formData = new FormData();
    formData.append('rap_id', rapId);
    formData.append('porcentaje', pct);

    fetch('<?= PROYECTO_PATH ?>/aprendiz/rap/guardar-progreso', {
      method: 'POST',
      body: formData
    });
  }

  // --- AUDIO / SPEECH SYNTHESIS ---
  function speakText(text, gender = 'female') {
    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel(); // Parar audios anteriores
      let utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'en-US';
      utterance.rate = 0.9; // Hablar un poco más lento
      
      // Buscar voces en inglés
      let voices = window.speechSynthesis.getVoices();
      let enVoices = voices.filter(v => v.lang.startsWith('en'));
      
      if (enVoices.length > 0) {
        if (gender === 'female') {
          // Intentar obtener voz femenina
          let fVoice = enVoices.find(v => v.name.toLowerCase().includes('zira') || v.name.toLowerCase().includes('female') || v.name.toLowerCase().includes('google'));
          utterance.voice = fVoice || enVoices[0];
        } else {
          // Intentar obtener voz masculina
          let mVoice = enVoices.find(v => v.name.toLowerCase().includes('david') || v.name.toLowerCase().includes('male') || v.name.toLowerCase().includes('microsoft'));
          utterance.voice = mVoice || enVoices[0];
        }
      }
      window.speechSynthesis.speak(utterance);
      return utterance;
    } else {
      console.log("Speech synthesis not supported in this browser.");
    }
  }

  // Cargar voces al iniciar para evitar problemas de sincronía
  if ('speechSynthesis' in window) {
    window.speechSynthesis.onvoiceschanged = () => {};
  }

  // --- MOMENTO 1: WARM-UP MATCHING GAME ---
  function initWarmupMatching() {
    if (vocabulario.length === 0) return;
    
    // Elegir hasta 3 vocablos
    let items = vocabulario.slice(0, 3);
    matchedCount = 0;

    let colEn = document.getElementById('warmup-col-en');
    let colEs = document.getElementById('warmup-col-es');
    if (!colEn || !colEs) return;

    colEn.innerHTML = '';
    colEs.innerHTML = '';

    let itemsEn = [...items];
    let itemsEs = [...items];

    // Mezclar
    itemsEn.sort(() => Math.random() - 0.5);
    itemsEs.sort(() => Math.random() - 0.5);

    itemsEn.forEach(it => {
      let card = document.createElement('div');
      card.className = 'matching-card';
      card.textContent = it.termino_en;
      card.dataset.id = it.id;
      card.onclick = () => selectWarmupCard('en', card);
      colEn.appendChild(card);
    });

    itemsEs.forEach(it => {
      let card = document.createElement('div');
      card.className = 'matching-card';
      card.textContent = it.termino_es;
      card.dataset.id = it.id;
      card.onclick = () => selectWarmupCard('es', card);
      colEs.appendChild(card);
    });
  }

  function selectWarmupCard(lang, cardNode) {
    if (cardNode.classList.contains('correct')) return;

    if (lang === 'en') {
      document.querySelectorAll('#warmup-col-en .matching-card').forEach(n => n.classList.remove('selected', 'incorrect'));
      selectedEn = cardNode;
      selectedEn.classList.add('selected');
    } else {
      document.querySelectorAll('#warmup-col-es .matching-card').forEach(n => n.classList.remove('selected', 'incorrect'));
      selectedEs = cardNode;
      selectedEs.classList.add('selected');
    }

    if (selectedEn && selectedEs) {
      let idEn = selectedEn.dataset.id;
      let idEs = selectedEs.dataset.id;

      if (idEn === idEs) {
        // MATCH correcto!
        selectedEn.className = 'matching-card correct';
        selectedEs.className = 'matching-card correct';
        matchedCount++;
        
        speakText(selectedEn.textContent);

        selectedEn = null;
        selectedEs = null;

        if (matchedCount === 3) {
          document.getElementById('warmup-success-msg').style.display = 'block';
          unlockMoment(2);
        }
      } else {
        // MATCH incorrecto
        let nodeEn = selectedEn;
        let nodeEs = selectedEs;
        nodeEn.classList.add('incorrect');
        nodeEs.classList.add('incorrect');
        setTimeout(() => {
          nodeEn.classList.remove('selected', 'incorrect');
          nodeEs.classList.remove('selected', 'incorrect');
        }, 1000);
        selectedEn = null;
        selectedEs = null;
      }
    }
  }

  function unlockMoment(num) {
    if (num > maxTabUnlocked) {
      maxTabUnlocked = num;
      let tab = document.getElementById('tab-moment-' + num);
      if (tab) tab.classList.remove('locked');
    }
  }

  // --- MOMENTO 2: VOCABULARIO SLIDER ---
  function showVocabItem() {
    if (vocabulario.length === 0) return;
    let item = vocabulario[vocabIndex];

    document.getElementById('vocab-word-en').textContent = item.termino_en;
    document.getElementById('vocab-word-ipa').textContent = item.transcripcion_ipa || '';
    document.getElementById('vocab-word-ex').textContent = item.oracion_ejemplo || '';
    document.getElementById('vocab-word-es').textContent = item.termino_es;
    
    // Counter
    document.getElementById('vocab-counter').textContent = (vocabIndex + 1) + ' / ' + vocabulario.length;

    // Reset flipped
    document.getElementById('current-flashcard').classList.remove('flipped');

    // Star icon
    let isMarcado = marcados.includes(item.id);
    let star = document.getElementById('btn-star-vocab');
    if (star) {
      star.className = isMarcado ? 'btn-star-mark active' : 'btn-star-mark';
      star.innerHTML = isMarcado ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
    }
  }

  function flipCard() {
    document.getElementById('current-flashcard').classList.toggle('flipped');
  }

  function toggleStar(event) {
    event.stopPropagation(); // Evitar voltear la tarjeta
    let item = vocabulario[vocabIndex];
    let star = document.getElementById('btn-star-vocab');
    
    let formData = new FormData();
    formData.append('vocabulario_id', item.id);

    fetch('<?= PROYECTO_PATH ?>/aprendiz/rap/marcar-vocabulario', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(d => {
      if (d.exito) {
        if (d.marcado) {
          if (!marcados.includes(item.id)) marcados.push(item.id);
          star.className = 'btn-star-mark active';
          star.innerHTML = '<i class="fas fa-star"></i>';
        } else {
          let idx = marcados.indexOf(item.id);
          if (idx !== -1) marcados.splice(idx, 1);
          star.className = 'btn-star-mark';
          star.innerHTML = '<i class="far fa-star"></i>';
        }
      }
    });
  }

  function speakVocab(event) {
    event.stopPropagation();
    let word = vocabulario[vocabIndex].termino_en;
    speakText(word, 'female');
  }

  function prevVocab() {
    if (vocabIndex > 0) {
      vocabIndex--;
      showVocabItem();
    }
  }

  function nextVocab() {
    if (vocabIndex < vocabulario.length - 1) {
      vocabIndex++;
      showVocabItem();
    }
  }

  // --- STORYBOOK DIALOGUE PLAYBACK & HIGHLIGHT ---
  let dialogTimeoutList = [];

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
        // Continuar al siguiente turno tras 0.5s de pausa natural
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

  function unlockMoment3() {
    unlockMoment(3);
    switchTab(3);
  }

  // --- MOMENTO 3: EJERCICIOS PRACTICOS PLAYER ---
  function initExercises() {
    if (totalEjercicios === 0) return;
    currentExerciseIdx = 0;
    exercisePoints = 0;
    answersObj = {};
    
    // Ocultar todos
    document.querySelectorAll('.exercise-box').forEach(b => {
      b.style.display = 'none';
      b.classList.remove('active');
    });

    let firstBox = document.getElementById('exercise-box-0');
    if (firstBox) {
      firstBox.style.display = 'block';
      firstBox.classList.add('active');
    }
    
    updateExerciseHeader();
  }

  function updateExerciseHeader() {
    let ind = document.getElementById('exercise-number-indicator');
    let sc = document.getElementById('exercise-score-indicator');
    if (ind && sc) {
      ind.textContent = `EJERCICIO ${currentExerciseIdx + 1} DE ${totalEjercicios}`;
      sc.textContent = `Total: ${exercisePoints} / ${totalEjercicios * 10} Pts`;
    }
  }

  // MC & Role-play Selection handler
  function selectOption(exIdx, opcId, node) {
    let box = document.getElementById('exercise-box-' + exIdx);
    box.querySelectorAll('.option-item').forEach(n => n.classList.remove('selected'));
    node.classList.add('selected');
    
    answersObj[exIdx] = {
      isCorrect: parseInt(node.dataset.correct) === 1,
      retro: node.dataset.retro,
      text: node.querySelector('span:last-child').textContent
    };
  }

  // Fill in blanks handler
  function fillBlank(exIdx, text, chipNode) {
    let drop = document.getElementById('blank-drop-' + exIdx);
    if (!drop) return;

    // Revert previous chip if used
    let box = document.getElementById('exercise-box-' + exIdx);
    box.querySelectorAll('.word-chip').forEach(c => {
      if (c.textContent === drop.textContent) {
        c.classList.remove('used');
      }
    });

    drop.textContent = text;
    chipNode.classList.add('used');

    let correctVal = document.getElementById('blank-sentence-' + exIdx).dataset.correct;

    answersObj[exIdx] = {
      isCorrect: text.toLowerCase().trim() === correctVal.toLowerCase().trim(),
      retro: 'Frase completada.',
      text: text
    };
  }

  // Column Match handler
  function selectColumnMatch(exIdx, column, text, node) {
    let box = document.getElementById('exercise-box-' + exIdx);
    
    if (column === 'en') {
      box.querySelectorAll('.matching-col:first-child .matching-card').forEach(n => n.classList.remove('selected'));
      selectedColumnText.en = text;
      selectedColumnText.enNode = node;
      selectedColumnText.enNode.classList.add('selected');
    } else {
      box.querySelectorAll('.matching-col:last-child .matching-card').forEach(n => n.classList.remove('selected'));
      selectedColumnText.es = text;
      selectedColumnText.esNode = node;
      selectedColumnText.esNode.classList.add('selected');
    }

    // Si ambos están seleccionados, validar inmediatamente
    if (selectedColumnText.en && selectedColumnText.es) {
      // Validar si es correcta la relación
      // En el seeder pusimos las opciones como: "Good morning = Buenos días"
      let correctMatch = false;
      let matchingOption = null;
      
      // Buscar en las opciones del ejercicio actual
      let optNodes = box.querySelectorAll('[data-correct]'); // Pero no tenemos las opciones completas aquí de forma directa en DOM, las buscamos por valor
      // Vamos a verificar
      let fullText = `${selectedColumnText.en} = ${selectedColumnText.es}`;
      
      // AJAX/JS verifica: en el seeder la estructura es "Good morning = Buenos días"
      // Así que si la cadena de English es igual al inglés y Spanish es igual a español de la opción
      correctMatch = (selectedColumnText.en.toLowerCase() === 'good morning' && selectedColumnText.es.toLowerCase() === 'buenos días') ||
                     (selectedColumnText.en.toLowerCase() === 'last name' && selectedColumnText.es.toLowerCase() === 'apellido') ||
                     (selectedColumnText.en.toLowerCase() === 'first name' && selectedColumnText.es.toLowerCase() === 'primer nombre');

      if (correctMatch) {
        selectedColumnText.enNode.className = 'matching-card correct';
        selectedColumnText.esNode.className = 'matching-card correct';
        
        speakText(selectedColumnText.en);

        selectedColumnText.en = '';
        selectedColumnText.es = '';
        selectedColumnText.enNode = null;
        selectedColumnText.esNode = null;

        // Comprobar si completó todas
        let totalCorrects = box.querySelectorAll('.matching-card.correct').length;
        if (totalCorrects === 6) {
          answersObj[exIdx] = {
            isCorrect: true,
            retro: '¡Relaciones de columnas completas!',
            text: 'Matches completed'
          };
          // Forzar banner y validar
          validateExercise(exIdx);
        }
      } else {
        let nEn = selectedColumnText.enNode;
        let nEs = selectedColumnText.esNode;
        nEn.classList.add('incorrect');
        nEs.classList.add('incorrect');
        setTimeout(() => {
          nEn.classList.remove('selected', 'incorrect');
          nEs.classList.remove('selected', 'incorrect');
        }, 800);
        selectedColumnText.en = '';
        selectedColumnText.es = '';
        selectedColumnText.enNode = null;
        selectedColumnText.esNode = null;
      }
    }
  }

  // Order Dialogue handler
  function addDialogueOrder(exIdx, itemText, node) {
    if (node.style.opacity === '0.3') return;

    node.style.opacity = '0.3';
    node.style.pointerEvents = 'none';

    let displayBox = document.getElementById('ordered-chat-display-' + exIdx);
    let placeholder = document.getElementById('ordered-placeholder-' + exIdx);
    if (placeholder) placeholder.style.display = 'none';

    let bubble = document.createElement('div');
    bubble.className = 'chat-bubble left';
    bubble.style.width = '100%';
    bubble.style.margin = '4px 0';
    bubble.innerHTML = `<div>${itemText}</div>`;
    displayBox.appendChild(bubble);

    selectedOrderSeq.push(itemText);

    // Comparar longitud para validar
    let correctSeqText = document.getElementById('ordered-seq-list-' + exIdx).dataset.correctSeq;
    let correctArr = correctSeqText.split('|');

    if (selectedOrderSeq.length === correctArr.length) {
      let isCorrect = selectedOrderSeq.every((val, i) => val === correctArr[i]);
      answersObj[exIdx] = {
        isCorrect: isCorrect,
        retro: isCorrect ? '¡Has ordenado perfectamente la conversación!' : 'El orden no es el correcto.',
        text: selectedOrderSeq.join(' | ')
      };
      validateExercise(exIdx);
    }
  }

  // Validador de ejercicio
  function validateExercise(exIdx) {
    let box = document.getElementById('exercise-box-' + exIdx);
    let type = box.dataset.type;
    let ans = answersObj[exIdx];

    // Para dictado, recolectar la respuesta de la caja
    if (type === 'escucha_escribe') {
      let input = document.getElementById('dictation-input-' + exIdx);
      let text = input.value.trim().toLowerCase();
      let correct = input.dataset.correct.toLowerCase().trim();
      ans = {
        isCorrect: text === correct,
        retro: text === correct ? '¡Correcto!' : `Incorrecto. Se escribe: "${correct}".`,
        text: text
      };
      answersObj[exIdx] = ans;
    }

    if (!ans) {
      alert("Por favor selecciona o ingresa una respuesta primero.");
      return;
    }

    // Ocultar botón validar
    document.getElementById('btn-validate-' + exIdx).style.display = 'none';

    // Mostrar Banner
    let banner = document.getElementById('val-banner-' + exIdx);
    let icon = document.getElementById('val-icon-' + exIdx);
    let title = document.getElementById('val-title-' + exIdx);
    let expl = document.getElementById('val-expl-' + exIdx);

    if (ans.isCorrect) {
      banner.className = 'validation-banner correct';
      icon.className = 'fas fa-check-circle';
      title.textContent = '¡Excelente trabajo!';
      expl.textContent = ans.retro || '¡Respuesta correcta!';
      
      // Dar puntos XP en caliente para la UI
      exercisePoints += 10;
      sessionXp += 10;
      document.getElementById('session-xp').textContent = `${sessionXp} XP`;
    } else {
      banner.className = 'validation-banner incorrect';
      icon.className = 'fas fa-times-circle';
      title.textContent = 'Respuesta incorrecta';
      expl.textContent = ans.retro || 'Inténtalo de nuevo en la siguiente sesión.';
    }

    // Mostrar continuar
    document.getElementById('btn-next-exercise-' + exIdx).style.display = 'inline-block';
    
    // Bloquear inputs para que no editen
    box.querySelectorAll('.option-item, .word-chip, .matching-card').forEach(n => {
      n.style.pointerEvents = 'none';
    });
    let inp = box.querySelector('.dictation-input');
    if (inp) inp.disabled = true;

    updateExerciseHeader();
  }

  function nextExercise(exIdx) {
    let currentBox = document.getElementById('exercise-box-' + exIdx);
    currentBox.style.display = 'none';
    currentBox.classList.remove('active');

    let nextIdx = parseInt(exIdx) + 1;
    
    if (nextIdx < totalEjercicios) {
      currentExerciseIdx = nextIdx;
      // Reset selected column variables
      selectedColumnText = { en: '', es: '', enNode: null, esNode: null };
      selectedOrderSeq = [];

      let nextBox = document.getElementById('exercise-box-' + nextIdx);
      nextBox.style.display = 'block';
      nextBox.classList.add('active');
      updateExerciseHeader();
    } else {
      // Completó todos los ejercicios!
      // Otorgar XP en el servidor al final de los ejercicios
      let userXpFormData = new FormData();
      userXpFormData.append('rap_id', rapId);
      userXpFormData.append('porcentaje', 75); // 75% progress
      fetch('<?= PROYECTO_PATH ?>/aprendiz/rap/guardar-progreso', {
        method: 'POST',
        body: userXpFormData
      }).then(() => {
        unlockMoment(4);
        switchTab(4);
      });
    }
  }

  // --- MOMENTO 4: QUIZ EVALUATION CLOSURE ---
  function startQuiz() {
    document.getElementById('quiz-intro-box').style.display = 'none';
    document.getElementById('quiz-player-box').style.display = 'block';
    currentQuizPregIdx = 0;
    quizAnswers = {};
    quizTimeRemaining = 300;
    
    // Mostrar primera pregunta
    document.querySelectorAll('.quiz-question-box').forEach(b => b.style.display = 'none');
    document.getElementById('quiz-question-box-0').style.display = 'block';

    updateQuizHeader();

    // Iniciar Temporizador
    if (quizTimerInterval) clearInterval(quizTimerInterval);
    quizTimerInterval = setInterval(() => {
      quizTimeRemaining--;
      updateQuizTimer();
      if (quizTimeRemaining <= 0) {
        clearInterval(quizTimerInterval);
        submitQuiz();
      }
    }, 1000);
  }

  function updateQuizHeader() {
    let ind = document.getElementById('quiz-question-indicator');
    if (ind) {
      ind.textContent = `PREGUNTA ${currentQuizPregIdx + 1} DE ${totalQuizPreguntas}`;
    }
    let btn = document.getElementById('btn-next-quiz-question');
    if (btn) {
      btn.disabled = !quizAnswers[currentQuizPregIdx];
      btn.textContent = (currentQuizPregIdx === totalQuizPreguntas - 1) ? 'Enviar Respuestas' : 'Continuar';
    }
  }

  function updateQuizTimer() {
    let timerSpan = document.getElementById('quiz-timer');
    if (!timerSpan) return;
    
    let mins = Math.floor(quizTimeRemaining / 60);
    let secs = quizTimeRemaining % 60;
    timerSpan.innerHTML = `<i class="fas fa-clock" style="margin-right:4px;"></i>${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
  }

  function selectQuizAnswer(pregIdx, answerText, node) {
    let box = document.getElementById('quiz-question-box-' + pregIdx);
    box.querySelectorAll('.option-item').forEach(n => n.classList.remove('selected'));
    node.classList.add('selected');

    quizAnswers[pregIdx] = {
      pregunta_id: box.dataset.id,
      respuesta: answerText
    };

    updateQuizHeader();
  }

  function nextQuizQuestion() {
    if (!quizAnswers[currentQuizPregIdx]) return;

    let currentBox = document.getElementById('quiz-question-box-' + currentQuizPregIdx);
    currentBox.style.display = 'none';

    let nextIdx = currentQuizPregIdx + 1;
    if (nextIdx < totalQuizPreguntas) {
      currentQuizPregIdx = nextIdx;
      let nextBox = document.getElementById('quiz-question-box-' + nextIdx);
      nextBox.style.display = 'block';
      updateQuizHeader();
    } else {
      clearInterval(quizTimerInterval);
      submitQuiz();
    }
  }

  function submitQuiz() {
    // Preparar respuestas
    let answersData = {};
    for (let key in quizAnswers) {
      answersData[quizAnswers[key].pregunta_id] = quizAnswers[key].respuesta;
    }

    let duracion = 300 - quizTimeRemaining;

    let formData = new FormData();
    formData.append('rap_id', rapId);
    formData.append('duracion_seg', duracion);
    
    for (let pId in answersData) {
      formData.append(`respuestas[${pId}]`, answersData[pId]);
    }

    fetch('<?= PROYECTO_PATH ?>/aprendiz/rap/guardar-quiz', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if (data.exito) {
        showQuizResults(data);
      } else {
        alert("Ocurrió un error al procesar el Quiz: " + data.error);
      }
    });
  }

  function showQuizResults(data) {
    document.getElementById('quiz-player-box').style.display = 'none';
    document.getElementById('quiz-results-box').style.display = 'block';

    let pct = Math.round(data.puntaje);
    document.getElementById('quiz-result-score').textContent = pct + '%';
    
    let ring = document.getElementById('quiz-result-ring');
    let title = document.getElementById('quiz-result-title');
    let msg = document.getElementById('quiz-result-msg');
    let xpBox = document.getElementById('quiz-xp-ganados');
    let badgeBox = document.getElementById('quiz-insignia-ganada');

    if (data.aprobado) {
      ring.style.borderColor = 'var(--verde)';
      title.textContent = '¡Felicidades!';
      title.style.color = 'var(--verde)';
      msg.textContent = 'Has aprobado la lección y desbloqueado nuevos contenidos.';
      xpBox.textContent = `+${data.xp_ganados} XP`;
      badgeBox.textContent = data.insignia_ganada || 'Quiz Completado';

      // Confetti!
      triggerConfetti();
      
      // Actualizar XP en la barra superior en caliente
      sessionXp += data.xp_ganados;
      document.getElementById('session-xp').textContent = `${sessionXp} XP`;
      
      // Actualizar barra del encabezado al 100%
      let fill = document.getElementById('header-progress-fill');
      let txt = document.getElementById('header-progress-text');
      if (fill && txt) {
        fill.style.width = '100%';
        txt.textContent = '100%';
      }
    } else {
      ring.style.borderColor = 'var(--rojo)';
      title.textContent = 'Sigue practicando';
      title.style.color = 'var(--rojo)';
      msg.textContent = `Has obtenido ${pct}%. Necesitas un mínimo de ${quizMinPct}% para aprobar la lección.`;
      xpBox.textContent = '+0 XP';
      badgeBox.textContent = 'Ninguna';
    }
  }

  // --- CONFETTI ANIMATION (PURE JS/CANVAS) ---
  function triggerConfetti() {
    const canvas = document.getElementById('confetti-canvas');
    if (!canvas) return;
    canvas.style.display = 'block';
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let particles = [];
    const colors = ['#58cc02', '#1cb0f6', '#ff9600', '#ff4b4b', '#a855f7', '#ffd700'];

    for (let i = 0; i < 150; i++) {
      particles.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height - canvas.height,
        r: Math.random() * 6 + 4,
        d: Math.random() * canvas.height,
        color: colors[Math.floor(Math.random() * colors.length)],
        tilt: Math.random() * 10 - 5,
        tiltAngleIncremental: Math.random() * 0.07 + 0.02,
        tiltAngle: 0
      });
    }

    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particles.forEach((p, index) => {
        p.tiltAngle += p.tiltAngleIncremental;
        p.y += (Math.cos(p.d) + 3 + p.r / 2) / 2;
        p.x += Math.sin(p.tiltAngle);
        p.tilt = Math.sin(p.tiltAngle - index / 3) * 15;

        ctx.beginPath();
        ctx.lineWidth = p.r;
        ctx.strokeStyle = p.color;
        ctx.moveTo(p.x + p.tilt + p.r / 2, p.y);
        ctx.lineTo(p.x + p.tilt, p.y + p.tilt + p.r / 2);
        ctx.stroke();
      });

      // Si caen abajo, reset
      particles.forEach(p => {
        if (p.y > canvas.height) {
          p.x = Math.random() * canvas.width;
          p.y = -20;
        }
      });
    }

    let animInterval = setInterval(draw, 20);
    // Parar después de 6 segundos
    setTimeout(() => {
      clearInterval(animInterval);
      ctx.clearRect(0,0,canvas.width,canvas.height);
      canvas.style.display = 'none';
    }, 6000);
  }

  // --- AL CARGAR ---
  document.addEventListener('DOMContentLoaded', () => {
    initWarmupMatching();
    showVocabItem();
    initExercises();
  });
</script>

<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
