<?php
require_once 'config.php';
require_once '../error_log.php';

// Función para listar todos los usuarios con paginación
function listarUsuarios($conn, $pagina = 1, $por_pagina = 10) {
    try {
        $offset = ($pagina - 1) * $por_pagina;
        $sql = "SELECT id, nombre, email, fecha_registro FROM usuarios ORDER BY nombre LIMIT ?, ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ii", $offset, $por_pagina);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Lista de Usuarios</h3>";
        
        if (mysqli_num_rows($resultado) > 0) {
            while ($usuario = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $usuario['id'] . " - ";
                echo "Nombre: " . $usuario['nombre'] . " - ";
                echo "Email: " . $usuario['email'] . " - ";
                echo "Registro: " . $usuario['fecha_registro'] . "<br>";
            }
        } else {
            echo "No hay usuarios registrados.<br>";
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error al listar usuarios: " . $e->getMessage() . "<br>";
    }
}

// Función para registrar un nuevo usuario
function registrarUsuario($conn, $nombre, $email, $contrasena) {
    try {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }
        
        // Hash de la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $contrasena_hash);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario registrado exitosamente. ID: " . mysqli_insert_id($conn) . "<br>";
        } else {
            throw new Exception("Error al registrar usuario: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para buscar usuarios
function buscarUsuarios($conn, $termino) {
    try {
        $termino_busqueda = "%" . $termino . "%";
        $sql = "SELECT id, nombre, email FROM usuarios WHERE nombre LIKE ? OR email LIKE ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ss", $termino_busqueda, $termino_busqueda);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Resultados de búsqueda para: " . $termino . "</h3>";
        
        if (mysqli_num_rows($resultado) > 0) {
            while ($usuario = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $usuario['id'] . " - ";
                echo "Nombre: " . $usuario['nombre'] . " - ";
                echo "Email: " . $usuario['email'] . "<br>";
            }
        } else {
            echo "No se encontraron usuarios.<br>";
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error en la búsqueda: " . $e->getMessage() . "<br>";
    }
}

// Función para actualizar información de un usuario
function actualizarUsuario($conn, $id, $nombre, $email) {
    try {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }
        
        $sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario actualizado exitosamente.<br>";
        } else {
            throw new Exception("Error al actualizar usuario: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para eliminar un usuario
function eliminarUsuario($conn, $id) {
    try {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario eliminado exitosamente.<br>";
        } else {
            throw new Exception("Error al eliminar usuario: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Ejemplos de uso
echo "<h2>Sistema de Gestión de Usuarios - MySQLi</h2>";

// Listar usuarios
listarUsuarios($conn, 1, 5);

echo "<br>";

// Registrar un nuevo usuario
registrarUsuario($conn, "Ana Martínez", "ana@example.com", "password321");

echo "<br>";

// Buscar usuarios
buscarUsuarios($conn, "Juan");

echo "<br>";

// Actualizar un usuario
actualizarUsuario($conn, 1, "Juan Pérez García", "juan.perez@example.com");

mysqli_close($conn);
?>