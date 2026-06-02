<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicios — SmashCode Enfermería SENA</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>
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
                <h1>Ejercicios de Práctica</h1>
                <p>Mejora tu gramática y comprensión con ejercicios interactivos.</p>
            </div>
        </div>
        <div style="text-align: center; color: #777; padding: 50px;">
            <i class="fas fa-tools" style="font-size: 48px; margin-bottom: 20px; color: var(--duo-gray-dark);"></i>
            <h2>Módulo en construcción</h2>
            <p>Pronto podrás completar ejercicios aquí.</p>
        </div>
    </div>
  </main>
</div>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
