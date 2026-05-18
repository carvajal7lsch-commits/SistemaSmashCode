<?php
namespace App\Core;

/**
 * Autoloader.php
 * Cargador automático de clases basado en namespaces PSR-4 para evitar imports manuales.
 * Mapea el namespace 'App\' a la carpeta 'app/'.
 */
class Autoloader {
    public static function registrar(): void {
        spl_autoload_register(function (string $clase) {
            // El namespace esperado es App\NombreClase o App\Carpeta\NombreClase
            $prefijo = 'App\\';
            $longitudPrefijo = strlen($prefijo);

            // Verificar si la clase usa nuestro prefijo de namespace
            if (strncmp($prefijo, $clase, $longitudPrefijo) !== 0) {
                return;
            }

            // Obtener el nombre relativo de la clase (quitando 'App\')
            $claseRelativa = substr($clase, $longitudPrefijo);

            // Reemplazar separadores de namespace (\) con separadores de directorio (/)
            // y concatenar con la extensión .php en la carpeta 'app/'
            $archivo = dirname(__DIR__) . '/' . str_replace('\\', '/', $claseRelativa) . '.php';

            // Si el archivo existe, cargarlo
            if (file_exists($archivo)) {
                require_once $archivo;
            }
        });
    }
}
