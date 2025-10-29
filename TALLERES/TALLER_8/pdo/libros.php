<?php
require_once 'config.php';
require_once '../error_log.php';

// Función para listar todos los libros con paginación
function listarLibros($pdo, $pagina = 1, $por_pagina = 10) {
    try {
        $offset = ($pagina - 1) * $por_pagina;
        $sql = "SELECT * FROM libros ORDER BY titulo LIMIT :offset, :por_pagina";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        
        echo "<h3>Lista de Libros</h3>";
        
        if ($stmt->rowCount() > 0) {
            while ($libro = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al listar libros: " . $e->getMessage() . "<br>";
    }
}

// Función para añadir un nuevo libro
function anadirLibro($pdo, $titulo, $autor, $isbn, $anio, $cantidad) {
    try {
        $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible) VALUES (:titulo, :autor, :isbn, :anio, :cantidad)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':autor' => $autor,
            ':isbn' => $isbn,
            ':anio' => $anio,
            ':cantidad' => $cantidad
        ]);
        
        echo "Libro añadido exitosamente. ID: " . $pdo->lastInsertId() . "<br>";
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al añadir libro: " . $e->getMessage() . "<br>";
    }
}

// Función para buscar libros
function buscarLibros($pdo, $termino) {
    try {
        $termino_busqueda = "%" . $termino . "%";
        $sql = "SELECT * FROM libros WHERE titulo LIKE :termino OR autor LIKE :termino OR isbn LIKE :termino";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':termino' => $termino_busqueda]);
        
        echo "<h3>Resultados de búsqueda para: " . $termino . "</h3>";
        
        if ($stmt->rowCount() > 0) {
            while ($libro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "ID: " . $libro['id'] . " - ";
                echo "Título: " . $libro['titulo'] . " - ";
                echo "Autor: " . $libro['autor'] . " - ";
                echo "ISBN: " . $libro['isbn'] . "<br>";
            }
        } else {
            echo "No se encontraron libros.<br>";
        }
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error en la búsqueda: " . $e->getMessage() . "<br>";
    }
}

// Función para actualizar información de un libro
function actualizarLibro($pdo, $id, $titulo, $autor, $isbn, $anio, $cantidad) {
    try {
        $sql = "UPDATE libros SET titulo = :titulo, autor = :autor, isbn = :isbn, anio_publicacion = :anio, cantidad_disponible = :cantidad WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':autor' => $autor,
            ':isbn' => $isbn,
            ':anio' => $anio,
            ':cantidad' => $cantidad,
            ':id' => $id
        ]);
        
        echo "Libro actualizado exitosamente.<br>";
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al actualizar libro: " . $e->getMessage() . "<br>";
    }
}

// Función para eliminar un libro
function eliminarLibro($pdo, $id) {
    try {
        $sql = "DELETE FROM libros WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        echo "Libro eliminado exitosamente.<br>";
    } catch (PDOException $e) {
        registrarError($e->getMessage());
        echo "Error al eliminar libro: " . $e->getMessage() . "<br>";
    }
}

// Ejemplos de uso
echo "<h2>Sistema de Gestión de Libros - PDO</h2>";

// Listar libros
listarLibros($pdo, 1, 5);

echo "<br>";

// Añadir un nuevo libro
anadirLibro($pdo, "El amor en los tiempos del cólera", "Gabriel García Márquez", "978-0307389732", 1985, 3);

echo "<br>";

// Buscar libros
buscarLibros($pdo, "García");

echo "<br>";

// Actualizar un libro
actualizarLibro($pdo, 1, "Cien años de soledad (Edición especial)", "Gabriel García Márquez", "978-0307474728", 1967, 7);
?>