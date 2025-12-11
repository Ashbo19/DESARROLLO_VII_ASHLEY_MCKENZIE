<?php
class intercambioManager {
    private $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas las tareas
    public function getAllIntercambio() {
        $stmt = $this->db->query("
            SELECT i.*, 
                   u1.nombre as nombre_solicitante,
                   u2.nombre as nombre_ofertante,
                   l1.titulo as titulo_solicitado,
                   l2.titulo as titulo_ofrecido
            FROM intercambio i
            LEFT JOIN usuarios u1 ON i.id_solicitante = u1.id_usuario
            LEFT JOIN usuarios u2 ON i.id_ofertante = u2.id_usuario
            LEFT JOIN libros l1 ON i.id_libro_solicitado = l1.id_libro
            LEFT JOIN libros l2 ON i.id_libro_ofrecido = l2.id_libro
            ORDER BY i.fecha_intercambio DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIntercambioById($id) {
        $stmt = $this->db->prepare("
            SELECT i.*, 
                   u1.nombre as nombre_solicitante,
                   u2.nombre as nombre_ofertante,
                   l1.titulo as titulo_solicitado,
                   l2.titulo as titulo_ofrecido
            FROM intercambio i
            LEFT JOIN usuarios u1 ON i.id_solicitante = u1.id_usuario
            LEFT JOIN usuarios u2 ON i.id_ofertante = u2.id_usuario
            LEFT JOIN libros l1 ON i.id_libro_solicitado = l1.id_libro
            LEFT JOIN libros l2 ON i.id_libro_ofrecido = l2.id_libro
            WHERE i.id_intercambio = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva tarea
    public function createintercambio($intercambio) {
        try {
            $stmt = $this->db->prepare("INSERT INTO intercambio (id_solicitante, id_ofertante, id_libro_solicitado, id_libro_ofrecido, fecha_intercambio, estado) VALUES (?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $intercambio->id_solicitante,
                $intercambio->id_ofertante,
                $intercambio->id_libro_solicitado,
                $intercambio->id_libro_ofrecido,
                $intercambio->fecha_intercambio,
                $intercambio->estado
            ]);
        } catch (PDOException $e) {
            error_log("Error al crear intercambio: " . $e->getMessage());
            throw $e;
        }
    }

    // Método para cambiar el estado de una tarea (completada/no completada)
    public function updateEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE intercambio SET estado = ? WHERE id_intercambio = ?");
        return $stmt->execute([$estado, $id]);
    }

    // Metodo para eliminar
    public function deleteIntercambio($id) {
        $stmt = $this->db->prepare("DELETE FROM intercambio WHERE id_intercambio = ?");
        return $stmt->execute([$id]);
    }
}