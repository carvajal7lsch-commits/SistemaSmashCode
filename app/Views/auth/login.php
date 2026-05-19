<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ingresar — SmashCode</title>
  <meta name="description" content="Plataforma de inglés clínico para Enfermería SENA.">
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>/* Aplicar tema guardado antes del paint */
  (function(){var t=localStorage.getItem('smashcode_tema');if(t)document.documentElement.setAttribute('data-theme',t);})();
  </script>
</head>
<body>
<!-- Botón flotante de tema -->
<button id="btn-cambiar-tema" class="btn-tema" aria-label="Cambiar a modo claro" title="Cambiar a modo claro"
  style="position:fixed; top:16px; right:20px; z-index:9999;">
  <i class="fas fa-sun tema-icono"></i>
  <span class="tema-label">Claro</span>
</button>
<main class="pagina-auth">
  <div class="contenedor-auth animar-entrada">

    <!-- Panel izquierdo decorativo con pingüino -->
    <div class="panel-auth-izq">
      <!-- Pingüino SVG inline -->
      <div class="mascota" style="font-size:0;">
        <svg width="110" height="130" viewBox="0 0 110 130" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:12px;">
          <!-- Cuerpo -->
          <ellipse cx="55" cy="78" rx="38" ry="44" fill="#1A1A2E"/>
          <!-- Panza blanca -->
          <ellipse cx="55" cy="84" rx="24" ry="30" fill="#FFFFFF"/>
          <!-- Cabeza -->
          <ellipse cx="55" cy="38" rx="28" ry="28" fill="#1A1A2E"/>
          <!-- Cara blanca -->
          <ellipse cx="55" cy="42" rx="18" ry="18" fill="#FFFFFF"/>
          <!-- Ojo izq -->
          <circle cx="47" cy="36" r="6" fill="#FFFFFF"/>
          <circle cx="47" cy="36" r="3.5" fill="#1A1A2E"/>
          <circle cx="48.5" cy="34.5" r="1.2" fill="#FFFFFF"/>
          <!-- Ojo der -->
          <circle cx="63" cy="36" r="6" fill="#FFFFFF"/>
          <circle cx="63" cy="36" r="3.5" fill="#1A1A2E"/>
          <circle cx="64.5" cy="34.5" r="1.2" fill="#FFFFFF"/>
          <!-- Pico -->
          <ellipse cx="55" cy="48" rx="6" ry="4" fill="#FF9600"/>
          <!-- Ala izq -->
          <ellipse cx="20" cy="75" rx="10" ry="22" fill="#1A1A2E" transform="rotate(-15 20 75)"/>
          <!-- Ala der -->
          <ellipse cx="90" cy="75" rx="10" ry="22" fill="#1A1A2E" transform="rotate(15 90 75)"/>
          <!-- Pies -->
          <ellipse cx="43" cy="120" rx="12" ry="6" fill="#FF9600"/>
          <ellipse cx="67" cy="120" rx="12" ry="6" fill="#FF9600"/>
          <!-- Gorra (enfermería) -->
          <rect x="34" y="14" width="42" height="10" rx="5" fill="#FFFFFF"/>
          <rect x="51" y="8" width="8" height="20" rx="4" fill="#FF4B4B"/>
          <rect x="34" y="16" width="42" height="4" rx="2" fill="#E5E5E5"/>
        </svg>
      </div>
      <h1 class="titulo-auth">Bienvenido a<br>SmashCode</h1>
      <p class="subtitulo-auth">Aprende inglés médico-clínico y mejora tu comunicación en enfermería.</p>
      <div class="etiquetas-auth">
        <span class="etiqueta-auth">⚡ Gamificado</span>
        <span class="etiqueta-auth">📚 6 Niveles</span>
        <span class="etiqueta-auth">✅ SENA</span>
      </div>
    </div>

    <!-- Panel del formulario -->
    <div class="panel-auth-der" style="position: relative;">
      <!-- Enlace para volver al inicio -->
      <a href="<?= PROYECTO_PATH ?>/" style="position: absolute; top: 20px; right: 24px; color: var(--gris-medio); font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--verde-acento)'" onmouseout="this.style.color='var(--gris-medio)'">
        <i class="fas fa-arrow-left" style="margin-right: 4px;"></i> Volver al Inicio
      </a>

      <h2 class="titulo-formulario" style="margin-top: 10px;"><?= $accion === 'registrar' ? 'Crea tu cuenta' : 'Inicia sesión' ?></h2>
      <p class="subtitulo-formulario">Ingresa al mundo del inglés clínico para enfermería.</p>

      <!-- Tabs rol -->
      <div class="tabs-rol" role="tablist">
        <button class="tab-rol activo" id="tab-aprendiz" role="tab">Aprendiz</button>
        <button class="tab-rol" id="tab-instructor" role="tab">Instructor</button>
        <button class="tab-rol" id="tab-admin" role="tab">Admin</button>
      </div>

      <!-- Tabs acción -->
      <div class="tabs-accion">
        <button class="tab-accion <?= $accion === 'ingresar'  ? 'activo' : '' ?>" id="btn-ingresar"  type="button">Ingresar</button>
        <button class="tab-accion <?= $accion === 'registrar' ? 'activo' : '' ?>" id="btn-registrar" type="button">Registrarse</button>
      </div>

      <?php if ($error): ?>
        <div class="alerta alerta-error"><i class="fas fa-circle-exclamation"></i><?= $error ?></div>
      <?php endif; ?>
      <?php if ($exito): ?>
        <div class="alerta alerta-exito"><i class="fas fa-circle-check"></i><?= $exito ?></div>
      <?php endif; ?>

      <!-- FORM INGRESAR -->
      <form id="formulario-ingresar" method="POST" action="<?= PROYECTO_PATH ?>/login/ingresar" style="display:<?= $accion==='ingresar'?'block':'none' ?>;" novalidate>
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <input type="hidden" name="accion" value="ingresar">

        <div class="grupo-campo">
          <label class="etiqueta-campo" for="correo-ingreso">Correo</label>
          <div class="contenedor-input">
            <i class="fas fa-envelope icono-input"></i>
            <input type="email" id="correo-ingreso" name="correo" class="campo-input" placeholder="nombre@sena.edu.co" required>
          </div>
        </div>
        <div class="grupo-campo">
          <label class="etiqueta-campo" for="clave-ingreso">Contraseña</label>
          <div class="contenedor-input" style="position:relative;">
            <i class="fas fa-lock icono-input"></i>
            <input type="password" id="clave-ingreso" name="contrasena" class="campo-input" placeholder="Tu contraseña" style="padding-right: 40px;" required>
            <i class="fas fa-eye toggle-password" data-target="clave-ingreso" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:var(--gris-medio); cursor:pointer; font-size:0.9rem; z-index:10; transition:color 0.2s;"></i>
          </div>
        </div>
        <div style="text-align:right; margin-bottom:16px;">
          <a href="<?= PROYECTO_PATH ?>/recuperar" style="font-size:0.8rem; color:var(--azul); font-weight:700;">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn btn-verde">
          <i class="fas fa-right-to-bracket"></i> Ingresar
        </button>
        <div class="separador-o">o ingresa con</div>
        <div class="grupo-botones-social">
          <button type="button" class="btn btn-social"><i class="fab fa-google"></i> Google</button>
          <button type="button" class="btn btn-social"><i class="fab fa-facebook-f"></i> Facebook</button>
        </div>
      </form>

      <!-- FORM REGISTRO -->
      <form id="formulario-registro" method="POST" action="<?= PROYECTO_PATH ?>/login/registrar" style="display:<?= $accion==='registrar'?'block':'none' ?>;" novalidate>
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <input type="hidden" name="accion" value="registrar">

        <div class="grupo-campo">
          <label class="etiqueta-campo" for="nombre-registro">Nombre completo</label>
          <div class="contenedor-input">
            <i class="fas fa-user icono-input"></i>
            <input type="text" id="nombre-registro" name="nombre_completo" class="campo-input" placeholder="p. ej. Ana García" required>
          </div>
        </div>
        <div class="grupo-campo">
          <label class="etiqueta-campo" for="correo-registro">Correo institucional</label>
          <div class="contenedor-input">
            <i class="fas fa-envelope icono-input"></i>
            <input type="email" id="correo-registro" name="correo" class="campo-input" placeholder="nombre@sena.edu.co" required>
          </div>
        </div>
        <div class="grupo-campo">
          <label class="etiqueta-campo" for="ficha-registro">Ficha SENA</label>
          <div class="contenedor-input">
            <i class="fas fa-id-card icono-input"></i>
            <input type="text" id="ficha-registro" name="ficha_sena" class="campo-input" placeholder="p. ej. 2234891">
          </div>
          <span class="ayuda-campo">Número de ficha del programa técnico de enfermería</span>
        </div>
        <div class="grupo-campo">
          <label class="etiqueta-campo" for="programa-registro">Programa</label>
          <div class="contenedor-input">
            <i class="fas fa-graduation-cap icono-input"></i>
            <select id="programa-registro" name="programa_id" class="campo-input" style="padding-left:38px;">
              <option value="">Selecciona tu programa</option>
              <?php foreach ($programas as $p): ?>
                <option value="<?= limpiar($p['id']) ?>"><?= limpiar($p['nombre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="grupo-campo">
          <label class="etiqueta-campo" for="clave-registro">Contraseña</label>
          <div class="contenedor-input" style="position:relative;">
            <i class="fas fa-lock icono-input"></i>
            <input type="password" id="clave-registro" name="contrasena" class="campo-input" placeholder="Mín. 8 caracteres" style="padding-right: 40px;" required>
            <i class="fas fa-eye toggle-password" data-target="clave-registro" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:var(--gris-medio); cursor:pointer; font-size:0.9rem; z-index:10; transition:color 0.2s;"></i>
          </div>
          <span class="ayuda-campo">Incluye al menos 1 mayúscula y 1 número</span>
        </div>

        <button type="submit" class="btn btn-verde">
          <i class="fas fa-user-plus"></i> Crear cuenta
        </button>
        <div class="separador-o">o regístrate con</div>
        <div class="grupo-botones-social">
          <button type="button" class="btn btn-social"><i class="fab fa-google"></i> Google</button>
          <button type="button" class="btn btn-social"><i class="fab fa-facebook-f"></i> Facebook</button>
        </div>
        <p style="font-size:0.72rem; color:var(--gris-medio); text-align:center; margin-top:14px;">
          Al registrarte aceptas nuestros <a href="#" style="color:var(--azul); font-weight:700;">Términos de Servicio</a> y <a href="#" style="color:var(--azul); font-weight:700;">Política de Privacidad</a>.
        </p>
      </form>
    </div>
  </div>
</main>
<script src="<?= PROYECTO_PATH ?>/assets/js/login.js"></script>
<script src="<?= PROYECTO_PATH ?>/assets/js/tema.js"></script>
</body>
</html>
