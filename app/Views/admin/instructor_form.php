<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nuevo Instructor — Admin SmashCode</title>
  <link rel="stylesheet" href="<?= PROYECTO_PATH ?>/assets/css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="contenedor-app">

  <!-- Barra lateral -->
  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="contenido-principal">
    <header class="barra-superior">
      <div class="stat-xp"><i class="fas fa-chalkboard-teacher"></i> Nuevo Instructor</div>
      <div class="avatar-usuario"><?= strtoupper(substr($_SESSION['nombre'], 0, 1)) ?></div>
    </header>

    <div class="pagina-contenido">
      <div style="max-width: 620px; margin: 0 auto;">

        <!-- Migas de pan -->
        <nav style="font-size: 0.78rem; color: var(--gris-medio); margin-bottom: 20px;">
          <a href="<?= PROYECTO_PATH ?>/admin" style="color:var(--verde);">Dashboard</a>
          <i class="fas fa-chevron-right" style="font-size:0.6rem; margin: 0 6px;"></i>
          <a href="<?= PROYECTO_PATH ?>/admin/usuarios" style="color:var(--verde);">Usuarios</a>
          <i class="fas fa-chevron-right" style="font-size:0.6rem; margin: 0 6px;"></i>
          <span>Nuevo Instructor</span>
        </nav>

        <h1 class="pagina-titulo">
          <i class="fas fa-chalkboard-teacher" style="color:var(--azul);"></i>
          Crear Cuenta de Instructor
        </h1>
        <p class="pagina-subtitulo" style="margin-bottom:24px;">
          El sistema generará automáticamente una contraseña temporal y la enviará al correo del instructor.
          Deberá cambiarla en su primer inicio de sesión.
        </p>

        <?php if ($error): ?>
          <div class="alerta alerta-error"><i class="fas fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Aviso del flujo -->
        <div class="alerta alerta-info" style="margin-bottom: 24px;">
          <i class="fas fa-circle-info" style="font-size:1.1rem;"></i>
          <div>
            <strong>¿Cómo funciona?</strong><br>
            Al crear la cuenta, el sistema genera una contraseña aleatoria y segura, la guarda hasheada en la base de datos y
            envía un correo al instructor con sus credenciales. En su primer login se le pedirá que cambie la contraseña.
          </div>
        </div>

        <div class="tarjeta" style="margin-top: 0;">
          <form method="POST" action="<?= PROYECTO_PATH ?>/admin/usuarios/instructor/guardar" novalidate>
            <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">

            <!-- Nombre -->
            <div class="grupo-campo">
              <label class="etiqueta-campo" for="nombre_completo">Nombre Completo *</label>
              <div class="contenedor-input">
                <i class="fas fa-user icono-input"></i>
                <input type="text" id="nombre_completo" name="nombre_completo" class="campo-input"
                       placeholder="Ej: Carlos Andrés Gómez" required
                       value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>">
              </div>
            </div>

            <!-- Correo -->
            <div class="grupo-campo">
              <label class="etiqueta-campo" for="correo">Correo Electrónico Institucional *</label>
              <div class="contenedor-input">
                <i class="fas fa-envelope icono-input"></i>
                <input type="email" id="correo" name="correo" class="campo-input"
                       placeholder="instructor@sena.edu.co" required
                       value="<?= htmlspecialchars($datos['correo'] ?? '') ?>">
              </div>
              <span class="ayuda-campo">Se enviará la contraseña temporal a este correo.</span>
            </div>

            <!-- Programa Asignado -->
            <div class="grupo-campo">
              <label class="etiqueta-campo" for="programa_asignado">
                Programa Asignado <span style="color:var(--gris-medio); font-weight:400;">(Opcional)</span>
              </label>
              <div class="contenedor-input">
                <i class="fas fa-laptop-code icono-input"></i>
                <input type="text" id="programa_asignado" name="programa_asignado" class="campo-input"
                       placeholder="Ej: Análisis y Desarrollo de Software"
                       value="<?= htmlspecialchars($datos['programa'] ?? '') ?>">
              </div>
            </div>

            <!-- Info contraseña -->
            <div style="background: rgba(88,204,2,0.08); border: 2px solid rgba(88,204,2,0.25); border-radius: var(--radio-sm); padding: 14px 18px; margin-bottom: 20px; font-size: 0.82rem; color: var(--gris-texto);">
              <i class="fas fa-key" style="color:var(--verde); margin-right:6px;"></i>
              <strong>Contraseña temporal:</strong> Se generará automáticamente una contraseña segura de 12 caracteres
              (mayúsculas, números y símbolos) y se enviará al correo del instructor.
            </div>

            <div style="display: flex; gap: 10px; margin-top: 8px;">
              <button type="submit" class="btn btn-azul" style="flex:1;">
                <i class="fas fa-paper-plane"></i> Crear y Enviar Credenciales
              </button>
              <a href="<?= PROYECTO_PATH ?>/admin/usuarios" class="btn btn-blanco" style="flex-shrink:0; width:auto; padding: 13px 20px;">
                <i class="fas fa-arrow-left"></i> Cancelar
              </a>
            </div>
          </form>
        </div><!-- /tarjeta -->
      </div>
    </div><!-- /pagina-contenido -->
  </main>
</div>
</body>
</html>
