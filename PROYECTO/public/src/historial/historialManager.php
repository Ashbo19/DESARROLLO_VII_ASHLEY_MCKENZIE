<?php
class HistorialManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllHistorial() {
        $stmt = $this->db->query("
            SELECT h.*, 
                   i.estado as estado_intercambio,
                   u1.nombre as nombre_solicitante,
                   u2.nombre as nombre_ofertante,
                   l1.titulo as titulo_solicitado,
                   l2.titulo as titulo_ofrecido
            FROM historial_intercambios h
            LEFT JOIN intercambio i ON h.id_intercambio = i.id_intercambio
            LEFT JOIN usuarios u1 ON i.id_solicitante = u1.id_usuario
            LEFT JOIN usuarios u2 ON i.id_ofertante = u2.id_usuario
            LEFT JOIN libros l1 ON i.id_libro_solicitado = l1.id_libro
            LEFT JOIN libros l2 ON i.id_libro_ofrecido = l2.id_libro
            ORDER BY h.fecha DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createHistorial($historial) {
        try {
            $stmt = $this->db->prepare("INSERT INTO historial_intercambios (id_intercambio, fecha, resultado) VALUES (?, ?, ?)");
            return $stmt->execute([
                $historial->id_intercambio,
                $historial->fecha,
                $historial->resultado
            ]);
        } catch (PDOException $e) {
            error_log("Error al crear historial: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteHistorial($id) {
        $stmt = $this->db->prepare("DELETE FROM historial_intercambios WHERE id_historial = ?");
        return $stmt->execute([$id]);
    }
}