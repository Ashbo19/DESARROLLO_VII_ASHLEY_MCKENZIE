<?php
require_once 'config.php';
require_once '../error_log.php';

// Función para listar todos los usuarios con paginación
function listarUsuarios($pdo, $pagina = 1, $por_pagina = 10) {
    try {
        $offset = ($pagina - 1) * $por_pagina;
        $sql = "SELECT id, nombre, email, fecha_registro FROM usuarios ORDER BY nombre LIMIT :offset, :por_pagina";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        
        echo "<h3>Lista de Usuarios</h3>";
        
        if ($stmt->rowCount() > 0) {
            while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "ID: " . $usuario['id'] . " - ";
                echo "Nombre: " . $usuario['nombre'] . " - ";
                echo "Email: " . $usuario['email'] . " - ";
                echo "Registro: " . $usuario['fecha_registro'] . "<br>";
            }
        } else {
            echo "No hay usuarios registrados.<br>";
        }
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al listar usuarios: " . $e->getMessage() . "<br>";
    }
}

// Función para registrar un nuevo usuario
function registrarUsuario($pdo, $nombre, $email, $contrasena) {
    try {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }
        
        // Hash de la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':contrasena' => $contrasena_hash
        ]);
        
        echo "Usuario registrado exitosamente. ID: " . $pdo->lastInsertId() . "<br>";
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al registrar usuario: " . $e->getMessage() . "<br>";
    }
}

// Función para buscar usuarios
function buscarUsuarios($pdo, $termino) {
    try {
        $termino_busqueda = "%" . $termino . "%";
        $sql = "SELECT id, nombre, email FROM usuarios WHERE nombre LIKE :termino OR email LIKE :termino";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':termino' => $termino_busqueda]);
        
        echo "<h3>Resultados de búsqueda para: " . $termino . "</h3>";
        
        if ($stmt->rowCount() > 0) {
            while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "ID: " . $usuario['id'] . " - ";
                echo "Nombre: " . $usuario['nombre'] . " - ";
                echo "Email: " . $usuario['email'] . "<br>";
            }
        } else {
            echo "No se encontraron usuarios.<br>";
        }
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error en la búsqueda: " . $e->getMessage() . "<br>";
    }
}

// Función para actualizar información de un usuario
function actualizarUsuario($pdo, $id, $nombre, $email) {
    try {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }
        
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':id' => $id
        ]);
        
        echo "Usuario actualizado exitosamente.<br>";
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al actualizar usuario: " . $e->getMessage() . "<br>";
    }
}

// Función para eliminar un usuario
function eliminarUsuario($pdo, $id) {
    try {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        echo "Usuario eliminado exitosamente.<br>";
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al eliminar usuario: " . $e->getMessage() . "<br>";
    }
}

// Ejemplos de uso
echo "<h2>Sistema de Gestión de Usuarios - PDO</h2>";

// Listar usuarios
listarUsuarios($pdo, 1, 5);

echo "<br>";

// Registrar un nuevo usuario
registrarUsuario($pdo, "Ana Martínez", "ana@example.com", "password321");

echo "<br>";

// Buscar usuarios
buscarUsuarios($pdo, "Juan");

echo "<br>";

// Actualizar un usuario
actualizarUsuario($pdo, 1, "Juan Pérez García", "juan.perez@example.com");
?>