<?php
require_once 'config.php';
require_once '../error_log.php';

// Función para registrar un préstamo (con transacción)
function registrarPrestamo($conn, $usuario_id, $libro_id) {
    try {
        // Iniciar transacción
        mysqli_begin_transaction($conn);
        
        // Verificar disponibilidad del libro
        $sql_check = "SELECT cantidad_disponible FROM libros WHERE id = ? FOR UPDATE";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $libro_id);
        mysqli_stmt_execute($stmt_check);
        $resultado = mysqli_stmt_get_result($stmt_check);
        $libro = mysqli_fetch_assoc($resultado);
        
        if (!$libro || $libro['cantidad_disponible'] <= 0) {
            throw new Exception("Libro no disponible para préstamo");
        }
        
        // Registrar el préstamo
        $sql_prestamo = "INSERT INTO prestamos (usuario_id, libro_id, estado) VALUES (?, ?, 'activo')";
        $stmt_prestamo = mysqli_prepare($conn, $sql_prestamo);
        mysqli_stmt_bind_param($stmt_prestamo, "ii", $usuario_id, $libro_id);
        
        if (!mysqli_stmt_execute($stmt_prestamo)) {
            throw new Exception("Error al registrar préstamo: " . mysqli_stmt_error($stmt_prestamo));
        }
        
        $prestamo_id = mysqli_insert_id($conn);
        
        // Actualizar cantidad disponible
        $sql_update = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "i", $libro_id);
        
        if (!mysqli_stmt_execute($stmt_update)) {
            throw new Exception("Error al actualizar cantidad: " . mysqli_stmt_error($stmt_update));
        }
        
        // Confirmar transacción
        mysqli_commit($conn);
        echo "Préstamo registrado exitosamente. ID: " . $prestamo_id . "<br>";
        
        mysqli_stmt_close($stmt_check);
        mysqli_stmt_close($stmt_prestamo);
        mysqli_stmt_close($stmt_update);
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para listar préstamos activos con JOIN
function listarPrestamosActivos($conn, $pagina = 1, $por_pagina = 10) {
    try {
        $offset = ($pagina - 1) * $por_pagina;
        $sql = "SELECT p.id, u.nombre AS usuario, l.titulo AS libro, p.fecha_prestamo 
                FROM prestamos p 
                INNER JOIN usuarios u ON p.usuario_id = u.id 
                INNER JOIN libros l ON p.libro_id = l.id 
                WHERE p.estado = 'activo' 
                ORDER BY p.fecha_prestamo DESC 
                LIMIT ?, ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ii", $offset, $por_pagina);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Préstamos Activos</h3>";
        
        if (mysqli_num_rows($resultado) > 0) {
            while ($prestamo = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $prestamo['id'] . " - ";
                echo "Usuario: " . $prestamo['usuario'] . " - ";
                echo "Libro: " . $prestamo['libro'] . " - ";
                echo "Fecha: " . $prestamo['fecha_prestamo'] . "<br>";
            }
        } else {
            echo "No hay préstamos activos.<br>";
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error al listar préstamos: " . $e->getMessage() . "<br>";
    }
}

// Función para registrar devolución (con transacción)
function registrarDevolucion($conn, $prestamo_id) {
    try {
        // Iniciar transacción
        mysqli_begin_transaction($conn);
        
        // Obtener información del préstamo
        $sql_get = "SELECT libro_id FROM prestamos WHERE id = ? AND estado = 'activo'";
        $stmt_get = mysqli_prepare($conn, $sql_get);
        mysqli_stmt_bind_param($stmt_get, "i", $prestamo_id);
        mysqli_stmt_execute($stmt_get);
        $resultado = mysqli_stmt_get_result($stmt_get);
        $prestamo = mysqli_fetch_assoc($resultado);
        
        if (!$prestamo) {
            throw new Exception("Préstamo no encontrado o ya devuelto");
        }
        
        // Actualizar estado del préstamo
        $sql_update_prestamo = "UPDATE prestamos SET estado = 'devuelto', fecha_devolucion = NOW() WHERE id = ?";
        $stmt_update_prestamo = mysqli_prepare($conn, $sql_update_prestamo);
        mysqli_stmt_bind_param($stmt_update_prestamo, "i", $prestamo_id);
        
        if (!mysqli_stmt_execute($stmt_update_prestamo)) {
            throw new Exception("Error al actualizar préstamo: " . mysqli_stmt_error($stmt_update_prestamo));
        }
        
        // Incrementar cantidad disponible
        $sql_update_libro = "UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = ?";
        $stmt_update_libro = mysqli_prepare($conn, $sql_update_libro);
        mysqli_stmt_bind_param($stmt_update_libro, "i", $prestamo['libro_id']);
        
        if (!mysqli_stmt_execute($stmt_update_libro)) {
            throw new Exception("Error al actualizar libro: " . mysqli_stmt_error($stmt_update_libro));
        }
        
        // Confirmar transacción
        mysqli_commit($conn);
        echo "Devolución registrada exitosamente.<br>";
        
        mysqli_stmt_close($stmt_get);
        mysqli_stmt_close($stmt_update_prestamo);
        mysqli_stmt_close($stmt_update_libro);
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para mostrar historial de préstamos por usuario
function historialPrestamosUsuario($conn, $usuario_id) {
    try {
        $sql = "SELECT p.id, l.titulo AS libro, p.fecha_prestamo, p.fecha_devolucion, p.estado 
                FROM prestamos p 
                INNER JOIN libros l ON p.libro_id = l.id 
                WHERE p.usuario_id = ? 
                ORDER BY p.fecha_prestamo DESC";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Historial de Préstamos - Usuario ID: " . $usuario_id . "</h3>";
        
        if (mysqli_num_rows($resultado) > 0) {
            while ($prestamo = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $prestamo['id'] . " - ";
                echo "Libro: " . $prestamo['libro'] . " - ";
                echo "Préstamo: " . $prestamo['fecha_prestamo'] . " - ";
                echo "Devolución: " . ($prestamo['fecha_devolucion'] ?? 'Pendiente') . " - ";
                echo "Estado: " . $prestamo['estado'] . "<br>";
            }
        } else {
            echo "No hay préstamos registrados para este usuario.<br>";
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error al mostrar historial: " . $e->getMessage() . "<br>";
    }
}

// Ejemplos de uso
echo "<h2>Sistema de Gestión de Préstamos - MySQLi</h2>";

// Registrar un préstamo
registrarPrestamo($conn, 1, 4);

echo "<br>";

// Listar préstamos activos
listarPrestamosActivos($conn, 1, 5);

echo "<br>";

// Registrar devolución
registrarDevolucion($conn, 1);

echo "<br>";

// Mostrar historial de un usuario
historialPrestamosUsuario($conn, 1);

mysqli_close($conn);
?>