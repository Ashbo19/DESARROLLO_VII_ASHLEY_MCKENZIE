<?php
class intercambioManager {
    private $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas las tareas
    public function getAllintercambio() {
        $stmt = $this->db->query("SELECT * FROM intercambio ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva tarea
    public function createintercambio($intercambio) {
        $stmt = $this->db->prepare("INSERT INTO intercambio (id_intercambio, id_solicitante, id_ofertante, id_libro_solicitado, id_libro_ofrecido, fecha_intercambio, estado) VALUES (?,?,?,?,?,?,?)");
        return $stmt->execute([
            'id intercambio'=>$intercambio->id_intercambio,
            'id solicitante'=>$intercambio->id_solicitante,
            'id ofertante'=>$intercambio->id_ofertante,
            'id libro solicitado'=>$intercambio->id_libro_solicitado,
            'id_libro_ofrecido'=>$intercambio->id_libro_ofrecido,
            'fecha intercambio'=>$intercambio->fecha_intercambio,
            'estado'=>$intercambio->estado,
        
        ]);
    }

    // Método para cambiar el estado de una tarea (completada/no completada)
    public function toggleintercambio($id) {
        $stmt = $this->db->prepare("UPDATE intercambio SET is_completed = NOT is_completed WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Método para eliminar una tarea
    public function deleteintercambio($id) {
        $stmt = $this->db->prepare("DELETE FROM intercambio WHERE id = ?");
        return $stmt->execute([$id]);
    }
}