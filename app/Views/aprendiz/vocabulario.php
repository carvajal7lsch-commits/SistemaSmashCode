<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vocabulario — SmashCode Enfermería SENA</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>/* Aplicar tema guardado antes del paint para evitar parpadeo */
  (function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();
  </script>
  <style>
    :root {
      --duo-green: #58cc02;
      --duo-green-dark: #46a302;
      --duo-gray: #e5e5e5;
      --duo-text: #4b4b4b;
    }
    .module-view { display: flex; flex-direction: column; padding: 20px 40px; background: #fff; flex: 1; height: 100vh; overflow-y: auto; }
    .module-header { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid var(--duo-gray); }
    .header-icon { font-size: 40px; color: var(--duo-green); background: rgba(88,204,2,0.1); padding: 15px; border-radius: 15px; }
    .module-header h1 { font-size: 24px; font-weight: 800; margin: 0 0 5px 0; color: var(--duo-text); }
    .module-header p { margin: 0; color: #777; font-size: 14px; }
    
    .vocab-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
    .vocab-card { border: 2px solid var(--duo-gray); border-radius: 15px; padding: 20px; display: flex; align-items: center; gap: 15px; background: white; transition: transform 0.2s; position: relative; }
    .vocab-card:hover { transform: translateY(-2px); border-color: #d0d0d0; }
    .btn-play-audio { width: 45px; height: 45px; border-radius: 12px; background: #1cb0f6; color: white; border: none; box-shadow: 0 4px 0 #1899d6; cursor: pointer; font-size: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .btn-play-audio:active { transform: translateY(4px); box-shadow: 0 0 0 #1899d6; }
    .vocab-details { flex: 1; }
    .vocab-english { font-size: 18px; font-weight: 800; margin: 0 0 4px 0; color: var(--duo-text); }
    .vocab-spanish { font-size: 14px; margin: 0; color: #777; }
  </style>
</head>
<body>

<div class="contenedor-app">

  <?php include dirname(__DIR__) . '/layouts/aprendiz_sidebar.php'; ?>

  <main class="contenido-principal">
    <div class="module-view">
        <div class="module-header">
            <i class="fas fa-book-medical header-icon"></i>
            <div>
                <h1>Vocabulario Técnico</h1>
                <p>Domina el vocabulario médico en inglés que todo técnico en enfermería necesita.</p>
            </div>
        </div>

        <div class="vocab-list" id="vocab-container">
            <!-- Mockup content -->
            <div class="vocab-card">
                <button class="btn-play-audio" onclick="alert('Reproduciendo...')"><i class="fas fa-volume-up"></i></button>
                <div class="vocab-details"><h3 class="vocab-english">Blood Pressure</h3><p class="vocab-spanish">Presión Arterial</p></div>
            </div>
            <div class="vocab-card">
                <button class="btn-play-audio" onclick="alert('Reproduciendo...')"><i class="fas fa-volume-up"></i></button>
                <div class="vocab-details"><h3 class="vocab-english">Syringe</h3><p class="vocab-spanish">Jeringa</p></div>
            </div>
            <div class="vocab-card">
                <button class="btn-play-audio" onclick="alert('Reproduciendo...')"><i class="fas fa-volume-up"></i></button>
                <div class="vocab-details"><h3 class="vocab-english">Stethoscope</h3><p class="vocab-spanish">Estetoscopio</p></div>
            </div>
        </div>
    </div>
  </main>
</div>

<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
