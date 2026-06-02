<?php
/**
 * credenciales.php
 * Configuración del entorno local (Ignorado por Git por motivos de seguridad).
 */

// Base de Datos
define('DB_HOST', 'localhost');
define('DB_NOMBRE', 'smash_code');
define('DB_USUARIO', 'root');
define('DB_CLAVE', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración de SMTP (Gmail)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'smascode@gmail.com');
define('SMTP_PASS', ''); // Tu Contraseña de Aplicación de Gmail
define('SMTP_PORT', 587);

// Configuración de JWT
define('JWT_SECRET', 'SmashCode@SENA_2026_JWT_SecretKey!');
