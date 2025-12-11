<?php
class librosManager {
    private $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas las tareas
    public function getAlllibros() {
        $stmt = $this->db->query("SELECT * FROM libros ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva tarea
    public function createlibros($libros) {
         try {
            $stmt = $this->db->prepare("INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible, categoria, estado, descripcion, id_usuario, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $libros->titulo,
                $libros->autor,
                $libros->isbn,
                $libros->anio_publicacion,
                $libros->cantidad_disponible,
                $libros->categoria,
                $libros->estado,
                $libros->descripcion,
                $libros->id_usuario,
                $libros->fecha_registro,
            ]);
        } catch (PDOException $e) {
            error_log("Error al crear libro: " . $e->getMessage());
            throw $e;
        }
    }

    // Método para cambiar el estado de una tarea (completada/no completada)
    public function togglelibros($id) {
        $stmt = $this->db->prepare("UPDATE libros SET is_completed = NOT is_completed WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Método para eliminar una tarea
    public function deletelibros($id) {
        $stmt = $this->db->prepare("DELETE FROM libros WHERE id = ?");
        return $stmt->execute([$id]);
    }
}