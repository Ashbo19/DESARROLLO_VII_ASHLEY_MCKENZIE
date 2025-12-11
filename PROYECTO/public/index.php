<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the base path for includes
define('BASE_PATH', __DIR__ . '/');

// Include the configuration file
require_once BASE_PATH . 'config.php';

// Include necessary files
require_once BASE_PATH . 'src/Database.php';
require_once BASE_PATH . 'src/libros/librosManager.php';
require_once BASE_PATH . 'src/libros/libros.php';
//require_once BASE_PATH . 'src/libros/views/list.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Intercambio de Libros</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BookUtp</h1>
            <p>Plataforma de Intercambio de Libros</p>
        </div>

        <div class="modules-grid">
            <a href="src/libros/views/list.php" class="module-card">
                <h3>Catálogo de Libros</h3>
                <p>Explora y gestiona el catálogo de libros disponibles para intercambio. Agrega nuevos libros, consulta detalles y encuentra tu próxima lectura.</p>
                <span class="module-status status-active">Activo</span>
            </a>

            <a href="src/solicitud/index.php" class="module-card">
                <h3>Solicitudes de Intercambio</h3>
                <p>Gestiona las solicitudes de intercambio de libros. Envía peticiones, revisa ofertas y acepta o rechaza propuestas.</p>
                <span class="module-status status-development">En desarrollo</span>
            </a>

            <a href="src/intercambio/index.php" class="module-card">
                <h3>Sistema de Trueques</h3>
                <p>Administra los intercambios activos y completados. Coordina entregas y confirma recepciones de libros.</p>
                <span class="module-status status-development">En desarrollo</span>
            </a>

            <a href="src/valoracion/index.php" class="module-card">
                <h3>Valoración de Usuarios</h3>
                <p>Sistema de calificaciones y reseñas de usuarios. Construye tu reputación y consulta la confiabilidad de otros miembros.</p>
                <span class="module-status status-development">En desarrollo</span>
            </a>

            <a href="src/historial/index.php" class="module-card">
                <h3>Historial de Intercambios</h3>
                <p>Consulta el historial completo de todos tus intercambios realizados. Revisa estadísticas y detalles de transacciones pasadas.</p>
                <span class="module-status status-development">En desarrollo</span>
            </a>

            <a href="src/puntos/index.php" class="module-card">
                <h3>Sistema de Puntos</h3>
                <p>Gana puntos por tus intercambios exitosos. Consulta tu ranking y obtén beneficios por ser un miembro activo.</p>
                <span class="module-status status-development">En desarrollo</span>
            </a>
        </div>

        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> BookUtp - Intercambio de Libros. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
