<?php
/**
 * correo.php — Funciones para envío de correos usando PHPMailer
 */
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo(string $destinatario, string $asunto, string $cuerpo): bool {
    $mail = new PHPMailer(true);
    try {
        // Configuración para Gmail SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        // 👇 Coloca tu correo de Gmail y la Contraseña de Aplicación aquí 👇
        $mail->Username   = 'santiagolizcanosuarez@gmail.com'; // O el correo que usen para enviar
        $mail->Password   = 'AQUI_VA_TU_CONTRASENA_DE_APLICACION'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente y destinatario
        $mail->setFrom('no-reply@smashcode.edu.co', 'SmashCode SENA');
        $mail->addAddress($destinatario);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->AltBody = strip_tags($cuerpo);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("No se pudo enviar el correo a $destinatario. Error: {$mail->ErrorInfo}");
        return false;
    }
}
