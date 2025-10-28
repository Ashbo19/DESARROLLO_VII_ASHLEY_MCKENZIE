<?php
require_once "config_pdo.php";

try {
    // 1. Mostrar las últimas 5 publicaciones con el nombre del autor y la fecha de publicación
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC 
            LIMIT 5";

    $stmt = $pdo->query($sql);

    echo "<h3>1. Últimas 5 publicaciones con autor:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
        }
    } else {
        echo "No se encontraron publicaciones.<br>";
    }

    // 2. Listar los usuarios que no han realizado ninguna publicación
    $sql = "SELECT u.id, u.nombre, u.email 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            WHERE p.id IS NULL";

    $stmt = $pdo->query($sql);

    echo "<h3>2. Usuarios sin publicaciones:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: " . $row['id'] . ", Nombre: " . $row['nombre'] . ", Email: " . $row['email'] . "<br>";
        }
    } else {
        echo "Todos los usuarios tienen al menos una publicación.<br>";
    }

    // 3. Calcular el promedio de publicaciones por usuario
    $sql = "SELECT 
                COUNT(DISTINCT u.id) as total_usuarios,
                COUNT(p.id) as total_publicaciones,
                ROUND(COUNT(p.id) / COUNT(DISTINCT u.id), 2) as promedio
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>3. Promedio de publicaciones por usuario:</h3>";
    echo "Total usuarios: " . $row['total_usuarios'] . ", Total publicaciones: " . $row['total_publicaciones'] . ", Promedio: " . $row['promedio'] . "<br>";

    // 4. Encontrar la publicación más reciente de cada usuario
    $sql = "SELECT u.nombre, p.titulo, p.fecha_publicacion
            FROM usuarios u
            INNER JOIN publicaciones p ON u.id = p.usuario_id
            INNER JOIN (
                SELECT usuario_id, MAX(fecha_publicacion) as max_fecha
                FROM publicaciones
                GROUP BY usuario_id
            ) p_max ON p.usuario_id = p_max.usuario_id 
                    AND p.fecha_publicacion = p_max.max_fecha
            ORDER BY p.fecha_publicacion DESC";

    $stmt = $pdo->query($sql);

    echo "<h3>4. Publicación más reciente de cada usuario:</h3>";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Usuario: " . $row['nombre'] . ", Título: " . $row['titulo'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
        }
    } else {
        echo "No se encontraron publicaciones.<br>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>