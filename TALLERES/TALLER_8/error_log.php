<?php
// Función para registrar errores en un archivo de log
function registrarError($mensaje, $archivo = "errores.log") {
    $fecha = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
    $logMensaje = "[$fecha] [IP: $ip] $mensaje" . PHP_EOL;
    
    file_put_contents($archivo, $logMensaje, FILE_APPEND);
}
?>