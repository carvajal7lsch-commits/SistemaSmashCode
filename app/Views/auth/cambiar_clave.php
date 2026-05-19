<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambiar Contraseña — SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>/* Aplicar tema guardado antes del paint */
  (function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();
  </script>
  <style>
    .pagina-cambio-clave {
      min-height: 100vh; display: flex; align-items: center;
      justify-content: center; background: var(--fondo); padding: 24px;
    }
    .caja-cambio {
      background: var(--blanco); border-radius: var(--radio);
      padding: 40px 36px; max-width: 460px; width: 100%;
      border: 2px solid var(--borde); box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    }
    .icono-clave {
      width: 72px; height: 72px; border-radius: 50%;
      background: linear-gradient(135deg, var(--azul), #0A91D1);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.8rem; color: #fff; margin: 0 auto 20px;
      box-shadow: 0 4px 0 #0A91D1;
    }
    .indicador-fuerza { height: 6px; border-radius: 3px; margin-top: 6px; transition: all 0.3s; }
    .fuerza-debil  { background: var(--rojo);    width: 30%; }
    .fuerza-media  { background: var(--naranja); width: 60%; }
    .fuerza-fuerte { background: var(--verde);   width: 100%; }
  </style>
</head>
<body>
<!-- Botón flotante de tema -->
<button id="btn-cambiar-tema" class="btn-tema" aria-label="Cambiar a modo claro" title="Cambiar a modo claro"
  style="position:fixed; top:16px; right:20px; z-index:9999;">
  <i class="fas fa-sun tema-icono"></i>
  <span class="tema-label">Claro</span>
</button>
<div class="pagina-cambio-clave">
  <div class="caja-cambio">

    <div class="icono-clave"><i class="fas fa-key"></i></div>

    <h1 style="font-size: 1.4rem; font-weight: 900; text-align:center; margin-bottom: 6px;">Cambiar Contraseña</h1>
    <p style="font-size: 0.85rem; color: var(--gris-medio); text-align:center; margin-bottom: 24px; line-height:1.6;">
      Por seguridad, debes establecer una <strong>nueva contraseña personal</strong> antes de continuar.
      Esta contraseña temporal no podrás volver a usarla.
    </p>

    <?php if ($error): ?>
      <div class="alerta alerta-error"><i class="fas fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= PROYECTO_PATH ?>/cambiar-clave/guardar" novalidate id="form-clave">
      <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

      <div class="grupo-campo">
        <label class="etiqueta-campo" for="contrasena">Nueva Contraseña *</label>
        <div class="contenedor-input">
          <i class="fas fa-lock icono-input"></i>
          <input type="password" id="contrasena" name="contrasena" class="campo-input"
                 placeholder="Mín. 8 chars, 1 mayúscula, 1 número" required
                 oninput="evaluarFuerza(this.value)">
        </div>
        <div class="indicador-fuerza" id="indicador-fuerza" style="background: var(--gris-claro); width:0;"></div>
        <span class="ayuda-campo" id="ayuda-fuerza">Ingresa tu nueva contraseña.</span>
      </div>

      <div class="grupo-campo">
        <label class="etiqueta-campo" for="contrasena_confirmar">Confirmar Contraseña *</label>
        <div class="contenedor-input">
          <i class="fas fa-lock icono-input"></i>
          <input type="password" id="contrasena_confirmar" name="contrasena_confirmar" class="campo-input"
                 placeholder="Repite la contraseña" required>
        </div>
      </div>

      <ul style="font-size:0.78rem; color: var(--gris-medio); margin-bottom: 20px; padding-left: 18px;">
        <li>Mínimo 8 caracteres</li>
        <li>Al menos 1 letra mayúscula</li>
        <li>Al menos 1 número</li>
        <li>Las contraseñas deben coincidir</li>
      </ul>

      <button type="submit" class="btn btn-verde">
        <i class="fas fa-floppy-disk"></i> Guardar y Continuar
      </button>
    </form>

  </div>
</div>

<script>
function evaluarFuerza(clave) {
  const indicador = document.getElementById('indicador-fuerza');
  const ayuda     = document.getElementById('ayuda-fuerza');
  let puntos = 0;
  if (clave.length >= 8)          puntos++;
  if (/[A-Z]/.test(clave))        puntos++;
  if (/[0-9]/.test(clave))        puntos++;
  if (/[^A-Za-z0-9]/.test(clave)) puntos++;

  indicador.className = 'indicador-fuerza';
  if (puntos <= 1) {
    indicador.classList.add('fuerza-debil');
    ayuda.textContent = '⚠️ Contraseña débil — agrega mayúsculas y números.';
  } else if (puntos === 2 || puntos === 3) {
    indicador.classList.add('fuerza-media');
    ayuda.textContent = '👍 Contraseña aceptable — agrega un símbolo para mejorarla.';
  } else {
    indicador.classList.add('fuerza-fuerte');
    ayuda.textContent = '✅ Contraseña fuerte — ¡excelente!';
  }
}
</script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
