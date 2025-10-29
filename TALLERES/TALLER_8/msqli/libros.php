<?php
require_once 'config.php';
require_once '../error_log.php';

// Función para listar todos los libros con paginación
function listarLibros($conn, $pagina = 1, $por_pagina = 10) {
    try {
        $offset = ($pagina - 1) * $por_pagina;
        $sql = "SELECT * FROM libros ORDER BY titulo LIMIT ?, ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "ii", $offset, $por_pagina);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Lista de Libros</h3>";
        
        if (mysqli_num_rows($resultado) > 0) {
            while ($libro = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $libro['id'] . " - ";
                echo "Título: " . $libro['titulo'] . " - ";
                echo "Autor: " . $libro['autor'] . " - ";
                echo "ISBN: " . $libro['isbn'] . " - ";
                echo "Año: " . $libro['anio_publicacion'] . " - ";
                echo "Disponibles: " . $libro['cantidad_disponible'] . "<br>";
            }
        } else {
            echo "No hay libros registrados.<br>";
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error al listar libros: " . $e->getMessage() . "<br>";
    }
}

// Función para añadir un nuevo libro
function anadirLibro($conn, $titulo, $autor, $isbn, $anio, $cantidad) {
    try {
        $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "sssii", $titulo, $autor, $isbn, $anio, $cantidad);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Libro añadido exitosamente. ID: " . mysqli_insert_id($conn) . "<br>";
        } else {
            throw new Exception("Error al añadir libro: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para buscar libros
function buscarLibros($conn, $termino) {
    try {
        $termino_busqueda = "%" . $termino . "%";
        $sql = "SELECT * FROM libros WHERE titulo LIKE ? OR autor LIKE ? OR isbn LIKE ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "sss", $termino_busqueda, $termino_busqueda, $termino_busqueda);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        echo "<h3>Resultados de búsqueda para: " . $termino . "</h3>";
        
        if (mysqli_num_rows($resultado) > 0) {
            while ($libro = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $libro['id'] . " - ";
                echo "Título: " . $libro['titulo'] . " - ";
                echo "Autor: " . $libro['autor'] . " - ";
                echo "ISBN: " . $libro['isbn'] . "<br>";
            }
        } else {
            echo "No se encontraron libros.<br>";
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error en la búsqueda: " . $e->getMessage() . "<br>";
    }
}

// Función para actualizar información de un libro
function actualizarLibro($conn, $id, $titulo, $autor, $isbn, $anio, $cantidad) {
    try {
        $sql = "UPDATE libros SET titulo = ?, autor = ?, isbn = ?, anio_publicacion = ?, cantidad_disponible = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "sssiii", $titulo, $autor, $isbn, $anio, $cantidad, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Libro actualizado exitosamente.<br>";
        } else {
            throw new Exception("Error al actualizar libro: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Función para eliminar un libro
function eliminarLibro($conn, $id) {
    try {
        $sql = "DELETE FROM libros WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Libro eliminado exitosamente.<br>";
        } else {
            throw new Exception("Error al eliminar libro: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        registrarError($e->getMessage());
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Ejemplos de uso
echo "<h2>Sistema de Gestión de Libros - MySQLi</h2>";

// Listar libros
listarLibros($conn, 1, 5);

echo "<br>";

// Añadir un nuevo libro
anadirLibro($conn, "El amor en los tiempos del cólera", "Gabriel García Márquez", "978-0307389732", 1985, 3);

echo "<br>";

// Buscar libros
buscarLibros($conn, "García");

echo "<br>";

// Actualizar un libro
actualizarLibro($conn, 1, "Cien años de soledad (Edición especial)", "Gabriel García Márquez", "978-0307474728", 1967, 7);

mysqli_close($conn);
?>