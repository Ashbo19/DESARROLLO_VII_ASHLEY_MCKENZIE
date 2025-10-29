<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión de Biblioteca - PDO</title>
</head>
<body>
    <h1>Sistema de Gestión de Biblioteca - PDO</h1>
    
    <h2>Menú Principal</h2>
    <ul>
        <li><a href="libros.php">Gestión de Libros</a></li>
        <li><a href="usuarios.php">Gestión de Usuarios</a></li>
        <li><a href="prestamos.php">Gestión de Préstamos</a></li>
    </ul>
    
    <h3>Información del Sistema</h3>
    <p>Este sistema permite gestionar una biblioteca con las siguientes funcionalidades:</p>
    <ul>
        <li>Añadir, listar, buscar, actualizar y eliminar libros</li>
        <li>Registrar, listar, buscar, actualizar y eliminar usuarios</li>
        <li>Registrar préstamos y devoluciones de libros</li>
        <li>Ver historial de préstamos por usuario</li>
    </ul>
    
    <?php
    // Mostrar estadísticas básicas
    $sql_libros = "SELECT COUNT(*) as total FROM libros";
    $stmt_libros = $pdo->query($sql_libros);
    $total_libros = $stmt_libros->fetch(PDO::FETCH_ASSOC)['total'];
    
    $sql_usuarios = "SELECT COUNT(*) as total FROM usuarios";
    $stmt_usuarios = $pdo->query($sql_usuarios);
    $total_usuarios = $stmt_usuarios->fetch(PDO::FETCH_ASSOC)['total'];
    
    $sql_prestamos = "SELECT COUNT(*) as total FROM prestamos WHERE estado = 'activo'";
    $stmt_prestamos = $pdo->query($sql_prestamos);
    $total_prestamos = $stmt_prestamos->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "<h3>Estadísticas</h3>";
    echo "Total de libros: " . $total_libros . "<br>";
    echo "Total de usuarios: " . $total_usuarios . "<br>";
    echo "Préstamos activos: " . $total_prestamos . "<br>";
    ?>
</body>
</html>