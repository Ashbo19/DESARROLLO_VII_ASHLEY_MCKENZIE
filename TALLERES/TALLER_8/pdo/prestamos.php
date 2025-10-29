<?php
require_once 'config.php';
require_once '../error_log.php';

// Función para registrar un préstamo (con transacción)
function registrarPrestamo($pdo, $usuario_id, $libro_id) {
    try {
        // Iniciar transacción
        $pdo->beginTransaction();
        
        // Verificar disponibilidad del libro
        $sql_check = "SELECT cantidad_disponible FROM libros WHERE id = :libro_id FOR UPDATE";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([':libro_id' => $libro_id]);
        $libro = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if (!$libro || $libro['cantidad_disponible'] <= 0) {
            throw new Exception("Libro no disponible para préstamo");
        }
        
        // Registrar el préstamo
        $sql_prestamo = "INSERT INTO prestamos (usuario_id, libro_id, estado) VALUES (:usuario_id, :libro_id, 'activo')";
        $stmt_prestamo = $pdo->prepare($sql_prestamo);
        $stmt_prestamo->execute([
            ':usuario_id' => $usuario_id,
            ':libro_id' => $libro_id
        ]);
        
        $prestamo_id = $pdo->lastInsertId();
        
        // Actualizar cantidad disponible
        $sql_update = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = :libro_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([':libro_id' => $libro_id]);
        
        // Confirmar transacción
        $pdo->commit();
        echo "Préstamo registrado exitosamente. ID: " . $prestamo_id . "<br>";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para listar préstamos activos con JOIN
function listarPrestamosActivos($pdo, $pagina = 1, $por_pagina = 10) {
    try {
        $offset = ($pagina - 1) * $por_pagina;
        $sql = "SELECT p.id, u.nombre AS usuario, l.titulo AS libro, p.fecha_prestamo 
                FROM prestamos p 
                INNER JOIN usuarios u ON p.usuario_id = u.id 
                INNER JOIN libros l ON p.libro_id = l.id 
                WHERE p.estado = 'activo' 
                ORDER BY p.fecha_prestamo DESC 
                LIMIT :offset, :por_pagina";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        
        echo "<h3>Préstamos Activos</h3>";
        
        if ($stmt->rowCount() > 0) {
            while ($prestamo = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "ID: " . $prestamo['id'] . " - ";
                echo "Usuario: " . $prestamo['usuario'] . " - ";
                echo "Libro: " . $prestamo['libro'] . " - ";
                echo "Fecha: " . $prestamo['fecha_prestamo'] . "<br>";
            }
        } else {
            echo "No hay préstamos activos.<br>";
        }
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al listar préstamos: " . $e->getMessage() . "<br>";
    }
}

// Función para registrar devolución (con transacción)
function registrarDevolucion($pdo, $prestamo_id) {
    try {
        // Iniciar transacción
        $pdo->beginTransaction();
        
        // Obtener información del préstamo
        $sql_get = "SELECT libro_id FROM prestamos WHERE id = :prestamo_id AND estado = 'activo'";
        $stmt_get = $pdo->prepare($sql_get);
        $stmt_get->execute([':prestamo_id' => $prestamo_id]);
        $prestamo = $stmt_get->fetch(PDO::FETCH_ASSOC);
        
        if (!$prestamo) {
            throw new Exception("Préstamo no encontrado o ya devuelto");
        }
        
        // Actualizar estado del préstamo
        $sql_update_prestamo = "UPDATE prestamos SET estado = 'devuelto', fecha_devolucion = NOW() WHERE id = :prestamo_id";
        $stmt_update_prestamo = $pdo->prepare($sql_update_prestamo);
        $stmt_update_prestamo->execute([':prestamo_id' => $prestamo_id]);
        
        // Incrementar cantidad disponible
        $sql_update_libro = "UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = :libro_id";
        $stmt_update_libro = $pdo->prepare($sql_update_libro);
        $stmt_update_libro->execute([':libro_id' => $prestamo['libro_id']]);
        
        // Confirmar transacción
        $pdo->commit();
        echo "Devolución registrada exitosamente.<br>";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para mostrar historial de préstamos por usuario
function historialPrestamosUsuario($pdo, $usuario_id) {
    try {
        $sql = "SELECT p.id, l.titulo AS libro, p.fecha_prestamo, p.fecha_devolucion, p.estado 
                FROM prestamos p 
                INNER JOIN libros l ON p.libro_id = l.id 
                WHERE p.usuario_id = :usuario_id 
                ORDER BY p.fecha_prestamo DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        
        echo "<h3>Historial de Préstamos - Usuario ID: " . $usuario_id . "</h3>";
        
        if ($stmt->rowCount() > 0) {
            while ($prestamo = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "ID: " . $prestamo['id'] . " - ";
                echo "Libro: " . $prestamo['libro'] . " - ";
                echo "Préstamo: " . $prestamo['fecha_prestamo'] . " - ";
                echo "Devolución: " . ($prestamo['fecha_devolucion'] ?? 'Pendiente') . " - ";
                echo "Estado: " . $prestamo['estado'] . "<br>";
            }
        } else {
            echo "No hay préstamos registrados para este usuario.<br>";
        }
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al mostrar historial: " . $e->getMessage() . "<br>";
    }
}

// Ejemplos de uso
echo "<h2>Sistema de Gestión de Préstamos - PDO</h2>";

// Registrar un préstamo
registrarPrestamo($pdo, 1, 4);

echo "<br>";

// Listar préstamos activos
listarPrestamosActivos($pdo, 1, 5);

echo "<br>";

// Registrar devolución
registrarDevolucion($pdo, 1);

echo "<br>";

// Mostrar historial de un usuario
historialPrestamosUsuario($pdo, 1);
?>