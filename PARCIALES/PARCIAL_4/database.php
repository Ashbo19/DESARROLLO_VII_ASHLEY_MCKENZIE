<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "techparts_db";

// Crear conexión
$conn = mysqli_connect($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar charset
mysqli_set_charset($conn, "utf8");
?>